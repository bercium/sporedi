<?php

class CombinedSloveniaClass extends GeneralParser{
    
    protected function schedule($date){ }
    protected function showInfo($show){ }

    public function maxDays($offset){
        if ($offset > 11) return false;
        else return true;
    }
    
    
    protected function combined_schedule($channel, $date){
        $htmlData = $this->getHtml("http://api.rtvslo.si/spored/list/".$channel."/".$date);
        $htmlData = str_replace("*****", "", $htmlData);
        
        $json = json_decode($htmlData);
        if (!isset($json->response)) return [];
        $json = $json->response;
        
        $data = [];
        //$prev = null;
        foreach ($json as $row){
            $singleData = new ShowClass();
            
            if (!isset($row->duration)) continue;
            
            $day = $date;
            if (strtotime($row->ura) < strtotime("06:00")){
                $day = date("d.m.Y",strtotime($day." +1 day"));
            }
            
            $singleData->start = date('Y-m-d H:i:00',strtotime($day." ".$row->ura));
            
            $singleData->day_date = $date;
            $singleData->length = round($row->duration / 60);
            
            $title = '';
            if (!empty($row->broadcast->title)){
                $title = $row->broadcast->title;
                if (!empty($row->broadcast->eptitle)){
                    $title .= ": ".$row->broadcast->eptitle;
                }
            }else if (!empty($row->broadcast->eptitle)){
                $title = $row->broadcast->eptitle;
            }else if (!empty($row->broadcast->slottitle)){
                $title = $row->broadcast->slottitle;
            }else{
                $this->log("No title in ".$channel." for ".$date,'warning');
            }
            $singleData->title = $title;
            
            if (!empty($row->broadcast->origtitle->eng)) $singleData->original_title = ucwords($row->broadcast->origtitle->eng);
            else if (!empty($row->broadcast->origtitle->hun)) $singleData->original_title = ucwords($row->broadcast->origtitle->hun);
            else if (!empty($row->broadcast->origtitle->ita)) $singleData->original_title = ucwords($row->broadcast->origtitle->ita);
            else {
                $singleData->original_title = $title;
                $singleData->imdb_search = 0;
            }
            if (!empty($row->napovednik)) $singleData->description = $row->napovednik;

            
            if (!empty($row->genres->fullname)){
                $genres = explode(" \\ ",$row->genres->fullname);
                if (stripos($genres[1], 'izobraŽeval') !== false) $singleData->category = 'izobraževalni program';
                else if ((stripos($genres[1], 'razvedril') !== false) || (stripos($genres[1], 'glasben') !== false)) $singleData->category = 'razvedrilni program';
                else if (stripos($genres[1], 'Šport') !== false) $singleData->category = 'šport';
                else if (stripos($genres[1], 'igran') !== false){
                    if (stripos($row->genres->fullname, 'film') !== false) $singleData->category = 'film';
                    else if ((stripos($row->genres->fullname, 'nanizank') !== false) || (stripos($row->genres->fullname, 'nadaljevan') !== false))
                            $singleData->category = 'serija';
                    else if (stripos($row->genres->fullname, 'risank') !== false) $singleData->category = 'otroški in mladinski program';
                }
                else if ((stripos($genres[1], 'infokanal') !== false)  || (stripos($genres[1], 'informativ') !== false)) $singleData->category = 'informativni program';
                else if (stripos($genres[1], 'verske') !== false) $singleData->category = 'verski program';
                
                $singleData->genre = $genres[count($genres)-1];
                if (strtolower($singleData->genre) == 'druge nadaljevanke in nanizanke') $singleData->genre = null;
            }
            
            if (isset($row->broadcast->episodenr) && $row->broadcast->episodenr > 0){
                $singleData->episode = $row->broadcast->episodenr;
                $singleData->category = 'serija';
            }            
            
            if (!empty($row->broadcast->participants->director)) $singleData->director = $row->broadcast->participants->director;
            if (!empty($row->broadcast->participants->casting)) $singleData->cast = $row->broadcast->participants->casting;
            
            //$prev = $row;
            $data[] = $singleData;
        }
        return $data;
    }
    
    protected function combined_show($channel, $show){ 
        return $show;
    }
    
}