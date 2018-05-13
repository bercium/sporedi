<?php

class ParserSlo1Class extends CombinedSloveniaClass{
    
    public function schedule($date){
        return $this->combined_schedule("tvs1", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("tvs1", $show);
    }
}