/**
 * JS ShortUrl Handler
 *
 * hijack form , submit url directly if supported , if not proxy throuth the class lib
 * @author pjk
 * @category util
 * @version $Id:$
 */

// js lint (recommended)
/*jslint eqeqeq: true, immed: true, newcap: true, nomen: true, undef: true, white: true, indent: 4*/

// js lint (good parts)
/*jslint bitwise: true, eqeqeq: true, immed: true, newcap: true, nomen: true, onevar: true, plusplus: true, regexp: true, undef: true, white: true, indent: 4*/

// object wrapper
var PK_ShortUrl = {
	links : '',

	// that should do it ...
	init : function ()
	{
		console.log('ShortUrl script enabled!');
		var links = PK_ShortUrl.findTweetLinks();
		// loop over links and twitify the suburl then replace them
		for (var i = 0; i < links.length; i++) {
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
			for (i = 0; i < links.length; i++) { // loop
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
	getRequest : function (url, cb) {
	  xmlhttpRequest({
	    method: "GET",
	     url: url,
	     onload: function(xhr) { cb(xhr.responseText); }
	  });
	}

};

// run
// PK_ShortUrl.init(); // <-- works with this.foo
window.addEventListener ("load", PK_ShortUrl.init, false); // <-- this.foo is undefined 


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

// debug script from firebug ... 
// function a() {return a.caller.toString().replace(/([\s\S]*?return;){2}([\s\S]*)}/,'$2');}
// document.body.appendChild(document.createElement('script')).innerHTML=a();
// return;


// menu
// makeMenuToggle("linkify_emails", true, "Include e-mail addresses", "Exclude e-mail addresses", "Linkify");
// 
// if (linkify_emails)
//   process_emails_too();


