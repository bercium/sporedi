<?php

class CombinedHboClass extends GeneralParser{
    
    protected function schedule($date){ }
    protected function showInfo($show){ }
    
    public function maxDays($offset){
        if ($offset > 20) return false;
        else return true;
    }
	
	private function cleanTitle(&$title, &$originalTitle, ShowClass &$singleData){
		if (preg_match('/,? +((CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3}))\., *([0-9]*). +del/', $title, $matches)){
			$singleData->category = 'serija';
			$singleData->season = romanToInteger($matches[1]);
			$singleData->episode = $matches[5];
			$title = str_replace($matches[0], "", $title);
			$originalTitle = str_replace($matches[1].".", "", str_replace("EP. ".sprintf("%02d", $matches[5]), "", str_replace("EP ".sprintf("%02d", $matches[5]), "", $originalTitle)));
		}else if (preg_match('/,? +([0-9]*). +del/', $title, $matches)){
			$singleData->category = 'serija';
			$singleData->episode = $matches[1];
			$title = trim(str_replace($matches[0], "", $title));
			$originalTitle = str_replace("EP. ".sprintf("%02d", $matches[1]), "", str_replace("EP ".sprintf("%02d", $matches[1]), "", $originalTitle));
		}else if (preg_match('/,? +EP\. +([0-9]*)/', $originalTitle, $matches)){
			$singleData->category = 'serija';
			$singleData->episode = $matches[1];
			$originalTitle = str_replace("EP. ".sprintf("%02d", $matches[1]), "", str_replace("EP ".sprintf("%02d", $matches[1]), "", $originalTitle));
		}else $singleData->category = 'film';
	}
    
    protected function combined_schedule($channel, $date){
        $date_time = strtotime($date);
        $htmlData = $this->getHtml("http://www.hbo.si/schedule/vertical_view/".date('m',$date_time)."/".date('d',$date_time));
        
        // get show details from json
        $json_data = cutOut($htmlData, '"initVariables",', '});').'}';
        if (strpos($json_data, "{") > 0) $json_data = '{'.$json_data;
        
        
        $json_dec = json_decode($json_data);
        $json = $json_dec->scheduleJson;
        
        //print_r($json);
        
        // split html data into chanels
        
        $chanel_data = [];
        $htmlData .= 'class="channel"';
        while(strpos($htmlData, 'class="channel"') !== false){
            $data_mov = moveOut($htmlData, 'class="channel"', 'class="channel"');
            if (strpos($data_mov['orig'], 'class="channel"') !== false){
                $htmlData = 'class="channel"'.$data_mov['orig'];
            }
            
            $name = cutOut($data_mov['sub'], 'class="logo ', '"');
            $chanel_data[$name] = $data_mov['sub'];
            if (strpos($data_mov['orig'], 'class="channel"') === false) break;
        }
        
        $htmlData = $chanel_data[$channel];

        $data = [];
        $prev = null;
        while(strpos($htmlData, '</a>') !== false){
            $singleData = new ShowClass();
            
            // get row
            $htmlData_move = moveOut($htmlData, '<a ', '</a>');
            $htmlData = $htmlData_move['orig'];
            $rowData = $htmlData_move['sub'];
			$linkData = cutOut($rowData, '', ">");
            $rowData = cutOut($rowData, ">");
            
			//parse from HTML
			
			$day = $date;
            $time = '';
            if (strpos($rowData, '"time">') !== false){
                $cut = cutOut($rowData,'"time">',"</span>");
                $time = trim(strip_tags($cut));
            }
            if (strtotime($time) < strtotime("06:00")){
                $day = date("Y-m-d",strtotime($day." +1 day"));
            }
            $singleData->start = date('Y-m-d H:i:00',strtotime($day." ".$time));
            $singleData->day_date = $date;
            
            if (count($data) > 0) $data[count($data)-1]->length = timeDifference($data[count($data)-1]->start, $singleData->start);
			
            $id = cutOut($rowData,'info_','"');
			
			// if json not available parse more and continue
			
			$originalTitle = '';
            if (isset($json->$id)){
				// PARSE FROM JSON
				$row = $json->$id;
				
				$title = $row->title."\n";
				if (!empty($row->originaltitle)) $originalTitle = $row->originaltitle;
				
				if (!empty($row->year)) $singleData->year = $row->year;
	  
				if ($row->lead) $singleData->description = $row->lead;

				if ($row->genre){
					$genres = explode(",", $row->genre);
					if (count($genres) > 0) $singleData->genre = $genres[0];
					else $singleData->genre = null;
				}
				
				$singleData->cast = $row->cast;
				$singleData->director = $row->director;
                
            }else{
				// PARSE FROM HTML
				//echo $id;
				//Yii::log("No ID: ".$id." on ".$channel." ".$date, "warning");
				// add link for getting extended information
				//$singleData->show_url = $id." http://www.hbo.si".cutout($linkData, 'href="' , '"');
				
				// parse title
				if (strpos($rowData, '"title">') !== false){
					$cut = cutOut($rowData,'"title">',"</span>");
					
					$title = trim(strip_tags($cut));
				}else{
                    Yii::log("No ID & no Title: ".$id." on ".$channel." ".$date, "warning");
                    continue;
                }
			}
			
			//set title
			$this->cleanTitle($title,$originalTitle,$singleData);
			$singleData->title = trim($title);
			if ($originalTitle) $singleData->original_title = ucwords(strtolower(trim($originalTitle)));
			else{
				$singleData->original_title = $title;
				$singleData->imdb_search = 0;
			}
            
            //if ($row->link) $singleData->imdb_url = $row->link;
            //$prev = $row;
            $data[] = $singleData;
        }
		
        // last show lasts till 06:00 next day
        if (count($data) > 0) $data[count($data)-1]->length = timeDifference($data[count($data)-1]->start, date("Y-m-d ",strtotime($date." +1 day"))." 06:00");
		//print_r($data);
        return $data;
    }
    
    protected function combined_show($channel, $show){ 
        return $show;
    }
  
}