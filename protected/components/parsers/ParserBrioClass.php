<?php

class ParserBrioClass extends CombinedPopTvClass{
    
    public function schedule($date){
        return $this->combined_schedule("brio", date("d.m.Y",strtotime($date)));
    }
    
    public function showInfo($show){
        return $this->combined_show("brio", $show);
    }
}