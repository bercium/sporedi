<?php

class ParserSk2Class extends CombinedSportklubClass{
    
    public function schedule($date){
        return $this->combined_schedule("sk2", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("sk2", $show);
    }
}