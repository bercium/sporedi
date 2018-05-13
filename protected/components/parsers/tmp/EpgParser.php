<?php

class EpgParser {
    
    const version = '1.3';
    const isDemo = 0;
    
    private function getHtml($link, $header = array(), $proxy = false, $post = array()) {
        $httpClient = new elHttpClient();
        $httpClient->setUserAgent("Mozilla/5.0 (iPhone; CPU iPhone OS 7_0_6 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B651 Safari/9537.53");
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
    
    public function getdata($type){
        $hash = md5("epg_v".self::version.":".self::isDemo.":".date("d.m.Y:").((int)date('H')));
        $url = 'http://mobile.iecom.si/?v='.self::version.'&d='.self::isDemo.'&c='.$hash.'&action=mobile&dev=1&'.$type;
        
        return $this->getHtml($url);
    }
   
    private function getCodeList($list_type){
        return $this->getdata('type=sif&sif='.$list_type);
    }
    
    public function getChannelList(){
        return $this->getCodeList('channel');
    }
    public function getCountryList(){
        return $this->getCodeList('country');
    }
    public function getGenreList(){
        return $this->getCodeList('genre');
    }
    public function getCategoryList(){
        return $this->getCodeList('category');
    }
    public function getLanguageList(){
        return $this->getCodeList('language');
    }
    
    public function getTime(){
        return $this->getdata('type=time');
    }
    
    public function getChannelShows($channel_id, $offset = 0){
        return $this->getdata('type=list&channel='.$channel_id."&offset=".$offset);
    }

    public function getShowInfo($show_id){
        return $this->getdata('type=info&ide='.$show_id);
    }
    
    public function getNextShowInfo($show_id){
        return $this->getdata('type=info&ide='.$show_id."&offset=1");
    }
    
    public function getPrevShowInfo($show_id){
        return $this->getdata('type=info&ide='.$show_id."&offset=-1");
    }
    
}