<?php

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../vendor/codebird/codebird.php');

//set_time_limit(60*5); //5 min
class TweetCommand extends CConsoleCommand {
    
    private function tweetText($text, $id){
        $keys = ["pop-tv"=>["token"=>"757646447126994945-EU11OAj4guWCIxr1cRXFOHIN3WKW7OE","secret"=>"IgiAuZP5zG61losE0JsBKXOTLo9y2Cf5ETbJsZtH9bTqJ"]
                 ];
        \Codebird\Codebird::setConsumerKey("FxVQdRHrWKLZY8DG1BNPhmOWi", "eamViRP7QbeZlaJpL69OYZi8vlarO83L9R54SFwzcYO55eQG0f");
        $cb = \Codebird\Codebird::getInstance();
        
        $reply = $cb->oauth_requestToken([
            'oauth_callback' => 'https://sporedi.net'
        ]);
        
        $cb->setToken($keys[$id]["token"],$keys[$id]["secret"]);

        $params = array( 'status' => $text );
        $reply = $cb->statuses_update($params);
        
        var_dump($reply);
    }
    
    
    public function actionCheckActiveSchedule(){
        $current = Schedule::model()->with(array('channel', 'show', 'show.genre', 'show.category'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"start BETWEEN :currenttime AND DATE_ADD(:currenttime, INTERVAL 15 MINUTE)",
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => "start DESC",
                                                                'params' => array(':currenttime'=>date('Y-m-d H:i'))
                                                                ), 
                                                          array());
        
        foreach ($current as $schedule){
            if ($schedule->channel->slug != 'pop-tv') continue;
            
            $tweetText = date('H:i',strtotime($schedule->start))." ".$schedule->show->title;
            
            
            //extra info
            $extra_show_info = '';
            if ($schedule->show->season) $extra_show_info .= $schedule->show->season.". sezona";
            if ($schedule->show->episode){
                if ($schedule->show->season) $extra_show_info .= " ";
                $extra_show_info .= $schedule->show->episode.". del";
            }
            if ($extra_show_info != '') $extra_show_info = " (".$extra_show_info.")";
            
            // extra searchable fields
            $extra = "TV spored - ".$schedule->channel->name;
            $hashtags = "#".mb_strtolower(str_replace(' ','',str_replace('-','',$schedule->show->genre->name)))." #".str_replace('-','',$schedule->channel->slug);
            $url = "sporedi.net";
            
            $add = ($extra." ".$hashtags." ".$url);
            
            // pad text to fit all extra info
            if (strlen($tweetText) >= 140-strlen($add)) $tweetText = substr($tweetText, 0, 140-strlen($add)-4)."..";
            else{
                if (strlen($tweetText)+strlen($extra_show_info) < 140-1-strlen($add)) $tweetText .= $extra_show_info;
            }
            $tweetText .= ". ".$add;
            
            $this->tweetText($tweetText, $schedule->channel->slug);
            //$this->tweetText($tweetText, "sporedi-net");
        }
        
    }
    
}