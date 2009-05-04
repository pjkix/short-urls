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

require_once('./lib/ShortUrl.php');
// $myShortUrl = shortUrlFactory::getUrlService(shortUrlFactory::TINY_URL);

// some defaults
$url = 'http://example.com/';
$short_url = null;
$service = ShortUrlFactory::TINY_URL;

// debug caching
$myTestUrl = new ShortUrl();
echo $myTestUrl->getShortUrl($url);
die;

// submitted values
if ( isset($_GET['url']) ) $url = $_GET['url'];
if ( isset($_GET['service']) ) $service = $_GET['service'];

if ( isset($_GET['json']) ) {
	// do json stuff here ...
}

$myShortUrl = ShortUrlFactory::getUrlService($service);
$short_url = $myShortUrl->getShortUrl($url); // maybe ditch this and make static?

$services = ShortUrlFactory::getUrlServices(); // list of services

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
		<script type="text/javascript" charset="utf-8">
			// do it

			// hijack form, call json request
		</script>
	</head>
	<body id="demo-page" class="demo" onload="">
		<div id="wrapper">
			<div id="header">
				<h1>Demo page</h1>
			</div><!-- /#header -->

			<div id="content">
				<h2>Short URL Example</h2>

				<p>Original URL: <?php printf('<a href="%s">%1$s</a>', $url) ; ?></p>

				<p>Short URL: <?php printf('<a href="%1$s">%1$s</a>', $short_url) ; ?></p>

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

							<?php foreach ($services as $service => $name) : ?>
							<!-- <option value="<?php echo $service?>"><?php echo _($name) ?></option> -->
							<?php endforeach; ?>

						</select>

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
		require_once './lib/debug.class.php';
		$debug = new Debug();
		$debug->check_all_mem();
		$debug->dump_user_globals();
		$debug->dump_includes();
	}
	//*/
?>

	</body>
</html>