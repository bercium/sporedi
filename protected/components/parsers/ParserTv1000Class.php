<?php

class ParserTv1000Class extends CombinedViasatClass{
    
    public function schedule($date){
        return $this->combined_schedule("tv1000", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("tv1000", $show);
    }
}