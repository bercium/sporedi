<?php

class ParserPoptvClass extends CombinedPopTvClass{
    
    public function schedule($date){
        return $this->combined_schedule("poptv", date("d.m.Y",strtotime($date)));
    }
    
    public function showInfo($show){
        return $this->combined_show("poptv", $show);
    }
}