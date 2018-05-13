<?php

class ParserOtoClass extends CombinedPopTvClass{
    
    public function schedule($date){
        return $this->combined_schedule("oto", date("d.m.Y",strtotime($date)));
    }
    
    public function showInfo($show){
        return $this->combined_show("oto", $show);
    }
}