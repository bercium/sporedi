<?php

class ParserSlo2Class extends CombinedSloveniaClass{
    
    public function schedule($date){
        return $this->combined_schedule("tvs2", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("tvs2", $show);
    }
}