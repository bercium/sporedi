<?php

class ParserFoxClass extends CombinedFoxClass{
    
    public function schedule($date){
        return $this->combined_schedule("29", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("29", $show);
    }
}