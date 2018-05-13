<?php

class ParserHbo3Class extends CombinedHboClass{
    
    public function schedule($date){
        return $this->combined_schedule("hbo3", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("hbo3", $show);
    }
}