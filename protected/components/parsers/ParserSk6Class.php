<?php

class ParserSk6Class extends CombinedSportklubClass{
    
    public function schedule($date){
        return $this->combined_schedule("sk6", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("sk6", $show);
    }
}