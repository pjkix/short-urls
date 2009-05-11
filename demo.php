<?php
/**
 * Short URL Demo
 *
 * Demo page for short url class libraries and functions
 * @category	Demo
 * @package		ShortUrl
 * @subpackage	ShortUrlDemo
 * @author		pkhalil <pj@pjkix.com>
 * @copyright	1975-2009 pjk
 * @license		http://creativecommons.org/licenses/by-nc-nd/3.0/ (cc) some rights reserved
 * @version		$Id:$
 * @link		http://pjkix.com/projects/short-url
 * @see			ShortUrl, ShortUrlFactory::getUrlService()
 * @since		Class available since Release 1.2.0
 * @deprecated	Class deprecated in Release 2.0.0
 * @todo		make it work
 */

//* debug and coding pain threshold ;)
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);
//*/

define('MAIN_PATH', realpath('.'));  // <-- you are here :P

// setup inc path
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . 'lib');

// main lib
require_once('ShortUrl.php');

// some defaults
$url = 'http://example.com/';
$short_url = null;
$service = ShortUrlFactory::TINY_URL;
$msg = 'Check out this really cool link ';

// debug caching
// $myTestUrl = new ShortUrl();
// echo $myTestUrl->getShortUrl($url);
// die;


// submitted values
if ( isset($_GET['url']) ) $url = $_GET['url'];
if ( isset($_GET['service']) ) $service = $_GET['service'];

if ( isset($_GET['json']) ) {
	// do json stuff here ...
	return json_encode(array('woot'=>'json!'));
}

// $myShortUrl = shortUrlFactory::getUrlService(shortUrlFactory::TINY_URL);
$myShortUrl = ShortUrlFactory::getUrlService($service);
$short_url = $myShortUrl->getShortUrl($url); // maybe ditch this and make static?

// list of services?
$services = ShortUrlFactory::getUrlServices();

// call sub lib directly with out invoke?
// echo ShortUrl_TinyUrl::getShortUrl($url);

