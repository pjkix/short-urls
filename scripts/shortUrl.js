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
	short_url : '',

	// set it off
	init : function ()
	{
		var links = [], i = 0;
		console.log('ShortUrl script enabled!');
		this.links = this.findTweetLinks();
		// loop over links and twitify the suburl then replace them
		for (i = 0; i < this.links.length; i = i + 1) {
			console.log(this.links[i]);
			this.parseLink(this.links[i]);
		}
		// load bitly stats
		// BitlyClient.loadModules(['stats'], 'PK_ShortUrl.statscallback');
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
		if (!BitlyClient) return url; // we need the client to work
		// check link then get short
		if (this.checkLink(url)) {
			// get the short version of the url
			// load up bitly client, shorten
			// Login: pjkix API Key: R_b2eb72dfa186b64f23dbef1fa32f7f61 
			console.log('ABOUT TO SHORTEN: ', url)
			var short_url = BitlyClient.call('shorten', {'longUrl': url}, 'PK_ShortUrl.callback');
//			var short_url = 'BITLY!!!';
			console.log('GOT SHORT URL', short_url);
			return short_url; 
		} else {
			return url;
		}
		
	},
	
	// handle bitly response
	callback : function (data) {
		// @see http://code.google.com/p/bitly-api/wiki/JavascriptClientApiDocumentation
		var s = '';
		var first_result;
		// Results are keyed by longUrl, so we need to grab the first one.
		for		(var r in data.results) {
				first_result = data.results[r]; break;
		}
		for (var key in first_result) {
				s += key + ":" + first_result[key].toString() + "\n";
				
		}
		console.log(s);
		console.log(first_result.shortUrl.toString());
//		return first_result.shortUrl.toString(); // this gets returned as undefined?? waiting for response
		this.short_url = first_result.shortUrl.toString();
		// maybe do the replacing here instead ... 
		return;
	}, 
	
	statscallback : function () {
		BitlyClient.addStatsToBitlyLinks(); // method defined in BitlyClient stats module
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

}; // END: PK_ShortUrl{}

// generic closure maker
function bind(toObject, methodName){
    return function(){toObject[methodName]()}
}

// run
PK_ShortUrl.addEvent(window, "load", function (e) { 
	PK_ShortUrl.init(e); 
});

