<?php
/**
 * Twitter Class Libs
 *
 * Class for working with Twitter
 * @package		WebServices
 * @subpackage	Twitter
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo clean this shit up, grep /(\b)ps([A-Z])/ , $2
 */

/**
 * CRUD interface
 *
 */
interface iRESTClient {
	public function get($url);
	public function post($url, $data);
	public function put($url, $data = null);
	public function delete($url);
} // END: iRESTClient {}

/**
 * REST client base
 *
 */
abstract class RESTClient implements iRESTClient {
	public function get($url)
	{
		// code here ..
	}
	public function post($url, $data)
	{
		// code here
	}
	public function put($url, $data = null)
	{
		// code here ..
	}
	public function delete($url)
	{
		// code here ..
	}
} // END: RESTClient {}

/**
 * Twitter Client Wrapper Class
 *
 */
class Twitter extends RESTClient {

	/**
	 * Check twitter creds
	 *
	 * @param unknown_type $userId
	 * @param unknown_type $tname
	 * @param unknown_type $tpass
	 * @return unknown
	 */
	public function checkTwitterCredentials($userId, $tname=null, $tpass=null){

		// if twitter username and password are passed as params, these creds have not been saved in db yet
		if($tname != null && $tpass != null){
			$pass = $tpass;
			$name = $tname;
		}
		else{
			// get user's twitter uname and password if they have not been passed
			$user = User::getUserTwitterCredentials($userId);

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

	/**
	 * accomodates post with tiny url created on confirmation page
	 *
	 * @param unknown_type $userId
	 * @param unknown_type $postMessage
	 * @return unknown
	 */
	public function sendTwitterUpdate($userId, $postMessage){

		// create curl request to twitter for this user
		$twitterStatusURL = "http://twitter.com/statuses/update.json";

		// get user object from userId; encryption/decryption takes place in User
		$uo = User::getUserTwitterCredentials($userId);

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
					$mediaUrl .= '&Ref=twte';

					$show = new Show();
					$s = $show->getShowById($parentId);
					$showName = $s[0]['show_name'];

					// make this tiny url
					$tinyUrl = TinyUrl::getTinyUrl($mediaUrl);
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

	/**
	 * Search Twitter
	 *
	 * @param unknown_type $query
	 * @return unknown
	 */
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

	/**
	 * Uncached Search
	 *
	 * @param unknown_type $query
	 * @return unknown
	 * @todo consolidate
	 */
	public function getTwitterSearchUncached($query)
	{
		$queryURL = 'http://search.twitter.com/search.json?q='.urlencode($query);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $queryURL);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, Util::getMevioUserAgent());
		$buffer = curl_exec($ch);
//		$result = curl_getinfo($ch);
		curl_close($ch);

		$data = json_decode($buffer,true);
		self::htmlizeTwitterSearchResults($data);

		return $data;
	}

	/**
	 * Twitter Linkify
	 *
	 * @param unknown_type $data
	 */
	public function htmlizeTwitterSearchResults(&$data)
	{
		for ($i=0; $i<count($data['results']); $i++) {
			$html = $data['results'][$i]['text'];
			$html = preg_replace('|(http://[^ ]+)|','<a target="_twitter" rel="nofollow" href="$1">$1</a>',$html);
			$html = preg_replace('|@([a-zA-Z0-0]+)|','@<a target="_twitter" href="http://twitter.com/$1">$1</a>',$html);
			// do hashtag here ...
			$data['results'][$i]['html'] = $html;
			$data['results'][$i]['source_html'] = html_entity_decode($data['results'][$i]['source'],ENT_COMPAT,'UTF-8');
		}
	}

	/**
	 * Relative Date Formatting
	 *
	 * @param unknown_type $data
	 */
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

/**
 * Twitter Exception
 *
 */
class TwitterException extends Exception {}

?>
