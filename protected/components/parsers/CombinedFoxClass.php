<?php

class CombinedFoxClass extends GeneralParser{
    
    protected function schedule($date){ }
    protected function showInfo($show){ }
    
    public function maxDays($offset){
        if ($offset > 15) return false;
        else return true;
    }
	
    
    protected function combined_schedule($channel, $date){
        $htmlData = $this->getHtml("http://www.foxtv.si/event/".$channel."/".str_replace("-", "", $date)."/".str_replace("-", "", $date));

        $data = [];
        // loop trough all hours
        while(strpos($htmlData, '<li') !== false){
            $data_mov = moveOut($htmlData, '<li', '</li>');
            $htmlData = $data_mov['orig'];
            
            $rowData_info = cutOut($data_mov['sub'], '' , '>');
            $rowData = cutOut($data_mov['sub'], '>');

            // start parsing row
            if (!trim($rowData)) continue; // empty rows
            $singleData = new ShowClass();

            
            $day = $date;
            $time = '';
            if (strpos($rowData, '<h5') !== false){
                $time = trim(strip_tags(cutOut(cutOut($rowData, "<h5",'</h5>'), ">")));
            }
            if (strtotime($time) < strtotime("06:00")) $day = date("Y-m-d",strtotime($day." +1 day"));

            $singleData->start = date('Y-m-d H:i:00',strtotime($day." ".$time));
            $singleData->day_date = $date;
            $singleData->category = 'serija';
            $singleData->imdb_search = 0;

            //first length
            if (strpos($rowData_info, 'data-end-timestamp') !== false){
                $endtime = (int) trim(strip_tags(cutOut($rowData_info,'data-end-timestamp="','"')));
                $singleData->length = timeDifference($singleData->start, $endtime)+1;
            }
            if (count($data) > 0) $data[count($data)-1]->length = timeDifference($data[count($data)-1]->start, $singleData->start);

            $title = '';
            if (strpos($rowData, '<h3') !== false){
                $title = trim(strip_tags(cutOut(cutOut($rowData,'<h3',"</h3>"),'>')));
            }

            $subtitle = '';
            if (strpos($rowData, '<h4') !== false){
                $subtitle = trim(strip_tags(cutOut(cutOut($rowData,'<h4',"</h4>"),'>')));
                
                if (preg_match('/[, ]+Sezona +([0-9]+)[ |]+Epizoda +([0-9]+)/', $subtitle, $matches)){
                    $singleData->season = ($matches[1]);
                    $singleData->episode = $matches[2];
                    $subtitle = str_replace($matches[0], "", $subtitle);
                }else if (preg_match('/[, ]+Sezona +([0-9]+)/', $title, $matches)){
                    $singleData->season = $matches[1];
                    $subtitle = str_replace($matches[0], "", $subtitle);
                }else if (preg_match('/[, ]+Epizoda +([0-9]+)/', $originalTitle, $matches)){
                    $singleData->episode = $matches[1];
                    $subtitle = str_replace($matches[0], "", $subtitle);
                }else $singleData->category = 'film';                
                
            }else $singleData->category = 'film';
            
            $singleData->title /*= $singleData->original_title*/ = $title.($subtitle ? ": ".$subtitle : '');
            
            
            if (strpos($rowData, '<p') !== false){
                $singleData->description = trim(strip_tags(cutOut( cutOut($rowData,'<p',"</p>"),'>')));
            }
            

            $data[] = $singleData;
        }
        
        return $data;
    }
    
    protected function combined_show($channel, $show){ 
        return $show;
    }
    
}