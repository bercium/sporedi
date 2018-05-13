<?php

class ParserViasathistoryClass extends CombinedViasatClass{
    
    public function schedule($date){
        return $this->combined_schedule("viasathistory", $date);
    }
    
    public function showInfo($show){
        return $this->combined_show("viasathistory", $show);
    }
}