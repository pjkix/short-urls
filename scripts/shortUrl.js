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
		links = PK_ShortUrl.findTweetLinks();
		// loop over links and twitify the suburl then replace them
		for (i = 0; i < links.length; i = i + 1) {
			console.log(links[i]);
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
	},
	
	checkLink : function (url)
	{
		// make sure link is not already too short
	},

	// shorten links
	getShortUrl : function (url)
	{
		// get the short version of the url
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
	}

};

// run
// PK_ShortUrl.init(); // <-- works with this.foo
window.addEventListener("load", PK_ShortUrl.init, false); // <-- this.foo is undefined 


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

