<?php

class ParserKinoClass extends CombinedPopTvClass{
    
    public function schedule($date){
        return $this->combined_schedule("kino", date("d.m.Y",strtotime($date)));
    }
    
    public function showInfo($show){
        return $this->combined_show("kino", $show);
    }
}