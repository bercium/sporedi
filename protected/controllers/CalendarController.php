<?php

class CalendarController extends Controller {

    public $social = false;

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
                // captcha action renders the CAPTCHA image displayed on the contact page
                'captcha' => array(
                        'class' => 'CCaptchaAction',
                        'backColor' => 0xFFFFFF,
                ),
                // page action renders "static" pages stored under 'protected/views/site/pages'
                // They can be accessed via: index.php?r=site/page&view=FileName
                'page' => array(
                        'class' => 'CViewAction',
                ),
        );
    }
    
    
    /**
     * 
     * @param type $item
     * @param type $diff
     * @return string
     */
    private function copyWeek($item, $diff){
        if (isset($item[date("YW",strtotime('-1 week'))])){
            $copy = $item[date("YW",strtotime('-1 week'))];
            $diff++;
        }
        else{
            $copy = $item[date("YW")];
        }

        if (!$copy || count($copy) == 0) return null;
        $unique = array();
        foreach($copy as $c){
            $unique[$c['episode']] = 1;
        }

        //echo $diff."-".count($unique).", ";
        foreach($copy as $k => $c){
            $c['episode'] += $diff*count($unique);
            $c['date'] = date("Y-m-d",strtotime($c['date'].'+'.$diff.' week'));
            $c['original'] = false;
            $c['showslug'] = '';
            $copy[$k] = $c;
        }

        return $copy;

    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($q = '') {
        
        $baseUrl = Yii::app()->baseUrl; 
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl.'/js/fullcalendar/fullcalendar.css');
        $cs->registerScriptFile($baseUrl.'/js/fullcalendar/fullcalendar.min.js');
        
        $calendar = array();
        if ($q){
            
            $schedule = Schedule::model()->with(array('channel', 'show'))
                                        ->findAllByAttributes(array(),
                                                              array("condition"=>"day_date > :currenttime AND show.original_title = :original_title AND (show.season IS NOT NULL OR show.episode IS NOT NULL)",
                                                                    //"order" => "channel.active, channel.name",
                                                                    "order" => "start",
                                                                    'params' => array(':currenttime'=>date("y-m-d",strtotime('-2 weeks')),
                                                                                      ":original_title"=>$q)
                                                                    ));
            
            
            
            foreach ($schedule as $item){
                //if ($item->channel->slug != 'fox') continue;
                $calendar[$item->channel->slug."|".$item->show->season]
                         [date("YW",strtotime($item->day_date))]
                         [date("N",strtotime($item->day_date))] = array('id'=>$item->id,'title'=>$item->show->title, 'showslug'=>$item->show->slug, 'channelslug'=>$item->channel->slug, 
                                                                        'season'=>$item->show->season, 'episode'=>$item->show->episode, 'date'=>date("Y-m-d",strtotime($item->start)),
                                                                        'original'=>true, "description"=> trim_text($item->show->description, 100) );
            }
            
            foreach ($calendar as $key => $item){
                $copy = $this->copyWeek($item,0);
                
                if (isset($item[date("YW")])){
                    $now = $item[date("YW")];
                    foreach ($copy as $k => $c){
                        if (!isset($now[$k])) $now[$k] = $c;
                    }
                    $calendar[$key][date("YW")] = $now;
                }else $calendar[$key][date("YW")] = $copy;
                
                if ($set = $this->copyWeek($item,1)) $calendar[$key][date("YW",strtotime('+1 week'))] = $set;
                if ($set = $this->copyWeek($item,2)) $calendar[$key][date("YW",strtotime('+2 weeks'))] = $set;
                //break;
            }
            
            
        }

        if (!isset($_GET['dev']) && !YII_DEBUG) $calendar = null;
        /*
        $this->pageTitle = "Koledar nanizank in nadaljevank";
        $this->pageDesc = "";
        $this->keywords = '';*/
        
        $this->render('index', array('calendar'=>$calendar));
    }
    
    
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionOddaje($q = 'A') {
        /*SELECT original_title FROM schedule sc
        LEFT JOIN `show` s ON s.id = sc.show_id
        WHERE day_date >= '2016-02-18' AND (season IS NOT NULL OR episode IS NOT NULL)
        GROUP BY s.original_title*/
        
        $baseUrl = Yii::app()->baseUrl; 
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.min.js');
        
        
        $fav_shows = (isset(Yii::app()->request->cookies['fav_shows']) ? Yii::app()->request->cookies['fav_shows']->value : '');
        
        
        $shows = Yii::app()->db->createCommand('SELECT s.*, g.name AS genre_name FROM `show` s '
                                             . 'JOIN customGenre cg ON cg.id = s.custom_genre_id '
                                             . 'JOIN genre g ON g.id = cg.genre_id '
                                             . 'JOIN customCategory cc ON cc.id = s.custom_category_id '
                                             . 'WHERE (cc.category_id = 4 OR cc.category_id = 5) AND (s.season IS NOT NULL OR s.episode IS NOT NULL) AND s.title LIKE :originaltitle '
                                             . 'GROUP BY original_title ORDER BY s.title')
                              ->bindValue(":originaltitle",$q.'%')
                              ->queryAll();
        
        $letters = Yii::app()->db->createCommand('SELECT LEFT(title,1) AS letter FROM `show` WHERE (season IS NOT NULL OR episode IS NOT NULL) GROUP BY LEFT(title,1) ORDER BY LEFT(title,1)')->queryAll();
        
        $this->render('shows', array('shows'=>$shows,'selected'=>$q, 'letters' => $letters, 'fav_shows'=>$fav_shows));
    }
    
    /**
     * 
     */
    public function actionBookmark() {
        
    }
    
}
