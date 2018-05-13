<?php

class GeneralIMDBParser {
    
    private function getHtml($link, $userAgent = 'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0', $header = array(), $proxy = false, $post = array()) {
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
    
    
    public function parseIMDB($imdb_url){
        $result = [];
        
        $htmlData = $this->getHtml($imdb_url,'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0');
        
        $checkPage = cutOut($htmlData,"<h1","</h1>",false,false);
        
        //verify validity
        if (($htmlData == "") || 
            (stripos($checkPage, "page not found") !== false) ||
            (stripos($checkPage, "permission denied") !== false) ||
            (stripos($htmlData, "<i>in development,</i>") !== false) ) return false;
        
        
        // get year
        $result['year'] = null;
        $release_date = trim(cutOut(cutOut($htmlData,"Release Date:"), '>' ,'<'));
        if (preg_match("*[0-9]{4}*", $release_date, $ret_arr)){
            $release_date = $ret_arr[0];
            $result['year'] = $release_date;
        }
        
        //title
        $title = trim(html_entity_decode(cutOut($checkPage, '>', '<')));
        $result['title'] = $title;
        
        
        // country
        $result['country'] = null;
        if (strpos($htmlData, 'Country:') !== false){
            $country = cutOut($htmlData,"Country:","</a>");
            $country = cutOut($country,">");
            $result['country'] = trim(strip_tags($country));
        }
        
        
        // genre
        $result['genre'] = $result['genre_list'] = null;
        if (strpos($htmlData, 'itemprop="genre"') !== false){
            $genre = cutOut($htmlData,'itemprop="genre"',"</a>");
            $genre = trim(strip_tags(cutOut($genre,'>')));
            if (strpos($genre, "|") === false) $result['genre'] = $genre;
        
            $genres = '';
            $genres_list = cutOut($htmlData,'itemprop="genre"',"</div>", true);
            while (strpos($genres_list, 'itemprop="genre"') !== false){
                $data = moveOut($genres_list,'itemprop="genre"',"</a>");
                $genres_list = $data['orig'];
                if ($genres) $genres .= ', ';
                $genres .= trim(strip_tags(cutOut($data['sub'],'>')));

            }
            $result['genre_list'] = $genres;
            if (!$result['genre'] && $genres) $result['genre'] = explode(", ", $genres)[0];
            
            if (strpos($result['genre'], ",") === 0) $result['genre'] = trim(substr($result['genre'], 1));
        }
        
        // type of show
        $type = null;
        if (strpos($htmlData, 'See more release dates') !== false){
            $type = trim(cutOut(cutOut($htmlData,'See more release dates',"</a>"),'>'));
            if (strpos($type, 'TV Series') !== false) $type = 'series';
            else $type = 'movie';
        }
        $result['type'] = $type;
        
        // length
        /*$length = cutOut($htmlData,"infobar","</div>");
        $length = cutOut($length,">","min");
        if (strpos($length,">") !== false) $length = trim(strip_tags(cutOut($length,">")));
        $result['length'] = $length;*/
        
        
        // imdb rating count
        $result['imdb_rating'] = null;
        if (strpos($htmlData, 'imdbRating') !== false){
            $html = substr($htmlData, strpos($htmlData, 'imdbRating'), 500);
            $p = strpos($html, '>');
            $html = strip_tags(substr($html, $p+1, strpos($html,'</span',$p+1) - $p-1));
            if (is_numeric($html) ){
                $result['imdb_rating'] = $html*10;
            }
        }
        
        // imdb rating count
        $result['imdb_rating_count'] = null;
        if (strpos($htmlData, 'ratingCount') !== false){
            $html = substr($htmlData, strpos($htmlData, 'ratingCount'), 200);
            $p = strpos($html, '>');
            $html = str_replace(",", "", substr($html, $p+1, strpos($html,'</',$p+1) - $p-1));
            if (is_numeric($html) ){
                $result['imdb_rating_count'] = $html;
                /*$db_show->imdb_rating_count = $html;
                if (!$db_show->update()){
                    $this->log("Problem updating show: ".print_r($db_show->getErrors(),true));
                }*/
            }
        }
        
        
        // directors and creators
        $director = '';
        if (strpos(strtolower($htmlData), "director:") !== false) $director = cutOut($htmlData,'director:','</div>',false,false);
        else if (strpos(strtolower($htmlData), "directors:") !== false) $director = cutOut($htmlData,'directors:','</div>',false,false);
        else if (strpos(strtolower($htmlData), "creators:") !== false) $director = $director = cutOut($htmlData,'creators:','</div>',false,false);
        else if (strpos(strtolower($htmlData), "creator:") !== false) $director = $director = cutOut($htmlData,'creator:','</div>',false,false);

        $director = cutOut($director,'<a','',true);    
        $director = trim(strip_tags(str_replace("<br/>", ", ", $director)));
        $director = trim(strip_tags(str_replace("more", "", $director)));
        // remove last ','
        if ((strlen($director) > 0) && ("," == $director[strlen($director)-1])) $director = substr($director, 0, strlen($director)-1);
        $director = preg_replace('/\s+/', ' ', $director); // remopve multiple spaces

        if (strpos($director,", and ") !== false) $director = substr ($director, 0, strpos($director,", and "));
        
        $result['director'] = $director;
        

        // star actors
        $starsCast = '';
        if (strpos($htmlData, "Stars:")){
          $starsCast = cutOut($htmlData,'Stars:','</div>');
          if (strpos($starsCast, "|") !== false) $starsCast = cutOut($starsCast,'','|');
          $starsCast = str_replace(" and", ",", $starsCast);
          $starsCast = trim(strip_tags($starsCast));
        }

        $castHTML = cutOut($htmlData,'class="cast','</table>');
        //$castHTML = cutOut($castHTML, '</tr>');

        $i = 0;
        $cast = "";
        while ($i++ < 7){
          if (strpos($castHTML, '</tr>') === false) break;
          $castHTML = cutOut($castHTML, '</tr>');
          //$castHTML = cutOut($castHTML, 'alt="');
          $split = moveOut($castHTML, 'alt="','"');
          if ("more" == $split['sub']) break;
          if ($cast) $cast .= ', ';
          $cast .= strip_tags($split['sub']);
          $castHTML = $split['orig'];
        }  
        // remove last ','
        if ((strlen($cast) > 0) && ("," == $cast[strlen($cast)-1])) $cast = substr($cast, 0, strlen($cast)-1);

        // add star cast
        if ($starsCast){
          $starsCastArray = explode(",",$starsCast);
          foreach ($starsCastArray as $star){
            if (strpos($cast, trim($star)) === false) $cast = trim($star).", ".$cast;
          }
        }
        
        $result['cast'] = $cast;
        
        
        // imdb poster
        $result['imdb_poster'] = null;
        if (strpos($htmlData, 'class="poster"') !== false){
            $html = substr($htmlData, strpos($htmlData, 'class="poster"'), 500);
            $p = strpos($html, '<img');
            $html = substr($html, $p, strpos($html,'/>',$p+1) - $p);
            $p = strpos($html, 'src="');
            $html = substr($html, $p+5, strpos($html,'"',$p+5) - $p-5);

            $result['imdb_poster'] = $html;
        }
        
        return $result;
    }
    
   
    // search imdb link from title
    public function findIMDBFromTitle($title, $type = '', $year = ''){
        $htmlData = $this->getHtml("http://www.imdb.com/find?s=tt&exact=true&q=".urlencode($title),'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0');
        
        $checkPage = cutOut($htmlData,"<h1","</h1>",false,false);
        if (strpos($checkPage,"No results found for") !== false){
            $htmlData = $this->getHtml("http://www.imdb.com/find?s=tt&q=".urlencode($title),'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0');
        }
        
        //echo $htmlData;
        // nothing found
        $checkPage = cutOut($htmlData,"<h1","</h1>",false,false);
        if (strpos($checkPage,"No results found for") !== false) return false;
        
        $find_list = cutOut($htmlData, "findList",'</table>');
        $shows = [];
        
        while (strpos($find_list, 'result_text') !== false){
            $data = moveOut($find_list,'result_text',"</td>");
            $find_list = $data['orig'];
            
            $show = cutOut($data['sub'],'>');
            $link = trim(cutOut($show, 'href="', '"'));
            
            if (strpos($link, "?") !== false) $link = trim(cutOut($link,'', '?'));
            if (!$link) continue;
            
            $link = "http://www.imdb.com".$link;
            
            $show = strip_tags($show);
            
            // skip non movies or series
            if ((strpos($show, 'Video Game') !== false) || (strpos($show, 'Video') !== false) || 
                (strpos($show, 'Short') !== false) || (strpos($show, 'TV Episode') !== false) || 
                (strpos($show, 'TV Mini-Series') !== false)) continue;
            
            // limit by year or type
            if ($year){
                if (strpos($show, $year) !== false) $shows[] = $link;
                else continue;
            }
            else
            if ($type){
                if ($type == 'series' && (strpos($show, 'TV Series') !== false)) $shows[] = $link;
                else
                if ($type == 'movie' && (strpos($show, 'TV Series') === false)) $shows[] = $link;
                else continue;
            }else $shows[] = $link;
            
        }
        return $shows;
    }
    
    
    public function getIMDBPoster($imdb_poster_url){
        return $this->getHtml($imdb_poster_url,'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0');
    }
}