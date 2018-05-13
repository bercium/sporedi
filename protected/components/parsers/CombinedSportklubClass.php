<?php

class CombinedSportklubClass extends GeneralParser{
    
    protected function schedule($date){ }
    protected function showInfo($show){ }
    
    public function maxDays($offset){
        if ($offset > 6) return false;
        else return true;
    }
	
    
    protected function combined_schedule($channel, $date){
        $channel_num = array_search($channel, ['sk1','sk2','sk3','sk4','sk5','sk6','skgolf','skhd']);
        
        $offset = timeDifference($date, date('Y-m-d'),'days_total');
        $date_time = strtotime($date);
        $htmlData = $this->getHtml("http://sportklub.si/Programska-sema");

        $htmlData = cutOut($htmlData, "js-epg-vertical-table-wrapper");
        // split html data into days
        $day_data = $nextday_data = '';
        $i = 0;
        while(strpos($htmlData, 'js-epg-vertical-table') !== false){
            $data_mov = moveOut($htmlData, 'js-epg-vertical-table', '</table>');
            $htmlData = $data_mov['orig'];
            
            if ($offset == $i){
                $day_data = cutOut($data_mov['sub'], '>');
            }else if ($offset+1 == $i){
                $nextday_data = cutOut($data_mov['sub'], '>');
                break;
            }
            $i++;
        }
        
        //print_r($day_data);
        if ($day_data == '') return;
        $lastskip = false;
        if ($nextday_data){
            $day_data .= cutOut($nextday_data, "</tr>", "</tr>")."</tr>";
            $lastskip = true;
        }
        
        $c = 0;
        $data = [];
        // loop trough all hours
        while(strpos($day_data, '<tr') !== false){
            $data_mov = moveOut($day_data, '<tr', '</tr>');
            $day_data = $data_mov['orig'];
            $c++;
            if ($c == 1) continue; // skip channel row
            
            $i = 0;
            $chanel_data = $data_mov['sub'];
            // loop trough all channels
            while(strpos($chanel_data, '<td') !== false){
                $data_mov_ch = moveOut($chanel_data, '<td', '</td>');
                $chanel_data = $data_mov_ch['orig'];

                if ($channel_num == $i){
                    $rowData = cutOut($data_mov_ch['sub'], '>');

                    // start parsing row
                    if (!trim($rowData)){
                        $i++;
                        continue; // empty rows
                    }
                    $singleData = new ShowClass();
                    
                    $time = trim(strip_tags(cutOut(cutOut($rowData, "t-left",'</div>'), ">")));
                    $day = $date;
                    $time = '';
                    if (strpos($rowData, 't-left') !== false){
                        $cut = cutOut( cutOut($rowData,'t-left',"</div>"),'>');
                        $time = trim(strip_tags($cut));
                    }
                    if (strtotime($time) < strtotime("06:00")) $day = date("Y-m-d",strtotime($day." +1 day"));
                    
                    $singleData->start = date('Y-m-d H:i:00',strtotime($day." ".$time));
                    $singleData->day_date = $date;
                    $singleData->category = 'šport';
                    $singleData->imdb_search = 0;
                    
                    if (count($data) > 0) $data[count($data)-1]->length = timeDifference($data[count($data)-1]->start, $singleData->start);
                    
                    $title = '';
                    if (strpos($rowData, 'title1') !== false){
                        $cut = cutOut( cutOut($rowData,'title1',"</span>"),'>');
                        $title = trim(strip_tags($cut));
                    }
                    $singleData->title /*= $singleData->original_title*/ = $title;
                    if (stripos($title, "TV SHOPPING") !== false) $singleData->category = 'propagandni program';
                    //if (stripos($title, "NA DANAŠNJI DAN") !== false) $singleData->category = 'informativni program'; // maybe?
                    
                    if (strpos($rowData, 'topic') !== false){
                        $cut = cutOut( cutOut($rowData,'topic'),'</span>','</span>');
                        $singleData->genre = trim(strip_tags($cut));
                    }
                    
                    if (strpos($rowData, 'desc') !== false){
                        $cut = cutOut( cutOut($rowData,'desc',"</p>"),'>');
                        $singleData->description = trim(strip_tags($cut));
                    }
                    
                    $data[] = $singleData;
                }
                $i++;
            }
        }
        
        if ($lastskip) unset($data[count($data)-1]);
        return $data;
    }
    
    protected function combined_show($channel, $show){ 
        return $show;
    }
    
}