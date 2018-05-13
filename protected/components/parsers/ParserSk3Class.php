<?php

class ParserSk3Class extends CombinedSportklubClass{
    
    public function schedule($date){
        return $this->combined_schedule("sk3", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("sk3", $show);
    }
}