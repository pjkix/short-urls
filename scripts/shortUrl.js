/**
 * JS ShortUrl Handler
 *
 * hijack form , submit url directly if supported , if not proxy throuth the class lib
 * @author pjk
 * @category util
 * @version $Id:$
 */

/*jslint
	bitwise: true, browser: true, eqeqeq: true, immed: true, newcap: true, nomen: true, onevar: true, plusplus: true, regexp: true, undef: true, white: true, indent: 4
*/

/*extern jQuery */
/*global PK_ShortUrl, console, window, xmlhttpRequest*/
/*members addEventListener, checkLink, findTweetLinks, 
    getElementsByTagName, getRequest, getShortUrl, href, init, length, 
    links, log, match, method, onload, parseLink, push, responseText, url
*/

// object wrapper
var PK_ShortUrl = {
	links : '',

	// set it off
	init : function ()
	{
		var links = [], i = 0;
		console.log('ShortUrl script enabled!');
		links = this.findTweetLinks();
		// loop over links and twitify the suburl then replace them
		for (i = 0; i < links.length; i = i + 1) {
			console.log(links[i]);
			this.parseLink(links[i]);
		}

	},
	
	// get a list of links
	findTweetLinks : function ()
	{
		// find links that point to http://twitter.com and contain another link
		var twitLinks = [], links = null, i = 0;
		if (document.getElementsByTagName) { // can we execute
			links = document.getElementsByTagName("A"); // get all links
			for (i = 0; i < links.length; i = i + 1) { // loop
				if (links[i].href.match("http://twitter.com/*")) { // only links we want
					twitLinks.push(links[i]); // save to list
				}
			}
		}
		return twitLinks;
	},
	
	parseLink : function (a)
	{
		// extract href ... decode url ... replace link if not already short
		console.log(a.href);
		var string, url, rxp;
		// string = unescape(a.href);
		string = decodeURIComponent(a.href);
		console.log(string);
		// url = string.replace(/\+(http:\/\/.*[^ ])/g, this.getShortUrl("$1") );
		// var str = 'http://twitter.com/home/?status=fooo+http://tinyurl.com/cy473x+(via+@tweetmeme)'; str.replace(/\+http:\/\/[a-z1-9./]+[^+]/i,'+http://bit.ly/MOFO!');
		rxp =  /\+(http:\/\/[a-z1-9.\/]+[^\+])/;
		// string = string.replace( rxp, "do it to this $1 mofo!" );
		string = string.replace( rxp, this.replacer);
		// matches = string.match( /\+http:\/\/[a-z1-9.\/]+[^+]/i );
		console.log(string, encodeURIComponent(string) );
		
	},
	
	replacer : function ( str, p1, p2, offset, s )
	{
		console.log('REPLACER!!', str);
	  return '+SHORTED!'; // .this don't work
	},
	
	
	checkLink : function (url)
	{	console.log(url);
		// make sure link is not already short
		return url.match(/http:\/\/bit.ly\/.*/i);
	},

	// shorten links
	getShortUrl : function (url)
	{
		// check link then get short
		if (this.checkLink(url) ) {
			// get the short version of the url
			return this.getRequest('http://bit.ly/shorten?url=' + url);
		}
		
	},

	// ajax
	getRequest : function (url, cb) 
	{
		xmlhttpRequest({
			method: "GET",
			url: url,
			onload: function (xhr) 
			{ 
				cb(xhr.responseText); 
			}
		});
	},
	
	callback : function (resp) 
	{
		// 
	}, 
	
	// workaround IE
	addEvent : function (el, ev, fn)
	{
		if (el.addEventListener) {
		  el.addEventListener(ev, fn, false); 
		} else if ( el.attachEvent ) {
		  el.attachEvent('on' + ev, fn);
		}
		
	}

};

// run
// PK_ShortUrl.init(); // <-- works with this.foo
// window.addEventListener("load", PK_ShortUrl.init, false); // <-- this.foo is undefined 
// window.addEventListener("load", function(e) { PK_ShortUrl.init(e); }, false); // <-- this.foo works
PK_ShortUrl.addEvent(window, "load", function(e) { PK_ShortUrl.init(e); }); // <-- this.foo works


// function doLoad(){
// 	console.log('PAGE LOADED!');
// }
// function doDOM(){
// 	console.log('DOM LOADED!');
// }
// window.addEventListener ("load", doLoad, false);
// window.addEventListener ("DOMContentLoaded", doDOM, false);


// anon func ... 
// (function()
// {
//  console.log('ANON!');
// })();

