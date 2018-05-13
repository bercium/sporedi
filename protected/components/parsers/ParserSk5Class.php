<?php

class ParserSk5Class extends CombinedSportklubClass{
    
    public function schedule($date){
        return $this->combined_schedule("sk5", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("sk5", $show);
    }
}