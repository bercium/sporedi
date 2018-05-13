<?php
header_remove('Pragma');

/**
 * append this string to files that you wish to force refresh during version changes
 * it should be used on CSS and JS files that get cached for a long time
 */
function getVersionID(){
  $version = Yii::app()->params['version'];
  
  return "?".substr(md5($version),0,5);
}

/**
 * merge two arrays recursivly
 */
function array_merge_recursive_distinct ( array &$array1, array &$array2 )
{
  $merged = $array1;

  foreach ( $array2 as $key => &$value )
  {if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
    {
      $merged [$key] = array_merge_recursive_distinct ( $merged [$key], $value );
    }
    else
    {
      $merged [$key] = $value;
    }
  }

  return $merged;
}


/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string 
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
    if ($trimmed_text == '') $trimmed_text = substr($input, 0, $length);
  
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
  
    return $trimmed_text;
}

/**
 * 
 */
//if(!class_exists('elhttpclient'));
function getGMap($country = '', $city = '', $addr = ''){
  //include_once "httpclient.php";
	//if(!class_exists('elhttpclient')){
	//Yii::import('application.helpers.elHttpClient');
	//}
  $httpClient = new elHttpClient();
  $httpClient->setUserAgent("ff3");
 
  
  $zoom = 0;
  $address = '';
  if ($country){
    $zoom = 3;
    $address = $country;
  }
  if ($city){
    $zoom = 8;
    if ($address) $address .= ', ';
    $address .= $city;
  }
  if ($addr){
    $zoom = 14;
    if ($address) $address .= ', ';
    $address .= $addr;
  }
  if ($zoom == 0) return '';
  
  $URL = "maps.googleapis.com/maps/api/staticmap?center=".$address."&zoom=".$zoom."&size=150x150&maptype=roadmap&sensor=true&markers=size:mid|color:green|".$address;
 
  $filename = $address.".png";
  $folder = Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.Yii::app()->params['mapsFolder'];
  
  if (file_exists($folder.$filename)){
    return Yii::app()->getBaseUrl(true)."/".Yii::app()->params['mapsFolder'].$filename;
  }else{
    //$this->buildRequest($URL, 'GET');
    //return $this->fetch($URL);
    $httpClient->setHeaders(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));
    //$htmlDataObject = $httpClient->get("maps.googleapis.com");
    $URL = str_replace(" ", "%20", $URL);
    $htmlDataObject = $httpClient->get($URL);
    //change from XML to array
    $htmlData = $htmlDataObject->httpBody;
    
 		if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
		}

    @file_put_contents($folder.$filename, $htmlData);
    if (file_exists($folder.$filename)) return Yii::app()->getBaseUrl(true)."/".Yii::app()->params['mapsFolder'].$filename;
    else return false;
  }
}


/**
 * function to shorten URL with google url shortener
 */
function short_url_google($longUrl) {     
  $GoogleApiKey = 'enter-your-google-api-key-here';     
  $postData = array('longUrl' => $longUrl /*, 'key' => $GoogleApiKey*/);
    $jsonData = json_encode($postData);
    $curlObj = curl_init();
    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    //As the API is on https, set the value for CURLOPT_SSL_VERIFYPEER to false. This will stop cURL from verifying the SSL certificate.
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($curlObj);
    $json = json_decode($response);
    curl_close($curlObj);
    return $json->id;
}

/**
 * function to shorten URL with bit.ly url shortener
 */
function short_url_bitly($url, $format='txt') {
    $login = "your-bitly-login";
    $appkey = "your-bitly-application-key";
    $bitly_api = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$bitly_api);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function add_http($link){
  //return $link;
  if ((strpos($link, "http://") === false) && (strpos($link, "https://") === false)){
    return "http://".$link;
  }
  return $link;
}


/**
 * remove http:// and https://
 */
