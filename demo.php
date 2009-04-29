<?php
/**
 * Test page
 * @package test
 * @author pkhalil
 * @copyright
 * @license
 * @version
 * @todo test some shit
 */

//* debug and coding pain threshold ;)
ini_set('display_errors',true);
error_reporting(E_ALL);
//*/


define('MAIN_PATH', realpath('.'));  // you are here ;)
require_once MAIN_PATH . '/../config/api.inc.php'; // defines

// requires
//require_once MAIN_PATH . '/../source/Ps/psGateway/psShortUrl.php'; // generic
//require_once MAIN_PATH . '/../source/Ps/psGateway/psTinyUrl.php'; // tinyurl
//require_once MAIN_PATH . '/../source/Ps/psGateway/psCligs.php'; // cli.gs

// loader
require_once MAIN_PATH . '/../source/Ps/psLoader.php'; // loader
psLoader::loadService('ShortUrl');
psLoader::loadService('TinyUrl');
psLoader::loadService('Cligs');


// test url shorteners
$psShortUrl = new psShortUrl();
$psTiny = new psTinyUrl();
$psCligs = new psCligs();

// test data
$test_url = 'http://geekbrief.mevio.com/';
$short_url = null;

$short_url = $psTiny->getTinyUrl($test_url);

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
				<h1>Test page</h1>
			</div><!-- /#header -->

			<div id="content">
				<h2>test content</h2>

				<p>original url: <?php echo $test_url ; ?></p>

				<p>short url: <?php echo $short_url ; ?></p>

			</div><!-- /#content -->

			<div id="footer">
				<p class="copyright">&copy; 2009-04-28 pjk</p>
			</div><!-- /#footer -->

		</div><!-- /#wrapper -->

			<?php
				//* TMP: for debugging
				require_once '../debug.php';
				$debug = new Debug();
				$debug->check_all_mem();
				$debug->dump_user_globals();
				$debug->dump_includes();
				//*/
			?>


	</body>
</html>