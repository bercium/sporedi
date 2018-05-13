<?php

class ParserSlo3Class extends CombinedSloveniaClass{
    
    public function schedule($date){
        return $this->combined_schedule("tvs3", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("tvs3", $show);
    }
}