function remove_http($url) {
   $disallowed = array('http://', 'https://');
   foreach($disallowed as $d) {
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}


/**
 * set flash will set flash with some extra parameters
 * @value string $flashName - name of ID to show flash for
 * @value string $flashMesage - string message to show in flash or
 *                              array in format array(msg='',action=array of actions(hint='',action='')) where message should have %s for replacing actions
 * @value string $staus - ['success'] status of message shown can be: alert, success or info
 * @value string $autoHide - weather flash message should be automaticaly hidden after a period of time
 * 
 */
function setFlash($flashName, $flashMessage, $status = 'success', $autoHide = true){
  $flash = array("message"=>$flashMessage, "status"=>$status, "autoHide" => $autoHide);
  Yii::app()->user->setFlash($flashName, $flash);
}

/**
 * will decode message if array or string
 */
function decodeFlashMsg($msg){
  
  if (is_array($msg) && isset($msg['msg'])){
    $actions = array();
    
    if (isset($msg['actions'])){
      foreach ($msg['actions'] as $action){
        $actions[] = '<a href="'.$action['action'].'" class="action button radius tiny secondary ml10" style="margin-bottom: 0;" alt="'.$action['hint'].'" title="'.$action['hint'].'">'.
                     $action['hint'].
                     '</a>';
      }
    }
    $msg['msg'] = str_replace("%%s", "%s", str_replace("%", "%%", $msg['msg']));
    return vsprintf($msg['msg'],$actions);
  }else return $msg;
}

/**
 * will return flash data as a string
 */
function clearFlashes(){
  Yii::app()->user->getFlashes(true);
}

/**
 * will return flash data as a string
 */
function getFlashData($flashName){
  if(Yii::app()->user->hasFlash($flashName)){
    $flash =  Yii::app()->user->getFlash($flashName);
    return decodeFlashMsg($flash['message']);
  }
  return false;
}

/**
 * will return whole flash with styling
 */
function getFlash($flashName){
  $html = '';
  if(Yii::app()->user->hasFlash($flashName)){
    $flash = Yii::app()->user->getFlash($flashName);
    
    $html .= '<div data-alert class="alert-box radius '.$flash['status'].'">';
    $html .= decodeFlashMsg($flash['message']);
    $html .= '<a href="#" class="close">&times;</a></div>';
  }
  return $html;
}

function writeFlash($flashName){
  echo getFlash($flashName);
}

/**
 * will write all the flashes in standard way and assign them a timeout function
 */
function writeFlashes(){
  $flashMessages = Yii::app()->user->getFlashes(false);
  if ($flashMessages) {
    $nh = $i = 0;
    $hide = '';
    $html = '<div class=""><div class="">';
    foreach($flashMessages as $key => $flash) {
      Yii::app()->user->getFlash($key);

      if ($flash["autoHide"]){
        if ($flash['status'] != 'alert') $wait_time = 4000;
        else $wait_time = 10000;
        $hide .=  "$('.flash-hide-".$i."').oneTime(".($wait_time+$i*1000).", function() { $(this).fadeOut(); })"
                . "                                   .hover( function() { $(this).stopTime();}, 
                                                              function() { $(this).oneTime(".(4000+$i*1000).", function() { $(this).fadeOut(); }); });";
      }else $nh++;      

      $html .= '<div class="alert-box mb0 '.$flash['status'].' flash-hide-'.$i.' " style="margin-bottom:0px; font-weight:bold;" data-alert><div class="row">';
      $html .= decodeFlashMsg($flash['message']);
      $html .= '</div><a href="#" class="close">&times;</a></div>';
      //$html .= '</div></div>';

      $i++;
    }

    $html .= '<div></div>';
    if ($nh > 0){
      $html .= '<div></div>';
    }
    if ($i > 0){ 
      echo $html;
      Yii::app()->clientScript->registerScript(
         'myHideEffect',
         $hide,
         CClientScript::POS_READY
      );
    }
  }
}