ob_start();// for firephp
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Short-URL Demo</title>
		<meta name="description" content="test stuff">
		<meta name="keywords" content="test">
		<meta name="author" content="pjk">
		<style type="text/css" media="screen">
			/* test styles */
			body {
				font: 0.625em Verdana, Helvetica, Arial, sans-serif;
				color:#000;
				background-color:#eee;
			}
			a:link, a:visited, a:hover, a:active {
				color:00c;
				background-color:#ccc;
			}
			a img {border:none;}

		</style>
		<script src="scripts/shortUrl.js" type="text/javascript" charset="utf-8">/*JS Lib*/</script>
		<script type="text/javascript" charset="utf-8" src="http://bit.ly/javascript-api.js?version=latest&amp;login=pjkix&amp;apiKey=R_b2eb72dfa186b64f23dbef1fa32f7f61"></script>
		<script type="text/javascript" charset="utf-8">
			// do it

			// hijack form, call json request

			// bit.ly client api
			// @see http://code.google.com/p/bitly-api/wiki/JavascriptClientApiDocumentation
			BitlyCB.alertResponse = function(data) {
					var s = '';
					var first_result;
					// Results are keyed by longUrl, so we need to grab the first one.
					for		(var r in data.results) {
							first_result = data.results[r]; break;
					}
					for (var key in first_result) {
							s += key + ":" + first_result[key].toString() + "\n";
					}
					alert(s);
			};

		</script>
	</head>
	<body id="demo-page" class="demo" onload="">
		<noscript><p class="notice">this site works better with js</p></noscript>
		<div id="wrapper">
			<div id="header">
				<h1>Demo page</h1>
			</div><!-- /#header -->

			<div id="content">
				<h2>Short URL Example</h2>

				<p>Original URL: <?php printf('<a href="%s">%1$s</a>', $url) ; ?></p>

				<p>Short URL: <?php printf('<a href="%1$s">%1$s</a>', $short_url) ; ?></p>

				<p>Twitter Link:
					<?php printf('<a href="http://twitter.com/home/?status=%s" class="twitter">twitter</a>', urlencode($msg . $url) ) ; ?></p>

				<p>Twitter Link with params:
					<?php printf('<a href="http://twitter.com/home/?status=%s" class="twitter">twitter</a>', urlencode($msg . $url . '?foo=bar&baz=blah') ) ; ?></p>

				<p>Twitter Link preshortened:
					<?php printf('<a href="http://twitter.com/home/?status=%s" class="twitter">twitter</a>', urlencode($msg . $short_url) ) ; ?></p>

				<p>Twitter Example: (preshortend with link in middle)
					<a href="http://twitter.com/home/?status=RT+%40%40pjkix+PJ+Kix+%3E+Hi-tek+%2F+Lo-life+%C2%BB+installing+drizzle+db+on+os+x+http%3A%2F%2Ftinyurl.com%2Fcy473x+%28via+%40tweetmeme%29" class="twitter">twitter</a></p>

					<script type="text/javascript" charset="utf-8">
					// bitly api client
						 // BitlyClient.call('shorten', {'longUrl': 'http://example.com', 'longUrl' : 'http://localhost'}, 'BitlyCB.alertResponse');
					</script>

				<form action="?debug=true" method="get" accept-charset="utf-8">
					<fieldset id="options" class="">
						<legend>options</legend>
						<label for="url">url</label>
						<input type="text" name="url" value="<?php echo $url ?>" id="url"/>

						<label for="service">service</label>
						<select name="service" id="service" onchange="">
							<option value="<?php echo ShortUrlFactory::TINY_URL ?>" <?php if (ShortUrlFactory::TINY_URL == $service) echo " selected " ?> >tinyurl</option>
							<option value="<?php echo ShortUrlFactory::CLIGS_URL ?>" <?php if (ShortUrlFactory::CLIGS_URL == $service) echo " selected " ?> >cli.gs</option>
							<option value="<?php echo ShortUrlFactory::BITLY_URL ?>" <?php if (ShortUrlFactory::BITLY_URL == $service) echo " selected " ?> >bit.ly</option>
							<option value="<?php echo ShortUrlFactory::TRIM_URL ?>" <?php if (ShortUrlFactory::TRIM_URL == $service) echo " selected " ?> >tr.im</option>
							<option value="<?php echo ShortUrlFactory::ISGD_URL ?>" <?php if (ShortUrlFactory::ISGD_URL == $service) echo " selected " ?> >is.gd</option>

							<?php foreach ($services as $service => $name) : ?>
							<!-- <option value="<?php echo $service?>"><?php echo _($name) ?></option> -->
							<?php endforeach; ?>

						</select>
					</fieldset>

					<p><input type="submit" value="Continue &rarr;"/></p>
				</form>

				<h2>Twitter Client</h2>
				<form action="?debug=true" method="post" accept-charset="utf-8">
					<fieldset id="login" class="">
						<legend>login</legend>
						<label for="user">user</label><input type="text" name="user" value="username" id="user"/>
						<label for="pass"></label><input type="password" name="pass" value="pass" id="pass"/>
					</fieldset>

					<fieldset id="message" class="">
						<legend>message</legend>
						<textarea name="tweet" rows="8" cols="40">tweet this!</textarea>
					</fieldset>

					<p><input type="submit" value="Continue &rarr;"/></p>
				</form>


			</div><!-- /#content -->

			<div id="footer">
				<p class="copyright">&copy; 2009-04-28 pjk</p>
			</div><!-- /#footer -->

		</div><!-- /#wrapper -->

<?php
	//* TMP: for debugging
	if (isset($_GET['debug'])) {
		require_once 'debug.class.php';
		$debug = new Debug();
		$debug->check_all_mem();
		$debug->dump_user_globals();
		$debug->dump_includes();

		// FIRE PHP for FIREBUG
		require_once('FirePHPCore/fb.php');
		FB::log('Log message');
		FB::info('Info message');
		FB::warn('Warn message');
		FB::error('Error message');
	}
	//*/
?>

	</body>
</html>