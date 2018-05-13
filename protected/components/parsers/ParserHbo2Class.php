<?php

class ParserHbo2Class extends CombinedHboClass{
    
    public function schedule($date){
        return $this->combined_schedule("hbo2", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("hbo2", $show);
    }
}