function absoluteURL($url = ''){
  
  return Yii::app()->params['absoluteHost'];
  
  if (!YII_TESTING) return 'http://sporedi.net'.$url;
  else return 'http://sporedi.net'.$url;
  //$host = require(dirname(__FILE__) . '/../config/local-console-request.php');
  
  //echo $host;
  return  Yii::app()->request->hostInfo;
}


 /**
   * calculate time difference between two times
   *
   * @param $startTime mixed  - start time
   * @param $startTime mixed  - end time
   * @param $type string      - what to return (min, sec, hours,...)
   * @param $signed boolean   - is time difference sign dependant
   * @return integer          - return time difference
   */
  function timeDifference($startTime, $endTime, $type = "min", $signed = false){
    if ($startTime ==  $endTime) return 0;

    $d1 = (is_string($startTime) ? strtotime($startTime) : $startTime);
    $d2 = (is_string($endTime) ? strtotime($endTime) : $endTime);

    if ($signed) $diff_secs = (int)($d2 - $d1);
    else $diff_secs = abs((int)($d2 - $d1));
    $base_year = min(date("Y", $d1), date("Y", $d2));

    $diff = mktime(0, 0, abs($diff_secs), 1, 1, $base_year);

    switch ($type){
      case "years": $result = date("Y", $diff) - $base_year; break;
      case "months_total": $result = (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1; break;
      case "months": $result = date("n", $diff) - 1; break;
      case "days_total": $result = floor($diff_secs / (3600 * 24)); break;
      case "days": $result = date("j", $diff) - 1; break;
      case "hours_total":$result = floor($diff_secs / 3600); break;
      case "hours": $result = date("G", $diff); break;
      case "minutes_total":$result = floor($diff_secs / 60); break;
      case "minutes": $result = (int) date("i", $diff); break;
      case "seconds_total": $result = $diff_secs; break;
      case "seconds": $result = (int) date("s", $diff); break;
      }

    if ($d2 < $d1) $diff_secs = 24*60*60 - $diff_secs;
    if ($type == "min") $result = floor($diff_secs / 60);//(int) ($result / 60);
    if ($type == "hour") $result =  floor($diff_secs / 3600);//(int)($result / 60);

  //	echo $startTime."=".$d1."-".$endTime."=".$d2."=".$diff_secs.".".($diff_secs / 60)."<br>";
    return $result;
  }
  
  /**
   * prety date
   */
  function prettyDate($timeDiffInSec, $ago = false){
    
    if($timeDiffInSec < 60){
      $when = round($timeDiffInSec);
      if ($ago)  return Yii::t('app','{n} second ago|{n} seconds ago',array(round($when)));
      else return Yii::t('app','{n} second|{n} seconds',array(round($when)));
    }elseif($timeDiffInSec < 3600){
      $when = round($timeDiffInSec / 60);
      if ($ago)  return Yii::t('app','{n} minute ago|{n} minutes ago',array(round($when)));
      else return Yii::t('app','{n} minute|{n} minutes',array(round($when)));
    }elseif($timeDiffInSec >= 3600 && $timeDiffInSec < 86400){
      $when = round($timeDiffInSec / 60 / 60);
      if ($ago)  return Yii::t('app','{n} hour ago|{n} hours ago',array(round($when)));
      else return Yii::t('app','{n} hour|{n} hours',array(round($when)));
    }elseif($timeDiffInSec >= 86400 && $timeDiffInSec < 2629743.83){
      $when = round($timeDiffInSec / 60 / 60 / 24);
      if ($ago)  return Yii::t('app','{n} day ago|{n} days ago',array(round($when)));
      else return Yii::t('app','{n} day|{n} days',array(round($when)));
    }elseif($timeDiffInSec >= 2629743.83 && $timeDiffInSec < 31556926){
      $when = round($timeDiffInSec / 60 / 60 / 24 / 30.4375);
      if ($ago)  return Yii::t('app','{n} month ago|{n} months ago',array(round($when)));
      else return Yii::t('app','{n} month|{n} months',array(round($when)));
    }else{
      $when = round($timeDiffInSec / 60 / 60 / 24 / 365);
      if ($ago)  return Yii::t('app','{n} year ago|{n} years ago',array(round($when)));
      else return Yii::t('app','{n} year|{n} years',array(round($when)));
    }
  }
  
  /**
   * 1st, 2nd, 3rd, 4th... used for day in date
   */
  function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }

  
  /**
   * mail link click tracking
   */
  function mailLinkTracking($id,$link,$name){
    if ($id == '') return $link;
    return absoluteURL()."track/ml?tc=".$id."&l=".urlencode($link)."&ln=".$name;
  }

  /**
   * generate tracking code for mail
   */
  function mailTrackingCode($extra = '', $long = false){
    //Yii::import('application.helpers.Hashids');
    $hashids = new Hashids('crowdrss');
    if ($long) return $hashids->encrypt_hex(md5(microtime(true)));
    else return $hashids->encrypt(round(microtime(true)));
  }
  
  /**
   * decode tracking code
   */
  function mailTrackingCodeDecode($tc){
    //Yii::import('application.helpers.Hashids');
    $hashids = new Hashids('crowdrss');
    $tid = $hashids->decrypt($tc);
    if (is_array($tid) && isset($tid[0])) return $tid[0];
    else return $tid;
  }
