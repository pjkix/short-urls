<?php
require_once __API_LIB_ROOT__ . 'psGateway.php';

class psTinyUrlException extends psGatewayException {}

class psTinyUrl extends psGateway{

    public function getTinyUrl($url){
		$tiny = file_get_contents('http://tinyurl.com/api-create.php?url='.$url);
        if(strlen($tiny) > 0){
			return $tiny;
		}
		else{
			return false;
		}
    }

    // eventually fix something up with mod_rewrite to create a tiny mevio url...
    // ie. 	mevio.com/te/~(episodeId)
	//		mevio.com/ts/~(showId)
	//		mevio.com/tm/~(musicId)
	// 		mevio.com/tv/~(videoId)

}

?>

