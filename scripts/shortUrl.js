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
/*members addEvent, addEventListener, attachEvent, checkLink, 
    findTweetLinks, getElementsByTagName, getShortUrl, href, init, join, 
    length, links, log, match, parseLink, push, replace, replacer, split
*/

// object wrapper
var PK_ShortUrl = {
	links : [], // saved list of links

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
	
	// extract href ... decode url ... replace link if not already short
	parseLink : function (a)
	{
		var new_string, status, rx, pieces;
		// split the string to base and status ... then only parse the status for links
		pieces = a.href.split('='); // only want 2 pieces?
		// do we really need to shorten?
		if (pieces[1].length < 140) {
			console.log('string should be ok for twitter');
		}
		// work on just the status part
		status = decodeURIComponent(pieces[1]);
		rx =  /\+(http:\/\/[^\+]+)/;
		status = status.replace(rx, this.replacer);
		console.log('NEW STATUS', status);
		pieces[1] = encodeURIComponent(status);
		// put the pieces back together .. 
		new_string = pieces.join('=');
		// put it back in the link
		a.href = new_string;
		a.className += ' shorted '; // just testing
		a.style.color = '#F00';
		a.style.backgroundColor = '#FF0';
	},
	
	// replace long url for short one
	replacer : function (str, p1, p2, offset, s)
	{
		console.log('REPLACER!!');
		console.log(str, p1, p2, offset, s);
//		return this.getShortUrl(str);// .this don't work
		return '+' + PK_ShortUrl.getShortUrl(p1);
//		return '+SHORTED!'; 
	},
	
	
	// make sure link is not already short
	checkLink : function (url)
	{
		console.log(url);
		var shorteners = ['tinyurl.com', 'bit.ly', 'cli.gs', 'tr.im', 'is.gd']; // add more shortners here
		
		for (var i = 0; i < shorteners.length; i++) { // loop check shortners
			if (url.match(shorteners[i])) {
				console.log('ALREADY SHORT!');
				return false;
			} else {
				return true;
			}
		}

	},

	// shorten links
	getShortUrl : function (url)
	{
		// check link then get short
		if (this.checkLink(url)) {
			// get the short version of the url
			// load up bitly client, shorten
			// Login: pjkix API Key: R_b2eb72dfa186b64f23dbef1fa32f7f61 
			console.log('ABOUT TO SHORTEN: ', url)
//			BitlyClient.call('shorten', {'longUrl': url}, 'BitlyCB.alertResponse');
			
			return 'BITLY!'; 
		}
		
	},
	
	// handle bitly response
	callback : function (response) {
		
	}, 

	// cross browser event
	addEvent : function (el, ev, fn)
	{
		if (el.addEventListener) {
			el.addEventListener(ev, fn, false); 
		} else if (el.attachEvent) {
			el.attachEvent('on' + ev, fn);
		}
		
	}

};

// run
PK_ShortUrl.addEvent(window, "load", function (e) { 
	PK_ShortUrl.init(e); 
});

