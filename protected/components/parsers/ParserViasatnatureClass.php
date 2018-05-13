<?php

class ParserViasatnatureClass extends CombinedViasatClass{
    
    public function schedule($date){
        return $this->combined_schedule("viasatnature", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("viasatnature", $show);
    }
}