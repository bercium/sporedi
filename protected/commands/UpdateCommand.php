<?php
//set_time_limit(60*5); //5 min
class UpdateCommand extends CConsoleCommand {
    
    private function log($message, $ype = 'warning'){
        if (YII_DEBUG) echo date('c').": ".$message.PHP_EOL;
        else Yii::log($message, $ype, 'system.*');
    }
    
    
    
    //**************************************************************************
    
    public function actionSchedule($inOffset = 0, $force = false) {
       
        $offset = (int)date('H');
        if (YII_DEBUG || $force) $offset = $inOffset;
        if ($offset < 0 || $offset > 10) return; // let parsers decide when max days are acheived
        
        $channels = Channel::model()->findAllByAttributes(array(), "active > 0 OR active = -1");
        //substr($remote_time->serverTime,0,strpos($remote_time->serverTime, " "));
        $insert_show = new ShowManipulator();
        
        foreach ($channels as $channel){
            
            $class_name = "Parser".str_replace("-",'',ucfirst($channel->slug))."Class";
            
            // verify class
            if (!@class_exists($class_name)){
                $this->log("Schedule parser missing: ".$class_name);
                continue; // no parser for this channel
            }
            
            
            $channel_shows = [];
            $channel_date = date("Y-m-d",strtotime("+".$offset." day"));
            // load shows per day
            $parser = new $class_name();
            if ($parser->maxDays($offset) == false) continue;
            $channel_shows = $parser->schedule($channel_date);
            
            if (!$channel_shows || count($channel_shows) <= 0){
                $this->log("No shows for channel ".$channel->id.": ".$channel->name);
                continue;
            }
            
            // details about a show
            /*
            foreach ($shows as $show){
                $channel_shows[] = $parser->show($show);
            }*/
            
            //$cs = $parser->getChannelShows($channel->id, $offset);
            //$channel_shows = json_decode($cs);
            
            /*if (isset($channel_shows[0])) $channel_date = substr($channel_shows[0]->s,0,strpos($channel_shows[0]->s, " "));
            else{
                $this->log("No shows for channel ".$channel->id.": ".$cs);
                continue;
            }*/
            $this->log("Channel (".$channel->name.") ID: ".$channel->id.", date: ".$channel_date, 'info');
            
            $db_shows = Schedule::model()->with('show')
                                         ->findAllByAttributes(array(
                                                "day_date" => $channel_date,
                                                "channel_id" => $channel->id,
                                         ), array('order'=>'start'));
                
            //remove old shows
            $count = 0;
            foreach ($db_shows as $db_show){
                $found = false;
                foreach ($channel_shows as $show){
                    if ($show->start == $db_show->start && $show->length == $db_show->length && $show->original_title == $db_show->show->original_title){
                        $found = true;
                        break;
                    }
                }
                if (!$found){
                    $count++;
                    
                    $db_show->delete();
                }
            }
            if ($count > 0) $this->log("Removed: ".$count.' schedules!','info');
            
            //add new shows
            $count = 0;
            foreach ($channel_shows as $show){
                $found = false;
                
                foreach ($db_shows as $db_show){
                    if ($show->start == $db_show->start && $show->length == $db_show->length && $show->original_title == $db_show->show->original_title){
                        $found = true;
                        break;
                    }
                }
                if ($found) continue;
                
                
                $show_detail = $parser->showInfo($show);
                
                if (!$show_detail){
                    $this->log("No show details!");
                    continue;
                }
                /*if (!isset($show_detail[0])){
                    $this->log("No show with this ID: ".$show->ie);
                    continue;
                }else $show_detail = $show_detail[0];*/
                
                // show exists
                try{
                    $show_id = $insert_show->insertShow($show_detail);
                } catch (Exception $ex) {
                    $this->log("Problem saving show! ".$ex->getMessage());
                    continue;
                }
                
                $schedule = new Schedule();
                $schedule->start = $show_detail->start;
                $schedule->length = $show_detail->length;
                $schedule->channel_id = $channel->id;
                $schedule->show_id = $show_id;
                $schedule->day_date = $channel_date;
                try{
                    $schedule->save();
                } catch (Exception $ex) {
                    $this->log("Problem saving schedule! ".$ex->getMessage());
                    return;
                }
                $count++;
                usleep(200000+rand(1,20)*10000); //1000000
            }
            $this->log("Schedules added: ".$count." / ".count($channel_shows),'info');
            
        }
        
    }
    
    
    public function actionForceschedule() {
        $this->actionSchedule(0, true);
    }
 

    //**************************************************************************
    
    public function actionTestImdb($url = ''){
        $imdb_parser = new GeneralIMDBParser();
        
        if ($url == '') print_r($imdb_parser->parseIMDB('http://www.imdb.com/title/tt1845307/'));
        else print_r($imdb_parser->parseIMDB($url));
        //print_r($this->findIMDBFromTitle('spiderman'));
    }
    
    public function actionTestImdbSearch(){
        $imdb_parser = new GeneralIMDBParser();
        
        print_r($imdb_parser->findIMDBFromTitle('spiderman'));
    }
    
    
    public function actionTestTrailer(){
        $trailer = new GeneralTrailerParser();
        
        print_r($trailer->getTrailer('Expendables 3', '', '2012'));
    }    
    
    public function actionTestparser($channel, $offset = 0){
        $class_name = "Parser".str_replace("-",'',ucfirst($channel))."Class";
        
        // verify class
        if (!@class_exists($class_name)){
            $this->log("Schedule parser missing: ".$class_name);
            return; // no parser for this channel
        }

        // load shows per day
        $parser = new $class_name();
        if ($parser->maxDays($offset) == false) return;
        $shows = $parser->schedule(date("Y-m-d",strtotime("+".$offset." day")));

        if (!$shows || count($shows) <= 0){
            $this->log("No shows for channel ".$channel);
            return;
        }
        
        // details about a show
        $channel_shows = [];
        foreach ($shows as $show){
            $fullShow = $parser->showInfo($show);

            $channel_shows[] = $fullShow;
        }
        
        print_r($channel_shows);
        return;
    }    
    
}