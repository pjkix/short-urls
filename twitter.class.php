<?php
if(!defined('__API_LIB_ROOT__')){
	defined('__API_LIB_ROOT', $_SERVER['DOCUMENT_ROOT'].'/../source/Ps/');
}
require_once( __API_LIB_ROOT__ . 'psGateway.php' );
require_once( __API_LIB_ROOT__ . 'psGateway/psUser.php' );
require_once( __API_LIB_ROOT__ . 'psGateway/psTinyUrl.php' );
require_once( __API_LIB_ROOT__ . 'psGateway/psShow.php' );

class psTwitterException extends psGatewayException {}

class psTwitter extends psGateway{

	public function checkTwitterCredentials($userId, $tname=null, $tpass=null){
		
		// if twitter username and password are passed as params, these creds have not been saved in db yet
		if($tname != null && $tpass != null){
			$pass = $tpass;
			$name = $tname;
		}
		else{
			// get user's twitter uname and password if they have not been passed
			$user = psUser::getUserTwitterCredentials($userId);
		
			if(is_array($user)){
				$pass = $user['twitter_pass'];
				$name = $user['twitter_name'];
			}
		}
		
		$twitterURL = "http://twitter.com/account/verify_credentials.xml";
		// call twitter api to verify credentials
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $twitterURL);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $name.':'.$pass);
		$buffer = curl_exec($ch);
		$result = curl_getinfo($ch);
		curl_close($ch);
			
		// check response (transparent to end user)
		if($buffer === false || $result['http_code'] != 200){ 		
            return false;
        }else{ 
            return true; 
        } 
        	
	}
	
	/*
	 *  
	 */
	// accomodates post with tiny url created on confirmation page
	public function sendTwitterUpdate($userId, $postMessage){

		// create curl request to twitter for this user
		$twitterStatusURL = "http://twitter.com/statuses/update.json";
	
		// get user object from userId; encryption/decryption takes place in psUser
		$uo = psUser::getUserTwitterCredentials($userId);
	
		if(is_array($uo)){
			// get user's twitter login info
			$userTwitterEmail = $uo['twitter_name'];
			$userTwitterPass = $uo['twitter_pass'];
			
			$userTweet = $postMessage;
			
			// generate user tweet
			// make sure link will get to proper mevio page
			/*
			switch($type){
	
				case 'pdne':
					$mediaUrl = 'http://www.mevio.com/view/?kId='.$mediaId.'&tId=2';
					// promo code for tracking feature effectiveness...
					// (testing): 'twte'
					$mediaUrl .= '&psRef=twte';					

					$show = new psShow();
					$s = $show->getShowById($parentId);
					$showName = $s[0]['show_name'];
			
					// make this tiny url
			    	$tinyUrl = psTinyUrl::getTinyUrl($mediaUrl); 
					$userTweet = "Uploaded a new Episode for ".$showName.": ".$tinyUrl;
				break;

	   		}*/	    	
	   		
	    	  		
			// execute curl request
			// example: $curlCmd = 'curl -u {$userTwitterEmail}:{$userTwitterPass} -d status="{$userTweet}" $twitterStatusURL';
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $twitterStatusURL);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, $userTwitterEmail.':'.$userTwitterPass);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "status=$userTweet");
			$buffer = curl_exec($ch);
			curl_close($ch);

			// check response (transparent to end user)
			if(empty($buffer)) {
				return false;
			} else{
				return json_decode($buffer);
			}
		}
		return false;
	}


	public function getTwitterSearch($query)
	{
		//make twitter search key
		$cache_name = 'twitter_search_'.substr($query,0,25).'_'.md5($query);
		$result = pdn_cache_get($cache_name);
		if ($result === false) {
			$result = self::getTwitterSearchUncached($query);
			pdn_cache_put($cache_name,$result,607);
		}

		self::prettifyTwitterTimestamps($result); //this step should be applied after getting cached data
		return $result;
	}

	public function getTwitterSearchUncached($query)
	{
		$queryURL = 'http://search.twitter.com/search.json?q='.urlencode($query);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $queryURL);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, Util::getMevioUserAgent());
		$buffer = curl_exec($ch);
		$result = curl_getinfo($ch);
		curl_close($ch);
		
		$data = json_decode($buffer,true);
		self::htmlizeTwitterSearchResults($data);

		return $data;
	}

	public function htmlizeTwitterSearchResults(&$data)
	{
		for ($i=0; $i<count($data['results']); $i++) {
			$html = $data['results'][$i]['text'];
			$html = preg_replace('|(http://[^ ]+)|','<a target="_twitter" rel="nofollow" href="$1">$1</a>',$html);
			$html = preg_replace('|@([a-zA-Z0-0]+)|','@<a target="_twitter" href="http://twitter.com/$1">$1</a>',$html);
			$data['results'][$i]['html'] = $html;
			$data['results'][$i]['source_html'] = html_entity_decode($data['results'][$i]['source'],ENT_COMPAT,'UTF-8');
		}
	}

	public function prettifyTwitterTimestamps(&$data)
	{
		for ($i=0; $i<count($data['results']); $i++) {
			$t = strtotime($data['results'][$i]['created_at']);
            $delta = time() - $t;
			if ($delta < 61)
			{
				$p = 'less than a minute ago';
			}
			else if ($delta < 50*60)
			{
				$mins = (int) $delta/60;
				$unit = ($mins == 1) ? "minute" : "minutes";
				$p = sprintf("about %d $unit ago",$mins);
			}
			else if ($delta < 24*3600)
			{
				$hours = (int)($delta/3600);
				$unit = (($hours == 1) ? "hour" : "hours");
				$p = sprintf("about %d $unit ago",$hours);
			}
			else
			{
				$p = date('g:i A M jS',$t);
				
				$year = date('Y',$t);
				$curr_year = date('Y');
				if ($year != $curr_year) $p .= ", $year";

			}
			$data['results'][$i]['created_at_pretty'] = $p;
		}		
	}
}

?>
