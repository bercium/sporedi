<?php

class ParserNationalgeographicwildClass extends CombinedNatgeoClass{
    
    public function schedule($date){
        return $this->combined_schedule("78", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("78", $show);
    }
}