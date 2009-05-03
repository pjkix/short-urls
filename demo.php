<?php
/**
 * Short URL Demo
 *
 * Demo page for short url class libraries and functions
 * @package		Demo
 * @subpackage	ShortUrl
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo make it work
 */

//* debug and coding pain threshold ;)
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);
//*/

define('MAIN_PATH', realpath('.'));  // <-- you are here :P

require_once('./lib/shortUrl.class.php');
// $myShortUrl = shortUrlFactory::getUrlService(shortUrlFactory::TINY_URL);

// some defaults
$url = 'http://example.com/';
$short_url = null;
$service = shortUrlFactory::TINY_URL;

// debug caching
//$myTestUrl = new shortUrl();
//echo $myTestUrl->getShortUrl($url);
//die;

// submitted values
if ( isset($_GET['url']) ) $url = $_GET['url'];
if ( isset($_GET['service']) ) $service = $_GET['service'];

$myShortUrl = shortUrlFactory::getUrlService($service);
$short_url = $myShortUrl->getShortUrl($url);

$services = shortUrlFactory::getUrlServices();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>test</title>
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
		</script>
	</head>
	<body id="test" onload="">
		<div id="wrapper">
			<div id="header">
				<h1>Demo page</h1>
			</div><!-- /#header -->

			<div id="content">
				<h2>test content</h2>

				<p>original url: <?php printf('<a href="%s">%1$s</a>', $url) ; ?></p>

				<p>short url: <?php printf('<a href="%1$s">%1$s</a>', $short_url) ; ?></p>

				<form action="?debug=true" method="get" accept-charset="utf-8">
					<fieldset id="options" class="">
						<legend>options</legend>
						<label for="url">url</label>
						<input type="text" name="url" value="<?php echo $url ?>" id="url"/>

						<label for="service">service</label>
						<select name="service" id="service" onchange="">
							<option value="<?php echo shortUrlFactory::TINY_URL ?>" <?php if (shortUrlFactory::TINY_URL == $service) echo " selected " ?> >tinyurl</option>
							<option value="<?php echo shortUrlFactory::CLIGS_URL ?>" <?php if (shortUrlFactory::CLIGS_URL == $service) echo " selected " ?> >cli.gs</option>
							<option value="<?php echo shortUrlFactory::BITLY_URL ?>" <?php if (shortUrlFactory::BITLY_URL == $service) echo " selected " ?> >bit.ly</option>

							<?php foreach ($services as $service => $name) : ?>
							<!-- <option value="<?php echo $service?>"><?php echo $name?></option> -->
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