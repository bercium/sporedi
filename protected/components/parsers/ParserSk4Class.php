<?php

class ParserSk4Class extends CombinedSportklubClass{
    
    public function schedule($date){
        return $this->combined_schedule("sk4", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("sk4", $show);
    }
}