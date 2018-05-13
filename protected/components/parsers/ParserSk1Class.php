<?php

class ParserSk1Class extends CombinedSportklubClass{
    
    public function schedule($date){
        return $this->combined_schedule("sk1", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("sk1", $show);
    }
}