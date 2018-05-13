<?php

class ParserFoxcrimeClass extends CombinedFoxClass{
    
    public function schedule($date){
        return $this->combined_schedule("50", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("50", $show);
    }
}