<?php

class ParserCinemaxClass extends CombinedHboClass{
    
    public function schedule($date){
        return $this->combined_schedule("cinemax", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("cinemax", $show);
    }
}