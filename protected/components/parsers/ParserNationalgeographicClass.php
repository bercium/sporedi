<?php

class ParserNationalgeographicClass extends CombinedNatgeoClass{
    
    public function schedule($date){
        return $this->combined_schedule("28", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("28", $show);
    }
}