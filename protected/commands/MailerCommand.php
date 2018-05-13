<?php

class MailerCommand extends CConsoleCommand {

	/**
	 * 
	 */
	private function sendNewsletter($sub, $date, $shows) {
		//set mail tracking
		/*$tc = mailTrackingCode();
		$ml = new MailLog();
		$ml->tracking_code = mailTrackingCodeDecode($tc);
		$ml->type = $trackingCode;
		$ml->subscription_id = $sub->id;
		$ml->save();*/


		// create message
		$message = new YiiMailMessage;
		$message->view = 'digest';
		$message->subject = "Vaše najljubše oddaje v prihajajočem tednu (".$date.")";
		$message->from = Yii::app()->params['adminEmail'];

		//$content = '';

		// not enough projects
		/*if ($count < 3) {
			$content = 'We found just a few projects for you. <br />Maybe your rules are too strict? Consider editing your feed.<hr>';
		}*/
		$message->setBody(array("user_id" => $sub->id, "recomended_shows" => $shows, 'date' => $date, "email"=>$sub->email ), 'text/html');
		$message->setTo($sub->email);
        //echo $message->message->getBody();
		//if ($count > 0) {
        
        Yii::app()->mail->send($message);
        /*$filename = Yii::app()->getRuntimePath() . "/dry-emails.txt";
			$fc = '';
			if (file_exists($filename))
				$fc = file_get_contents($filename);
			$fc .= date("Y-m-d [H:i]") . " (" . $trackingCode . "): " . $sub->email . "\n";
			file_put_contents($filename, $fc);*/
		//}
	}

	/**
	 * 
	 * @param string $type - type of log tracking code
	 */
	private function getSubsSent($type) {
		$mailsRec = MailLog::model()->findAll("type = :type AND DATE(time_send) = :date", array(":type" => $type, ":date" => date('Y-m-d')));
		$mails = array();
		foreach ($mailsRec as $mail) {
			$mails[$mail->subscription_id] = 1;
		}
		return $mails;
	}
    
    /**
     * 
     * @param type $a
     * @param type $b
     * @return int
     */
    private function sortShows($a, $b){
        if ($a->start == $b->start) return 0;
        return ($a->start < $b->start) ? -1 : 1;
    }


    /**
     * 
     * @param type $channels
     * @param type $categories
     * @param type $genres
     * @return type
     */
    private function getShows($channels, $categories, $genres) {
        $ch = $cat = $gen = '';

        if ($channels) $ch = " AND channel_id IN (".$channels.") ";
        if ($categories) $cat = " AND category_id IN (".$categories.") ";
        if ($genres) $gen = " IF(genre_id IN (".$genres."),10,0)+ ";

        $movies = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory','show.customGenre.genre', 'show.customCategory.category'))
                                ->findAllByAttributes(array(), 
                                                      array("condition"=>"channel.active > 0 AND DATE_ADD(start, INTERVAL 15 MINUTE) > :currentdatetime AND category_id IN (1,4,5,6) ".$ch.$cat,
                                                            'group' => '`show`.title',
                                                            'order' => $gen."`show`.imdb_rating
                                                                          #further away less important
                                                                          #-(TIME_TO_SEC(TIMEDIFF(start, NOW()))/60/60*2)
                                                                          #has description
                                                                          +IF(ISNULL(`show`.description) OR `show`.description = '',0,1)
                                                                          # primetime
                                                                          +IF(TIME(start) BETWEEN '19:00' AND '23:00', 8, 0)
                                                                          DESC
                                                                        , RAND()"
                                                            ,'limit'=>9,
                                                            'params' => array(':currentdatetime'=>date('Y-m-d', strtotime("next monday")))
                                                            ), 
                                                      array());
        $other = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory','show.customGenre.genre', 'show.customCategory.category'))
                                ->findAllByAttributes(array(), 
                                                      array("condition"=>"channel.active > 0 AND DATE_ADD(start, INTERVAL 15 MINUTE) > :currentdatetime AND category_id NOT IN (1,4,5,6) ".$ch.$cat,
                                                            'group' => '`show`.title',
                                                            'order' => $gen."`show`.imdb_rating
                                                                          #further away less important
                                                                          #-(TIME_TO_SEC(TIMEDIFF(start, NOW()))/60/60*2)
                                                                          #has description
                                                                          +IF(ISNULL(`show`.description) OR `show`.description = '',0,1)
                                                                          # primetime
                                                                          +IF(TIME(start) BETWEEN '19:00' AND '23:00', 8, 0)
                                                                          DESC
                                                                        , RAND()"
                                                            ,'limit'=>9,
                                                            'params' => array(':currentdatetime'=>date('Y-m-d', strtotime("next monday")))
                                                            ), 
                                                      array());
        $shows = array_slice($movies, 0, 6);
        $i = count($shows);
        $shows = array_merge($shows, array_slice($other, 0, 3+(6-$i)) );
        $i = count($shows);
        $shows = array_merge($shows, array_slice($movies, 6, (9-$i)) );
        
        usort($shows,array($this,'sortShows'));
        
        return $shows;
    }

	/**
	 * daily digest
	 */
	public function actionWeeklyDigest($test = false) {
        //$test = true;
        $week_day = date("w");
		if ($week_day != 0) exit; // sundays only
        
        $max = 95;
        $h = date("H")-19; // start at 7PM
        if ($test) $h = 0;
        if ($h < 0) exit;

		$subscriptions = Subscriber::model()->findAll("NOT ISNULL(email) && weekly_schedule = 1");

		if ($subscriptions) {
            //$next_monday = strtotime("next monday");
            //$next_sunday = strtotime("next monday + 7 days");
            $date = date("d.m.",strtotime("next monday"))." - ".date("d.m.",strtotime("next monday + 7 days ")); // 3.2. - 10.2.

			//$sentMails = $this->getSubsSent('daily-digest');
			$i = 0;
			foreach ($subscriptions as $sub) {
				// only send arround 100 emails per hour
				//if (isset($sentMails[$sub->id]) && !$test) continue;
                $i++;
                if ($i < $max*$h) continue;
				if ($i++ > $max*($h+1)) break;

				if (!$test || $sub->email == 'bercium@gmail.com'){
                    //get projects
                    $shows = $this->getShows($sub->channels, $sub->categories, $sub->genres);
                    
                    if (count($shows) > 2) $this->sendNewsletter($sub, $date, $shows);
                }
			}
		}
	}

	public function actionTestWeeklyDigest() {
		$this->actionWeeklyDigest(true);
	}


}
