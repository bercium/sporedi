<?php

class CombinedViasatClass extends GeneralParser{
    protected $show_info_cache = [];
    
    protected function schedule($date){ }
    protected function showInfo($show){ }
    
    public function maxDays($offset){
        if ($offset > 12) return false;
        else return true;
    }
	
    
    protected function combined_schedule($channel, $date){
        $offset = timeDifference($date, date('Y-m-d'),'days_total');
        
        $htmlData = $htmlData2 = '';
        if ($offset < 7) $htmlData = $this->getHtml("http://".$channel.".si/schedule/");
        if ($offset > 5) $htmlData2 = $this->getHtml("http://".$channel.".si/schedule/next_week/");
        if ($offset >= 7) $offset -= 7;
        
        $htmlData = cutOut($htmlData, "schedule_content","vertical_line");
        $htmlData .= cutOut($htmlData2, "schedule_content","vertical_line").'schedule_day';
        
        // split html data into days
        $day_data = $nextday_data = '';
        $i = 0;
        while(strpos($htmlData, 'schedule_day') !== false){
            $data_mov = moveOut($htmlData, 'schedule_day', 'schedule_day');
            if (strpos($data_mov['orig'], 'schedule_day') !== false){
                $htmlData = 'schedule_day'.$data_mov['orig'];
            }
            
            if ($offset == $i){
                $day_data = cutOut($data_mov['sub'], '>');
            }else if ($offset+1 == $i){
                $nextday_data = cutOut($data_mov['sub'], '>');
                break;
            }
            $i++;
        }
        
        $day_data .= $nextday_data;
        
        $data = [];
        $start = true;
        $finish = $end = false;
        // loop trough all hours
        while(strpos($day_data, '<a') !== false){
            $data_mov = moveOut($day_data, '<a', '</a>');
            $day_data = $data_mov['orig'];
            
            $rowData_info = cutOut($data_mov['sub'], '' , '>');
            $rowData = cutOut($data_mov['sub'], '>');

            // start parsing row
            if (!trim($rowData)) continue; // empty rows
            $singleData = new ShowClass();

            
            $day = $date;
            $time = '';
            if (strpos($rowData, 'clock') !== false) $time = trim(strip_tags(cutOut(cutOut($rowData, "clock",'</span>'), ">")));
            
            if (strtotime($time) < strtotime("06:00")){
                if ($start) continue;
                $end = true;
                $day = date("Y-m-d",strtotime($day." +1 day"));
            }else{
                if ($end) $finish = true;
                $start = false;
            }

            $singleData->start = date('Y-m-d H:i:00',strtotime($day." ".$time));
            $singleData->day_date = $date;
            //$singleData->category = 'serija';
            $singleData->imdb_search = 0;
            
            $singleData->show_url = "http://".$channel.".si/".trim(strip_tags(cutOut($rowData_info,'href="','"')));

            if (count($data) > 0) $data[count($data)-1]->length = timeDifference($data[count($data)-1]->start, $singleData->start);
            if ($finish) break; // stop loop but input the last length
            
            $title = $subtitle = '';
            if (strpos($rowData, 'title') !== false){
                $title = trim(strip_tags(cutOut(cutOut($rowData,'title',"</span>"),'>')));
                
                $ep_num = trim(str_ireplace("epizoda","",strip_tags(cutOut(cutOut($rowData,'title'),'</span>', '</span>'))));
                if (is_numeric($ep_num)){
                    $singleData->episode = $ep_num;
                    $singleData->category = 'serija';
                }
            }
            $singleData->title = $title;


            if ($singleData->title) $data[] = $singleData;
        }
        
        return $data;
    }
    
    
    protected function combined_show($channel, $show){
        if (empty($show->show_url)) return $show;
        
        // load data from cache
        if (!isset($show_info_cache[$show->show_url])){
            $htmlData = $this->getHtml($show->show_url);
            $show_info_cache[$show->show_url] = $htmlData;
        }else $htmlData = $show_info_cache[$show->show_url];
        
        $htmlData = cutOut($htmlData, "single_show_content");
        
        if (strpos($htmlData, 'show_information') !== false){
            $show->description = trim(strip_tags(cutOut(cutOut(cutOut($htmlData, "show_information"), "<p",'</p>'), ">")));
        }
        
        if (strpos($htmlData, 'episod_time') !== false){
            $year = cutOut(cutOut($htmlData, "episod_time"), "</div>", "</div>");
            if (preg_match('/[12][0-9]{3}/', $year, $matches)){
                if ($matches[0] <= date('Y')) $show->year = $matches[0]; // can't be in the future
            }
        }
        
        return $show;
    }
    
}