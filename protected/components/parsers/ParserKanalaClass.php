<?php

class ParserKanalaClass extends CombinedPopTvClass{
    
    public function schedule($date){
        return $this->combined_schedule("kanala", date("d.m.Y",strtotime($date)));
    }
    
    public function showInfo($show){
        return $this->combined_show("kanala", $show);
    }
}