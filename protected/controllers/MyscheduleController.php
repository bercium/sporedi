<?php

class MyscheduleController extends Controller {
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admins only
				'users'=>array("*"),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    
    public function actionIndex(){
        
        $subs = null;
        $sleep = 0;
        if (isset($_COOKIE['sleep'])) $sleep = 1;
        
        if (isset($_COOKIE['personalized'])){
            $subs = Subscriber::model()->findByAttributes(array('hash'=>$_COOKIE['personalized']));
            setcookie("sleep",'1',1,'/'); // unset
            $sleep = 0;
            if (!$subs) setcookie('personalized', '', 1,'/'); //remove cookie
            else{
                setcookie("personalized",$subs->hash,time()+3600*24*365,'/');
                if (!empty($subs->email)) setcookie("personalized_email",1,time()+3600*24*365,'/');
            }
        }else if (isset($_GET['sleep'])){
            setcookie("sleep",'1',time()+3600*24*3,'/'); // 3 days
            $sleep = 1;
        }
        
        
        if ((Yii::app()->request->isPostRequest && isset($_POST['email'])) || (!Yii::app()->request->isPostRequest && isset($_GET['email'])) ) {
            // load from email
            if (isset($_POST['email'])) $mail = $_POST['email'];
            else $mail = $_GET['email'];
            
            $subs = Subscriber::model()->findByAttributes(array('email'=> strtolower($mail) ));
            if ($subs){
                setcookie("personalized",$subs->hash,time()+3600*24*365,'/'); // 1 year
                setcookie("sleep",'1',1,'/'); // unset
                $sleep = 0;
                if (!empty($subs->email)) setcookie("personalized_email",1,time()+3600*24*365,'/');
            }else{
                $this->redirect(array('myschedule/izbirakategorij'));
            }
        }else if(Yii::app()->request->isPostRequest){
            $this->redirect(array('myschedule/izbirakategorij'));
        }
        
        
        $shows = null;
        $favs = getFavs(); // favorite channels
        
        if (!$sleep && isset($subs)){
            $ch = $cat = $gen = '';
            if ($favs) $favs = " IF(channel.slug IN (".$favs."),2,0)+ ";
            
            if ($subs->channels) $ch = " AND channel_id IN (".$subs->channels.") ";
            if ($subs->categories) $cat = " AND category_id IN (".$subs->categories.") ";
            if ($subs->genres) $gen = " IF(genre_id IN (".$subs->genres."),10,0)+ ";
            
            
            /*echo "channel.active > 0 AND DATE_ADD(start, INTERVAL 15 MINUTE) >= :currentdatetime".$ch.$cat;
            echo $favs.$gen."`show`.imdb_rating
                                                                              #further away less important
                                                                              -(TIME_TO_SEC(TIMEDIFF(start, NOW()))/60/60*5)
                                                                              #has description
                                                                              +IF(ISNULL(`show`.description) OR `show`.description = '',1,0)
                                                                              # primetime
                                                                              +IF(TIME(start) BETWEEN '19:00' AND '23:00', 8, 0)
                                                                              DESC
                                                                            , RAND()";*/
            
            $movies = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory','show.customGenre.genre', 'show.customCategory.category'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND DATE_ADD(start, INTERVAL 15 MINUTE) >= :currentdatetime AND category_id IN (1,4,5,6) ".$ch.$cat,
                                                                'group' => '`show`.title',
                                                                'order' => $favs.$gen."`show`.imdb_rating
                                                                              #further away less important
                                                                              -(TIME_TO_SEC(TIMEDIFF(start, NOW()))/60/60*2)
                                                                              #has description
                                                                              +IF(ISNULL(`show`.description) OR `show`.description = '',0,1)
                                                                              # primetime
                                                                              +IF(TIME(start) BETWEEN '19:00' AND '23:00', 8, 0)
                                                                              DESC
                                                                            , RAND()"
                                                                ,'limit'=>16,
                                                                'params' => array(':currentdatetime'=>date('Y-m-d H:i'))
                                                                ), 
                                                          array());
            $other = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory','show.customGenre.genre', 'show.customCategory.category'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND DATE_ADD(start, INTERVAL 15 MINUTE) >= :currentdatetime AND category_id NOT IN (1,4,5,6) ".$ch.$cat,
                                                                'group' => '`show`.title',
                                                                'order' => $favs.$gen."`show`.imdb_rating
                                                                              #further away less important
                                                                              -(TIME_TO_SEC(TIMEDIFF(start, NOW()))/60/60*2)
                                                                              #has description
                                                                              +IF(ISNULL(`show`.description) OR `show`.description = '',0,1)
                                                                              # primetime
                                                                              +IF(TIME(start) BETWEEN '19:00' AND '23:00', 8, 0)
                                                                              DESC
                                                                            , RAND()"
                                                                ,'limit'=>16,
                                                                'params' => array(':currentdatetime'=>date('Y-m-d H:i'))
                                                                ), 
                                                          array());
            $shows = array_slice($movies, 0, 10);
            $i = count($shows);
            $shows = array_merge($shows, array_slice($other, 0, 6+(10-$i)) );
            $i = count($shows);
            $shows = array_merge($shows, array_slice($movies, 10, (16-$i)) );
            
        }else{
            // default suggestions
            if ($favs) $favs = " IF(channel.slug IN (".$favs."),20,0)+ ";
            
            $shows = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory', 'show.customGenre.genre', 'show.customCategory.category'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND DATE_ADD(start, INTERVAL 15 MINUTE) >= :currentdatetime",
                                                                //"order" => "channel.active, channel.name",
                                                                  'group' => '`show`.title',
                                                                 'order' => "IF(ISNULL(`show`.description) OR `show`.description = '',1,0), 
                                                                  (".$favs."`show`.imdb_rating
                                                                    #further away less important
                                                                    -(TIME_TO_SEC(TIMEDIFF(start, NOW()))/60/60*5))
                                                                    +IF(category_id = 1, 10, 0)
                                                                    #+IF(
                                                                    #    `show`.category_id IN (1,2,4,5), 6, 
                                                                    #     IF(`show`.category_id IN (6,8), 3, 0)
                                                                    #)
                                                                    # primetime
                                                                    +IF(TIME(start) BETWEEN '19:00' AND '23:00', 10, 0)
                                                                    DESC
                                                                  "
                                                                  
                                                                 .', RAND()'
                                                                ,'limit'=>16, // don't show if not sleep
                                                                'params' => array(':currentdatetime'=>date('Y-m-d H:i'))
                                                                ), 
                                                          array());
        
        }
        /*
        $evening = Schedule::model()->with(array('channel', 'show', 'show.genre', 'show.category'))
                            ->findAllByAttributes(array(), 
                                                  array("condition"=>"channel.active > 0 AND TIME(start) BETWEEN '19:00' AND '23:00' "
                                                          . "AND DATE_ADD(start, INTERVAL 15 MINUTE) >= :currentdatetime AND show.category_id = 1",
                                                        //"order" => "channel.active, channel.name",
                                                         'order' => 'DATE(start), `show`.imdb_rating DESC, RAND()'
                                                        ,'limit'=>4,
                                                        'params' => array(':currentdatetime'=>date('Y-m-d H:i'))
                                                        ), 
                                                  array());
        
        $series = Schedule::model()->with(array('channel', 'show', 'show.genre', 'show.category'))
                            ->findAllByAttributes(array(), 
                                                  array("condition"=>"channel.active > 0 AND TIME(start) BETWEEN '19:00' AND '23:00' "
                                                          . "AND DATE_ADD(start, INTERVAL 15 MINUTE) >= :currentdatetime AND (show.category_id = 4 OR show.category_id = 5)",
                                                        //"order" => "channel.active, channel.name",
                                                         'order' => 'DATE(start), `show`.imdb_rating DESC, RAND()'
                                                        ,'limit'=>4,
                                                        'params' => array(':currentdatetime'=>date('Y-m-d H:i'))
                                                        ), 
                                                  array());
        
        $sport = Schedule::model()->with(array('channel', 'show', 'show.genre', 'show.category'))
                            ->findAllByAttributes(array(), 
                                                  array("condition"=>"channel.active > 0 AND TIME(start) BETWEEN '19:00' AND '23:00' "
                                                          . "AND DATE_ADD(start, INTERVAL 15 MINUTE) >= :currentdatetime AND (show.category_id = 2)",
                                                        //"order" => "channel.active, channel.name",
                                                         'order' => "DATE(start), IF(TIME(start) BETWEEN '16:00' AND '23:00',0,1), RAND()"
                                                        ,'limit'=>4,
                                                        'params' => array(':currentdatetime'=>date('Y-m-d H:i'))
                                                        ), 
                                                  array());        
        */
            
        $this->pageTitle = 'Priporočene oddaje';
        $this->pageDesc = "TV spored za popularne Slovenske kanale v prihajajočem tednu. Podrobne informacije o posmaznih oddajah s slikami in opisi.";
        $this->keywords = 'tv spored, spored, danes, a kanal, pop tv, slo, eurosport, filmi nanizanke, nadaljevanke, resničnostne oddaje, imdb ocena, sezona, del';
        
        $this->render('suggested', array("current"=>$shows, 'personalized'=>$subs, 'sleep' => $sleep));
    }
    
    public function actionIzbirakategorij(){
        $subs = null;
        if (isset($_COOKIE['personalized'])) {
            $subs = Subscriber::model()->findByAttributes(array('hash'=>$_COOKIE['personalized']));
            if (!$subs) setcookie('personalized', '', 1,'/'); //remove cookie
            else{
                setcookie("personalized",$subs->hash,time()+3600*24*365,'/');
                if (!empty($subs->email)) setcookie("personalized_email",1,time()+3600*24*365,'/');
            }
        }
        if(Yii::app()->request->isPostRequest){
            if (!$subs) {
                $subs = new Subscriber();
                $subs->hash = md5(microtime(true));
                $subs->subscribed = date("Y-m-d H:i:s");
                if ($subs->save()){
                    setcookie("personalized",$subs->hash,time()+3600*24*365,'/'); // 1 year
                }
            }
            
            $categories = '';
            foreach ($_POST as $key => $value){
                if ($categories) $categories .= ',';
                $categories .= str_replace("ch_", "", $key);
            }
            $subs->categories = $categories;
            $subs->save();
            
            $this->redirect(array('myschedule/izbirakanalov'));
        }

        $categories = Category::model()->findAll('id<>14 AND id<>15 AND id<>5 ORDER BY name');
        $selected = [];
        
        if ($subs) $selected = explode(",", $subs->categories);
        
        $this->render('category', array("categories"=>$categories, "selected"=>$selected));
    }
    
    
    public function actionIzbirakanalov(){
        $subs = null;
        if (isset($_COOKIE['personalized'])) {
            $subs = Subscriber::model()->findByAttributes(array('hash'=>$_COOKIE['personalized']));
            if (!$subs) setcookie('personalized', '', 1,'/'); //remove cookie
            else{
                setcookie("personalized",$subs->hash,time()+3600*24*365,'/');
                if (!empty($subs->email)) setcookie("personalized_email",1,time()+3600*24*365,'/');
            }
        }
            
        if (!$subs) $this->redirect(array('myschedule/izbirakategorij')); // must have cookie
        
        if(Yii::app()->request->isPostRequest){
            $channels = '';
            foreach ($_POST as $key => $value){
                if ($channels) $channels .= ',';
                $channels .= str_replace("ch_", "", $key);
            }
            $subs->channels = $channels;
            $subs->save();
            
            //$this->redirect(array('myschedule/shraniemail'));
            $this->redirect(array('myschedule/izbirazanrov'));
        }

        $selected = [];
        $channels = Channel::model()->findAll('active > 0 ORDER BY active, name');
        if ($subs->channels === null){
            $favs = explode(",", str_replace("'", "", getFavs()) );
            foreach ($channels as $ch){
                if (in_array($ch->slug, $favs)){
                    $selected[] = $ch->id;
                }
            }
        }else $selected = explode(",", $subs->channels);
        
        $this->render('channel', array("channels"=>$channels, "selected"=>$selected));
    }
    
    public function actionIzbirazanrov(){
        $subs = null;
        if (isset($_COOKIE['personalized'])) {
            $subs = Subscriber::model()->findByAttributes(array('hash'=>$_COOKIE['personalized']));
            if (!$subs) setcookie('personalized', '', 1,'/'); //remove cookie
            else{
                setcookie("personalized",$subs->hash,time()+3600*24*365,'/');
                if (!empty($subs->email)) setcookie("personalized_email",1,time()+3600*24*365,'/');
            }
        }
            
        if (!$subs) $this->redirect(array('myschedule/izbirakategorij')); // must have cookie
        
        if(Yii::app()->request->isPostRequest){
            $genres = '';
            foreach ($_POST as $key => $value){
                if ($genres) $genres .= ',';
                $genres .= str_replace("ch_", "", $key);
            }
            $subs->genres = $genres;
            $subs->save();
            
            $this->redirect(array('myschedule/shraniemail'));
        }

        $selected = [];
        //$genres = Genre::model()->findAll('active > 0 ORDER BY active, name');
        /*$shows = Show::model()->with(array('customGenre','customCategory','customGenre.genre'))
                             ->findAllByAttributes(array(), 
                                                  array("condition"=>'category_id IN ('.$subs->categories.') AND genre_id IS NOT NULL',
                                                        'group' => "genre_id"
                                                        ));*/
        $genres = CategoryGenre::model()->with(array('genre'))
                                        ->findAllByAttributes(array(), array("condition"=>'category_id IN ('.$subs->categories.')', 'group'=>'genre_id'));
        
                               //->findAll();
        /*SELECT s.genre_id, g.name 
            FROM `show` s
            LEFT JOIN genre g ON g.id = s.genre_id
            WHERE s.category_id IN (1,4,5,6,7,8,9,11,15) 
            GROUP BY s.genre_id
            ORDER BY g.name*/
        
        $selected = explode(",", $subs->genres);
        
        $this->render('genre', array("genres"=>$genres, "selected"=>$selected));
    }
    

    public function actionShraniemail(){
        $subs = null;
        
        if (isset($_GET['unsub'])) {
            $subs = Subscriber::model()->findByPk($_GET['unsub']);
            if ($subs){
                setcookie("personalized",$subs->hash,time()+3600*24*365,'/');
                if (!empty($subs->email)) setcookie("personalized_email",1,time()+3600*24*365,'/');
                $subs->weekly_schedule = 0;
                $subs->save();
                setFlash("unsub-succesfull", "Uspešno smo vas odjavili iz tedenskih objav.");
            }
        }else if (isset($_COOKIE['personalized'])) {
            $subs = Subscriber::model()->findByAttributes(array('hash'=>$_COOKIE['personalized']));
            if (!$subs) setcookie('personalized', '', 1,'/'); //remove cookie
            else{
                setcookie("personalized",$subs->hash,time()+3600*24*365,'/');
                if (!empty($subs->email)) setcookie("personalized_email",1,time()+3600*24*365,'/');
            }
        }
        if (!$subs) $this->redirect(array('myschedule/izbirakategorij')); // must have cookie
        
        
        if(Yii::app()->request->isPostRequest){
            $subs->email = strtolower($_POST['email']);
            if (isset($_POST['weekly_mail'])) $subs->weekly_schedule = 1;
            else $subs->weekly_schedule = 0;
            $subs->save();
            $this->redirect(array('myschedule/index'));
        }
        
        if ($subs->weekly_schedule === null) $subs->weekly_schedule = 1;
        
        $this->render('email', array("email"=>$subs->email,"weekly_email" => $subs->weekly_schedule));
    }

    
    
}
