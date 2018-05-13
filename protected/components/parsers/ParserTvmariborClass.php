<?php

class ParserTvmariborClass extends CombinedSloveniaClass{
    
    public function schedule($date){
        return $this->combined_schedule("tvmb", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("tvmb", $show);
    }
}