/**
 * will return you to previously called action
 */
/*function goBackController($this){
  if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
    $this->redirect(Yii::app()->controller->module->returnUrl);
  else 
    if (strpos(Yii::app()->request->urlReferrer,"user/login") === false) $this->redirect(Yii::app()->request->urlReferrer);
    else $this->redirect(Yii::app()->user->returnUrl);  
}*/


  function mailButton($name, $link, $type='', $tc = '', $tc_name = '') {
    if ($tc_name == '') $tc_name = $name;
    $html = '<a href="'.mailLinkTracking($tc,$link,$tc_name).'" ';

    if ($type == '') $type = 'background-color: #0088bb; color: white;';
    else if ($type == 'secondary') $type = 'background-color: #ee8822; border: 1px solid #d0d0d0; color: #333333;';
    else if ($type == 'alert') $type = 'background-color: #ee4422; color: white;';
    else if ($type == 'success') $type = ' background-color: #44aa66; color: white;';
    
    if($type != 'link'){
        $html .= 'style="border-radius:3px; -webkit-border-radius:3px; border-style: solid;  border-width: 1px;  cursor: pointer;  font-family: inherit;  font-weight: bold;
      line-height: 1;  margin: 0 0 1.25em;  position: relative; text-decoration: none;  text-align: center;  display: inline-block;
      padding-top: 0.5625em; padding-right: 1.125em; padding-bottom: 0.625em; padding-left: 1.125em; font-size: 0.9em;
      '. $type .'"';  

      } 

    $html.= '>'.$name.'</a>';
    return $html;
  }
  
  
  function beautifyLink($link){
    if (strpos($link, "indiegogo.com") !== false){
      $link = str_replace("/pinw", "", $link);
      $link = str_replace("/qljw", "", $link);
      $link = str_replace("/pimf", "", $link);
      $link = str_replace("?sa=0&sp=0", "", $link);
      $link = str_replace("?sa=0&amp;sp=0", "", $link);
    }
    if (strpos($link, "kickstarter.com") !== false){
      if (strpos($link,"?") !== false) $link = substr($link, 0, strpos($link,"?"));
    }
    
    return $link;
  }
  

  /**
   * will create a nice URL like  something-to-do-in-the-meanwhile
   * 
   * @param type $str
   * @param type $replace
   * @param type $delimiter
   * @return type
   */
