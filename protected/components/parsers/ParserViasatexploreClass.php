<?php

class ParserViasatexploreClass extends CombinedViasatClass{
    
    public function schedule($date){
        return $this->combined_schedule("viasatexplore", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("viasatexplore", $show);
    }
}