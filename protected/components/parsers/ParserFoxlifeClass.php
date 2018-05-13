<?php

class ParserFoxlifeClass extends CombinedFoxClass{
    
    public function schedule($date){
        return $this->combined_schedule("30", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("30", $show);
    }
}