function toAscii($str, $replace=array(), $delimiter='-', $ignore = '') {
    if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
    }

	$str = str_replace("%2f", " ", str_replace("%2F", " ", $str));
	setlocale(LC_ALL, 'en_GB.UTF8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -".$ignore."]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}


function my_hash($string, $length = 8) {

    // Convert to a string which may contain only characters [0-9a-p]
    $hash = base_convert(md5($string), 16, 36);

    // Get part of the string
    $hash = substr($hash, -$length);

    // In rare cases it will be too short, add zeroes
    $hash = str_pad($hash, $length, '0', STR_PAD_LEFT);

    // Convert character set from [0-9a-p] to [a-z]
    //$hash = strtr($hash, '0123456789', 'qrstuvwxyz');

    return $hash;
}

/**
 * get stars instead of rating
 * 
 * @param type $rating
 * @return string
 */
function getStars($rating, $long = false){
	$stars = '';
	if (!empty($rating) && is_numeric($rating)){
		$stars = '★★★★★';
		if (!$long) $rating = $rating/2;
		switch(round($rating)){
			case 10: if ($long) $stars = '★★★★★★★★★★'; break;
			case 9:  if ($long) $stars = '★★★★★★★★★☆'; break;
			case 8:  if ($long) $stars = '★★★★★★★★☆☆'; break;
			case 7:  if ($long) $stars = '★★★★★★★☆☆☆'; break;
			case 6:  if ($long) $stars = '★★★★★★☆☆☆☆'; break;
			case 5: $stars = '★★★★★'; if ($long) $stars .= '☆☆☆☆☆';  break;
			case 4: $stars = '★★★★☆'; if ($long) $stars .= '☆☆☆☆☆'; break;
			case 3: $stars = '★★★☆☆'; if ($long) $stars .= '☆☆☆☆☆'; break;
			case 2: $stars = '★★☆☆☆'; if ($long) $stars .= '☆☆☆☆☆'; break;
			case 1: $stars = '★☆☆☆☆'; if ($long) $stars .= '☆☆☆☆☆'; break;
			case 0: $stars = '☆☆☆☆☆'; if ($long) $stars .= '☆☆☆☆☆'; break;
		}
	}
	return $stars;
}



/**
 * 
 */
//if(!class_exists('elhttpclient'));
function getLinkIcon($link) {
	//include_once "httpclient.php";
	//if(!class_exists('elhttpclient')){
	//Yii::import('application.helpers.elHttpClient');
	//}
	$httpClient = new elHttpClient();
	$httpClient->setUserAgent("ff3");

	$link = parse_url("http://" . remove_http($link), PHP_URL_HOST);

	$URL = "http://www.google.com/s2/favicons?domain=" . $link;

	$filename = $link . ".png";
	$folder = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['iconsFolder'];

	if (file_exists($folder . $filename)) {
		return Yii::app()->getBaseUrl(true) . "/" . Yii::app()->params['iconsFolder'] . $filename;
	} else {
		//$this->buildRequest($URL, 'GET');
		//return $this->fetch($URL);
		$httpClient->setHeaders(array("Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));
		//$htmlDataObject = $httpClient->get("maps.googleapis.com");
		$URL = str_replace(" ", "%20", $URL);
		$htmlDataObject = $httpClient->get($URL);
		//change from XML to array
		$htmlData = $htmlDataObject->httpBody;

		if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
		}

		file_put_contents($folder . $filename, $htmlData);
		return Yii::app()->getBaseUrl(true) . "/" . Yii::app()->params['iconsFolder'] . $filename;
	}
}



/**
 * return slovenian names of days in a week
 *
 * @param $week integer   - number of a day in a week
 * @param $short boolean  - short names
 * @return string         - name of week
 */
function dayNames($week, $short = false, $vna = false){
    // day names
    $weekName = '';
    switch ($week){
      case 1:$weekName = "Ponedeljek"; break;
      case 2:$weekName = "Torek"; break;
      case 3:if (!$vna) $weekName = "Sreda"; else $weekName = "Sredo"; break;
      case 4:$weekName = "Četrtek"; break;
      case 5:$weekName = "Petek"; break;
      case 6:if (!$vna) $weekName = "Sobota"; else $weekName = "Soboto"; break;
      case 0:;
      case 7:if (!$vna) $weekName = "Nedelja"; else $weekName = "Nedeljo"; break;
    }
    if ($short) $weekName = mb_substr($weekName, 0, 3, "UTF-8");
    return $weekName;
}


/**
 * return slovenian names of days in a week
 *
 * @param $week integer   - number of a day in a week
 * @param $short boolean  - short names
 * @return string         - name of week
 */
function monthNames($month, $short = false){
    // day names
    $monthName = '';
    switch ($month){
      case 1:$monthName = "januar"; break;
      case 2:$monthName = "februar"; break;
      case 3:$monthName = "marec"; break;
      case 4:$monthName = "april"; break;
      case 5:$monthName = "maj"; break;
      case 6:$monthName = "junij"; break;
      case 7:$monthName = "julij"; break;
      case 8:$monthName = "avgust"; break;
      case 9:$monthName = "september"; break;
      case 10:$monthName = "oktober"; break;
      case 11:$monthName = "november"; break;
      case 12:$monthName = "december"; break;
    }
    if ($short) $monthName = mb_substr($monthName, 0, 3, "UTF-8");
    return $monthName;
}


/**
 * 
 * @param type $date
 * @param type $short
 * @param type $url
 * @return type
 */
function dateToHuman($date, $short=false, $url = false, $vna = false){

    $dayDiff = 30;
    if (!is_numeric($date)) $date = strtotime ($date);
    if (date("Y",$date) != date("Y")){
      if (date("Y",$date) > date("Y") ) $dayDiff = (date("z",$date)+364+date("L",$date)) - date("z");
      if (date("Y",$date) < date("Y") ) $dayDiff = date("z",$date) - (date("z") +364+date("L",$date));

    }else $dayDiff = date("z",$date) - date("z");

    $result = '';
    switch ($dayDiff){
      case -1: $result = "Včeraj"; break;
      case 0:; $result = "Danes"; break; //pon
      case 1:; $result = "Jutri"; break; //tor
      case 2:; //sre
      case 3:; //cet
      case 4:; //pet
      case 5:; //sob
      case 6:; 
      case 7: $result = dayNames(date("N",$date),$short,$vna);break;//.", ".date("d.m.", $date); break; //ned
      default: $result = date("d.m.", $date); break; //pon
    }
    
    if ($url){
        $result = strtolower(str_replace("č", "c", str_replace("Č", "C", $result)));
        $result = str_replace(" ", "-", trim(str_replace(".", " ", $result)));
    }
    
    return $result;

}

/**
 * 
 * @param type $date
 * @return string
 */
function humanToDate($date){
    if (strpos($date,'.') === false && strpos($date,'-') === false){
        $date = strtolower(str_replace("č", "c", str_replace("Č", "C", $date)));
        if ($date == 'vceraj') $date = date('Y-m-d',strtotime('- 1 day'));
        if ($date == 'danes') $date = date('Y-m-d');
        if ($date == 'jutri') $date = date('Y-m-d',strtotime('+ 1 day'));
        if ($date == 'pojutrisnem') $date = date('Y-m-d',strtotime('+ 2 day'));
        if (strpos($date,'pon') === 0) $date = date('Y-m-d',strtotime('next monday'));
        if (strpos($date,'tor') === 0) $date = date('Y-m-d',strtotime('next tuesday'));
        if (strpos($date,'sre') === 0) $date = date('Y-m-d',strtotime('next wednesday'));
        if (strpos($date,'cet') === 0) $date = date('Y-m-d',strtotime('next thursday'));
        if (strpos($date,'pet') === 0) $date = date('Y-m-d',strtotime('next friday'));
        if (strpos($date,'sob') === 0) $date = date('Y-m-d',strtotime('next saturday'));
        if (strpos($date,'ned') === 0) $date = date('Y-m-d',strtotime('next sunday'));
    }else{
        if (strpos($date,'.') !== false) $date_array = explode(".", $date);
        else $date_array = explode("-", $date);
        if (count($date_array) > 1){
            $date = date("Y").'-'.$date_array[1].'-'.$date_array[0];
        }
    }
    
    return $date;
}


function imagePath($imdb_url, $title, $genre, $category, $iconOnEmpty = true, $customDomain = ''){
    $image = null;

    $folder = substr(Yii::app()->basePath, 0, strrpos(Yii::app()->basePath, "/")) . DIRECTORY_SEPARATOR . Yii::app()->params['coverPhotos'];
    if ($imdb_url) $filename = toAscii($title.' '.my_hash($imdb_url)).".jpg";
    else $filename = toAscii($title).".jpg";
    $filename = substr($filename, 0, 2). DIRECTORY_SEPARATOR.$filename;

    if (!file_exists($folder.$filename)) $image = null;
    else $image = Yii::app()->params['coverPhotos'].$filename;

    if ($image == null && $iconOnEmpty){
        if ($genre){
            $folder = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['genresPhotos'];
            $filename = $genre.".jpg";

            if (file_exists($folder.$filename)) $image = Yii::app()->params['genresPhotos'].$filename;
        }
        if ($category && $image == null ){
            $folder = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['categoriesPhotos'];
            $filename = $category.".jpg";

            if (file_exists($folder.$filename)) $image = Yii::app()->params['categoriesPhotos'].$filename;
        }
    }
    
    if ($image){
        if ($customDomain){
            $image = $customDomain."/".$image;
        }else{
            $image = getBaseUrlSubdomain(true, $filename)."/".$image;
        }
    }
    
    return $image;
}


function getFavs(){
    $favs_str = '';
    if (isset($_COOKIE['favs'])){
        $favs = json_decode($_COOKIE['favs'], true);
        
        foreach ($favs as $key => $value){

            if ($value == 1){
                if ($favs_str != '') $favs_str .= ',';
                $favs_str .= "'".$key."'";
            }
        }
        //$favs_str = implode("','", array_keys($favs));
    }
    return $favs_str;
}

/**
   *
   */
  function fastimagecopyresampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3) {
    // Plug-and-Play fastimagecopyresampled function replaces much slower imagecopyresampled.
    // Just include this function and change all "imagecopyresampled" references to "fastimagecopyresampled".
    // Typically from 30 to 60 times faster when reducing high resolution images down to thumbnail size using the default quality setting.
    // Author: Tim Eckel - Date: 09/07/07 - Version: 1.1 - Project: FreeRingers.net - Freely distributable - These comments must remain.
    //
    // Optional "quality" parameter (defaults is 3). Fractional values are allowed, for example 1.5. Must be greater than zero.
    // Between 0 and 1 = Fast, but mosaic results, closer to 0 increases the mosaic effect.
    // 1 = Up to 350 times faster. Poor results, looks very similar to imagecopyresized.
    // 2 = Up to 95 times faster.  Images appear a little sharp, some prefer this over a quality of 3.
    // 3 = Up to 60 times faster.  Will give high quality smooth results very close to imagecopyresampled, just faster.
    // 4 = Up to 25 times faster.  Almost identical to imagecopyresampled for most images.
    // 5 = No speedup. Just uses imagecopyresampled, no advantage over imagecopyresampled.

    if (empty($src_image) || empty($dst_image) || $quality <= 0) { return false; }
    if ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
      $temp = imagecreatetruecolor ($dst_w * $quality + 1, $dst_h * $quality + 1);
      imagecopyresized ($temp, $src_image, 0, 0, $src_x, $src_y, $dst_w * $quality + 1, $dst_h * $quality + 1, $src_w, $src_h);
      imagecopyresampled ($dst_image, $temp, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $dst_w * $quality, $dst_h * $quality);
      imagedestroy ($temp);
    } else imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
    return true;
  }
  
  
  
  
  /**
   * cuts out substring from string where start and end define limits
   * if nothing is found empty string is returned !
   *
   * from this string only string will be excluded:
   * start = this
   * end = only
   * leaveIn = false
   *
   * @param $string string    - major string to search for substring in
   * @param $start string     - start string
   * @param $end string       - end string
   * @param $leaveIn boolean  - [optional] if start and end parameters are apended to result
   * @param $case boolean     - [optional] is search case sensitive default true
   * @return string           - returned substring
   */
  function cutOut($string, $start, $end = '', $leaveIn = false, $case = true){
    $lenStart = strlen($start);
    $lenEnd = 0;
    if ($leaveIn){
      $lenStart = 0;
      $lenEnd = strlen($end);
    }
    $result = $string;
    // get start and end of string
    if ($case){
      if ($start) $result = substr($string,strpos($string,$start)+$lenStart);
      if ($end) $result = substr($result,0,strpos($result,$end)+$lenEnd);
    }else{
      if ($start) $result = substr($string,stripos($string,$start)+$lenStart);
      if ($end) $result = substr($result,0,stripos($result,$end)+$lenEnd);
    }
    return $result;
  }

  function mb_cutOut($string, $start, $end = '', $leaveIn = false, $case = true){
    $lenStart = strlen($start);
    $lenEnd = 0;
    if ($leaveIn){
      $lenStart = 0;
      $lenEnd = strlen($end);
    }
    $result = $string;
    // get start and end of string
    if ($case){
      if ($start) $result = mb_substr($string,strpos($string,$start)+$lenStart);
      if ($end) $result = mb_substr($result,0,strpos($result,$end)+$lenEnd);
    }else{
      if ($start) $result = mb_substr($string,stripos($string,$start)+$lenStart);
      if ($end) $result = mb_substr($result,0,stripos($result,$end)+$lenEnd);
    }
    return $result;
  }

  /**
   * moves out substring from string where start and end define limits
   * it will return array where 'ORIG' will hold original string paded by length of
   * substring. 'SUB' will hold extracted substring
   *
   * returned array:
   * array['orig']
   * array['sub']
   *
   * from this string only string will be excluded:
   * start = this
   * end = only
   * leaveIn = false
   *
   * array['orig'] = ' string will be excluded:'
   * array['sub']  = 'string'
   *
   * @param $string string    - major string to search for substring in
   * @param $start string     - start string
   * @param $end string       - end string
   * @param $leaveIn boolean  - [optional] if start and end parameters are apended to result
   * @param $case boolean     - [optional] is search case sensitive default true
   * @return string           - previosly defined array
   */
  function moveOut($string, $start, $end = '', $leaveIn = false, $case = true){
    $count = 0;
    if ($start){
      if ($case) $count = strpos($string, $start);
      else $count = stripos($string, $start);
    }

    $cut = cutOut($string, $start, $end, $leaveIn, $case);

    if ($leaveIn) $count += strlen($cut);
    else $count += strlen($start.$end.$cut);

    return array("orig" => substr($string,$count),
                 "sub" => $cut);
  }
  
  function mb_moveOut($string, $start, $end = '', $leaveIn = false, $case = true){
    $count = 0;
    if ($start){
      if ($case) $count = strpos($string, $start);
      else $count = stripos($string, $start);
    }

    $cut = mb_cutOut($string, $start, $end, $leaveIn, $case);

    if ($leaveIn) $count += strlen($cut);
    else $count += strlen($start.$end.$cut);

    return array("orig" => mb_substr($string,$count),
                 "sub" => $cut);
  }  
  
  

