<?php

class CombinedPopTvClass extends GeneralParser{
    
    protected function schedule($date){ }
    protected function showInfo($show){ }
    
    public function maxDays($offset){
        if ($offset > 6) return false;
        else return true;
    }
    
    protected function combined_schedule($channel, $date){
        $htmlData = $this->getHtml("http://voyo.si/lbin/ajax_voyo_spored.php?channel=".$channel);
        
        $json = json_decode($htmlData, false);
        
        $data = [];
        $prev = null;
        if (empty($json) || count($json) == 0) return $data;
        foreach ($json as $row){
            if ($row->tv_day != $date || ($prev == null)){
                $prev = $row;
                continue;
            }
            $singleData = new ShowClass();
            
            $day = $row->tv_day;
            if (strtotime($row->time_start) < strtotime("06:00")){
                $day = date("d.m.Y",strtotime($day." +1 day"));
            }
            
            $singleData->start = date('Y-m-d H:i:00',strtotime($day." ".$row->time_start));
            
            $singleData->day_date = $row->tv_day;
            $singleData->length = timeDifference($day." ".$row->time_start, $prev->tv_day." ".$prev->time_start);
            
            $singleData->title = $row->title;
            if (!$row->originaltitle){
                $singleData->original_title = $row->title;
                $singleData->imdb_search = 0;
            }
            else $singleData->original_title = $row->originaltitle;
            if ($row->season && $roman = integerToRoman($row->season)) $singleData->original_title = trim(str_replace($roman.'.', "", $singleData->original_title));
            
            if ($row->synopsis) $singleData->description = $row->synopsis;
            
            if ($row->show_type && (strlen($row->show_type) > 2)) $singleData->category = $row->show_type;
            else{
                if ($singleData->title == 'TV prodaja') $singleData->category = "propagandni program";
                else if (strpos(strtolower($row->genre_name), "serija") !== false) $singleData->category = 'serija';
            }
            if (!$singleData->category && ($row->season || $row->episode)){
                $singleData->category = 'serija';
            }
            
            if ($row->genre_name){
                $singleData->genre = $row->genre_name;
                $genres = explode(", ", str_replace("Serija,", "", $singleData->genre));
                if (count($genres) > 0) $singleData->genre = $genres[0];
                else $singleData->genre = null;
                if (strtolower($singleData->genre) == 'druge nadaljevanke in nanizanke') $singleData->genre = null;
            }
            
            $singleData->cast = $row->actors;
            $singleData->director = $row->directors;
            
            if ($row->season) $singleData->season = $row->season;
            if ($row->episode) $singleData->episode = $row->episode;

            
            if ($row->link) $singleData->imdb_url = $row->link;
            
            $prev = $row;
            $data[] = $singleData;
        }
        return $data;
    }
    
    protected function combined_show($channel, $show){ 
        return $show;
    }
     
}