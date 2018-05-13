<?php

class ParserCinemax2Class extends CombinedHboClass{
    
    public function schedule($date){
        return $this->combined_schedule("cinemax2", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("cinemax2", $show);
    }
}