function integerToRoman($integer){
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';
    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

    foreach ($lookup as $roman => $value) {
        // Determine the number of matches
        $matches = intval($integer / $value);
        // Add the same number of characters to the string
        $result .= str_repeat($roman, $matches);
        // Set the integer to be the remainder of the integer and the value
        $integer = $integer % $value;
    }
   // The Roman numeral should be built, return it
    return $result;
}

function romanToInteger($roman){
    $romans = array('M' => 1000,'CM' => 900,'D' => 500,'CD' => 400,'C' => 100,'XC' => 90,'L' => 50,'XL' => 40,'X' => 10,'IX' => 9,'V' => 5,'IV' => 4,'I' => 1,);

    $result = 0;
    foreach ($romans as $key => $value) {
        while (strpos($roman, $key) === 0) {
            $result += $value;
            $roman = substr($roman, strlen($key));
        }
    }
    return $result;
}


function choseWithPriority($a, $b, $priority){
    $result = null;
    if ($a && $b) $result = (!$priority ? $a : $b);
    else if ($a && !$b) $result = $a;
    else if (!$a && $b) $result = $b;
    return $result;
}

function getBaseUrlSubdomain($absolute = false, $path = ''){
    if ($path == '' || YII_DEBUG) return Yii::app()->getBaseUrl($absolute);
    else{
        $domain = Yii::app()->getBaseUrl($absolute);
        preg_match('/[\d]/', md5($path), $m);
        $num = isset($m[0]) ? $m[0] : 0;
        $domain = str_replace("http://", "http://img".$num.".", $domain);
        return $domain;
    }
}