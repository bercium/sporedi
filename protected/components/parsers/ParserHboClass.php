<?php

class ParserHboClass extends CombinedHboClass{
    
    public function schedule($date){
        return $this->combined_schedule("hbo", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("hbo", $show);
    }
}