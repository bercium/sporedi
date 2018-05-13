<?php

class GeneralTrailerParser {
    protected function getHtml($link, $userAgent = 'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0', $header = array(), $proxy = false, $post = array()) {
        $httpClient = new elHttpClient();
        $httpClient->setUserAgent($userAgent);
        if ($proxy == true) {
            $proxy_ip = array("101.226.249.237", "117.102.122.218", "119.188.94.145", "120.202.249.230", "122.55.96.83", "148.251.234.73", "162.223.88.243", "175.103.47.130", "177.184.8.123", "180.166.56.47", "182.163.56.88", "183.238.133.43", "190.102.17.240", "190.181.18.232", "190.221.23.158", "197.218.204.202", "198.2.202.55", "198.2.202.58", "198.99.224.134", "200.150.97.27", "219.141.225.149", "31.220.43.28", "50.63.137.198", "58.214.5.229", "63.221.140.143", "80.91.88.36", "83.172.144.19", "83.222.126.179", "89.218.38.202", "91.121.204.88", "94.247.25.163", "94.247.25.164");
            $httpClient->setProxy($proxy_ip[mt_rand(0,count($proxy_ip)-1)], 80);
        }
        $httpClient->enableRedirects();
        $httpClient->setHeaders(array_merge(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8")));
        if ($post == array()) { $htmlDataObject = $httpClient->get($link, $header);}
        elseif ($post != "") { $htmlDataObject = $httpClient->post($link, $post, $header); }
        return $htmlDataObject->httpBody;
    }
    
    
    
    public function getTrailer($title, $imdb_url, $year){
        $result = $url = '';
        //$data = $this->getHtml("http://www.movie-list.com/search.php?q=",'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0');
        //https://www.google.com/?q=site:www.movie-list.com+war+dogs
        //https://www.google.com/search?q=site%3Awww.movie-list.com+war+dogs
        //https://www.movie-list.com/trailers/wardogs
        
        $url = "https://www.movie-list.com/trailers/".toAscii($title,null,'');
        $data = $this->getHtml($url,'Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
        
        if (strpos($data, "We don't have a movie by that name.") !== false){
            $data = $this->getHtml("https://www.google.com/search?q=site%3Awww.movie-list.com+".urlencode(trim($title.' '.$year)),'Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
            if (strpos($data, 'https://www.movie-list.com/trailers/') === false){
                $data = $this->getHtml("http://www.movie-list.com/search.php?q=".urlencode(trim($title.' '.$year)),'Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
            }
            if (strpos($data, 'https://www.movie-list.com/trailers/') !== false) $url = "https://www.movie-list.com/trailers/".cutOut($data, "https://www.movie-list.com/trailers/",'"');
            else return $result;
        }
        
        $data = $this->getHtml($url,'Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
        $imdb_id = '';
        if ($imdb_url){
            $imdb_array = explode("/", $imdb_url);
            $imdb_id = $imdb_array[count($imdb_array)-1];
            if (!$imdb_id && count($imdb_array) > 1) $imdb_id = $imdb_array[count($imdb_array)-2];

            // not found proper ID
            if (strpos($data, $imdb_id) === false) return $result;
        }
        
        if (strpos($data, "file:") === false) return $result;

        $result = cutOut(cutOut($data, "file:"), '"','"');
        if (strpos($result,".mp4") === false) $result = '';
        
        
        return $result;
    }
}