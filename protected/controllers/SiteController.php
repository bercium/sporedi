<?php

class SiteController extends Controller {

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
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    
     /**
     * hide toolbar
     */
    protected function beforeAction($action) {
        if (($action->id == 'sitemap'))
            foreach (Yii::app()->log->routes as $route) {
                //if ($route instanceof CWebLogRoute){
                $route->enabled = false;
                //}
            }
        return true;
    }
    
    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionVerify() {
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR.'../vendor/codebird/codebird.php');
        \Codebird\Codebird::setConsumerKey("FxVQdRHrWKLZY8DG1BNPhmOWi", "eamViRP7QbeZlaJpL69OYZi8vlarO83L9R54SFwzcYO55eQG0f");
        $cb = \Codebird\Codebird::getInstance();
        
        session_start();
        if (! isset($_SESSION['oauth_token'])) {
            // get the request token
            $reply = $cb->oauth_requestToken([
              'oauth_callback' => 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
            ]);

            // store the token
            $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
            $_SESSION['oauth_token'] = $reply->oauth_token;
            $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
            $_SESSION['oauth_verify'] = true;

            // redirect to auth website
            $auth_url = $cb->oauth_authorize();
            header('Location: ' . $auth_url);
            die();

          } elseif (isset($_GET['oauth_verifier']) && isset($_SESSION['oauth_verify'])) {
            // verify the token
            $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
            unset($_SESSION['oauth_verify']);

            // get the access token
            $reply = $cb->oauth_accessToken([
              'oauth_verifier' => $_GET['oauth_verifier']
            ]);

            // store the token (which is different from the request token!)
            $_SESSION['oauth_token'] = $reply->oauth_token;
            $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;

            echo $_SESSION['oauth_token'] ."<br />". $_SESSION['oauth_token_secret'];
            exit;
        }
        
        echo $_SESSION['oauth_token'] ."<br />". $_SESSION['oauth_token_secret'];
        exit;
    }
    
    
    private function getRecomended($count = 3){
        $favs = getFavs();
        if ($favs) $favs = " IF(channel.slug IN (".$favs."),20,0)+ ";
            
        return Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory', 'show.customGenre.genre', 'show.customCategory.category'))
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
                                                            ,'limit'=>$count, // don't show if not sleep
                                                            'params' => array(':currentdatetime'=>date('Y-m-d H:i'))
                                                            ), 
                                                      array());
    }
    
    
    private function getSimmilarShows($show){
        // simmilar shows
        $similar_shows = Schedule::model()->with(array('show','channel', 'show.customCategory', 'show.customGenre'))
                                  ->findAllByAttributes(array(), 
                                                        array("condition"=>"channel.active > 0 AND day_date >= :onedayago AND day_date < :lastday",
                                                              'order' => "IF(category_id = :category AND NOT ISNULL(:category),1,0)
                                                                         +IF(genre_id = :genre AND NOT ISNULL(:genre),1,0)
                                                                         +IF(`show`.title = :title,-1,0)
                                                                         +IF(`show`.imdb_rating > :rating_min AND `show`.imdb_rating < :rating_max,1,0)
                                                                         +IF(ISNULL(`show`.description) OR `show`.description = '',0,1) 
                                                                         DESC "
                                                                        //.',IF(`show`.year > :year_min AND `show`.year < :year_max,0,1)'
                                                                        .',RAND()'
                                                               
                                                              ,'limit'=>3,
                                                              'params' => array(':onedayago'=>date('Y-m-d H:i'),
                                                                                ':lastday'=>date('Y-m-d H:i',  strtotime("+1 week")),
                                                                                ':category' => (isset($show->customCategory) ? $show->customCategory->category_id : null),
                                                                                ':genre' => (isset($show->customGenre) ? $show->customGenre->genre_id : null),
                                                                                ':title' => $show->title,
                                                                                ':rating_min' => $show->imdb_rating-10,
                                                                                ':rating_max' => $show->imdb_rating+20,
                                                                                //':year_min' => $show->year-5,
                                                                                //':year_max' => $show->year+5,
                                                                                )
                                                              ));
        return $similar_shows;
    }
    
    
    /**
     * create sitemap for the whole site
     */
    public function actionImg(){
        if (!isset($_GET['f'])) exit;
        $size = 200;
        if (isset($_GET['s'])) $size = $_GET['s'];
        $filename = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['coverPhotos'].substr($_GET['f'], 0, 2). DIRECTORY_SEPARATOR.$_GET['f'];
        if (!file_exists($filename)) exit;
        
        $type = exif_imagetype($filename);
        
        Yii::app()->clientScript->reset();
        $this->layout = 'none'; // template blank
		switch ($type){
			case IMAGETYPE_JPEG: header("Content-Type: image/jpg"); break;
			case IMAGETYPE_PNG: header("Content-Type: image/png"); break;
			case IMAGETYPE_GIF: header("Content-Type: image/gif"); break;
		}
		
        header("Content-Description: Remote Image");
        
        list($width, $height) = getimagesize($filename);
        $r = $width / $height;
        
        $oldMin = ($width > $height ? $height : $width);
        if ($oldMin > $size) {
            // don't do enything
            print file_get_contents($filename);
            exit;
        }
        
        if ($width > $height) {
            $newwidth = $size*$r;
            $newheight = $size;
        } else {
            $newheight = $size/$r;
            $newwidth = $size;
        }
		
		switch ($type){
			case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($filename); break;
			case IMAGETYPE_PNG: $src = imagecreatefrompng($filename); break;
			case IMAGETYPE_GIF: $src = imagecreatefromgif($filename); break;
		}
		
        $dst = imagecreatetruecolor($newwidth, $newheight);
        fastimagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height, 2);
        
		switch ($type){
			case IMAGETYPE_JPEG: @imagejpeg($dst); break;
			case IMAGETYPE_PNG: @imagepng($dst); break;
			case IMAGETYPE_GIF: @imagegif($dst); break;
		}
		
        imagedestroy($dst);
        exit;
    }
    
    
    /**
     * create sitemap for the whole site
     */
    public function actionSitemap($slug = 0, $type = '') {
        // don't allow any other strings before this
        Yii::app()->clientScript->reset();
        $this->layout = 'none'; // template blank

        $curdate = date('Y-m-d');
        
        $sitemapResponse = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
EOD;
        
        if ($type == 'shows'){
            $show = Show::model()->findAll("modified GROUP BY title ORDER BY id DESC LIMIT ".($slug*6000).", 6000");  // two inputs per show
            foreach ($show as $show) {

                $sitemapResponse .= "
                    <url>
                      <loc>" . Yii::app()->createAbsoluteUrl('site/oddaja', array('slug'=>substr($show->slug, 0, strrpos($show->slug, "-")),
                                                            'category'=>(isset($show->customCategory->category) ? $show->customCategory->category->slug : 'oddaja'),
                                                            'slugpart'=>substr($show->slug, strrpos($show->slug, "-")+1) 
                                                            ))  . "</loc>
                      <changefreq>monthly</changefreq>
                      <priority>0.7</priority>
                      <lastmod>$curdate</lastmod>
                    </url>";
            }
        }else if ($type == 'actors'){
            /*$actors = ShowActor::model()->with(array('person','show', 'schedule'))
                                       ->findAllByAttributes(array(), 
                                                    array("condition"=>"day_date >= :onedayago",
                                                          'group'=>'person_id',
                                                          'offset'=>$slug*6000,
                                                          'limit'=>6000,
                                                          'params' => array(':onedayago'=>date('Y-m-d',strtotime('-1 day')))
                                                          ));*/
            
            // all actors and number of projects
            $actors = Yii::app()->db->createCommand("SELECT * FROM show_actor sa LEFT JOIN person p ON p.id = sa.person_id WHERE sa.show_id IN (SELECT show_id FROM schedule WHERE start > '".date('Y-m-d',strtotime('-1 day'))."') GROUP BY sa.person_id LIMIT ".($slug*6000).", 6000")->queryAll();
            foreach ($actors as $actor) {
                $sitemapResponse .= "
                    <url>
                      <loc>" . Yii::app()->createAbsoluteUrl('site/igralec', array('slug'=>$actor['slug']))  . "</loc>
                      <changefreq>daily</changefreq>
                      <priority>0.6</priority>
                      <lastmod>$curdate</lastmod>
                    </url>";
            }
        }elseif ($type == 'directors'){
            //$directors = Yii::app()->db->createCommand("SELECT p.slug FROM `show_director` sd JOIN person p ON p.id = sd.person_id GROUP BY sd.person_id LIMIT ".($slug*6000).", 6000")->queryAll();
            $directors = Yii::app()->db->createCommand("SELECT * FROM show_director sa LEFT JOIN person p ON p.id = sa.person_id WHERE sa.show_id IN (SELECT show_id FROM schedule WHERE start > '".date('Y-m-d',strtotime('-1 day'))."') GROUP BY sa.person_id LIMIT ".($slug*6000).", 6000")->queryAll();
            foreach ($directors as $director) {
                $sitemapResponse .= "
                    <url>
                      <loc>" . Yii::app()->createAbsoluteUrl('site/reziser', array('slug'=>$director['slug']))  . "</loc>
                      <changefreq>daily</changefreq>
                      <priority>0.5</priority>
                      <lastmod>$curdate</lastmod>
                    </url>";
            }
        }else{
            if ($slug == 0){
                $sitemapResponse .= "
                <url>
                  <loc>https://sporedi.net/</loc>
                  <changefreq>daily</changefreq>
                  <priority>0.8</priority>
                  <lastmod>$curdate</lastmod>
                </url>
                <url>
                  <loc>https://sporedi.net/priporocamo</loc>
                  <changefreq>daily</changefreq>
                  <priority>0.8</priority>
                  <lastmod>$curdate</lastmod>
                </url>
                <url>
                  <loc>https://sporedi.net/iskanje</loc>
                  <changefreq>monthly</changefreq>
                  <priority>0.8</priority>
                  <lastmod>$curdate</lastmod>
                </url>";

                $max_days = 8;
                $count = 0;

                // all platforms and number of projects
                $channels = Channel::model()->findAllByAttributes(array(),"active > 0 AND id IN (SELECT channel_id FROM schedule WHERE start > NOW() GROUP BY channel_id)");
                
                foreach ($channels as $channel) {

                  for ($index = -1; $index < $max_days; $index++) {
                        $count++;
                        $sitemapResponse .= "
                            <url>
                              <loc>" . Yii::app()->createAbsoluteUrl('site/spored', array('slug'=>$channel->slug, 'secondary'=>dateToHuman(strtotime($index.' day'), false, true)))  . "</loc>
                              <changefreq>daily</changefreq>
                              <priority>0.9</priority>
                              <lastmod>$curdate</lastmod>
                            </url>";
                    }
                }

            }

            // active shows
            $shows = Schedule::model()->with(array('show'))
                                        ->findAllByAttributes(array(), 
                                                              array("condition"=>"day_date >= :onedayago",
                                                                    'group'=>'`show`.title',
                                                                    'offset'=>$slug*6000,
                                                                    'limit'=>6000,
                                                                    'params' => array(':onedayago'=>date('Y-m-d',strtotime('-1 day')))
                                                                    ));
            foreach ($shows as $show) {
                $sitemapResponse .= "
                    <url>
                      <loc>" . Yii::app()->createAbsoluteUrl('site/ponovnoNaSporedu', array(
                              'slug'=>substr($show->show->slug, 0, strrpos($show->show->slug, "-")),'slugpart'=>substr($show->show->slug, strrpos($show->show->slug, "-")+1)
                              /*$show->show->slug/*,'secondary'=>$show->show->id*/))  . "</loc>
                      <changefreq>daily</changefreq>
                      <priority>0.8</priority>
                      <lastmod>$curdate</lastmod>
                    </url>";
            }
            

        }

        $sitemapResponse .= "\n</urlset>"; // end sitemap
        $this->render("//layouts/none", array("content" => $sitemapResponse));
    }
    

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->actionTrenutniSpored();
    }
    
    
    /**
     * 
     */
    public function actionTrenutniSpored() {
        $favs = getFavs();
        $favs_shows = "";
        if ($favs){
            $favs_shows = " IF(channel.slug IN (".$favs."),0,1), ";
            $favs = " IF(slug IN (".$favs."),0,1), ";
        }
        $channels = Channel::model()->findAllByAttributes(array(),"active > 0 AND id IN (SELECT channel_id FROM schedule WHERE start > NOW() GROUP BY channel_id) ORDER BY ".$favs." active, name");
        
        $current = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory', 'show.customGenre.genre', 'show.customCategory.category'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND :currenttime >= start AND :currenttime  < DATE_ADD(start, INTERVAL length MINUTE)",
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => $favs_shows." channel.active, channel.name",
                                                                'params' => array(':currenttime'=>date('Y-m-d H:i'))
                                                                ), 
                                                          array());

        
        $next = Yii::app()->db->createCommand('SELECT s.start, sh.slug, sh.title, s.channel_id, s.id
                                            FROM (
                                                SELECT s.* FROM (SELECT MIN(start) as start, channel_id FROM schedule WHERE start > :currenttime GROUP BY channel_id) ss
                                                JOIN schedule s ON s.start = ss.start AND s.channel_id = ss.channel_id
                                                ) s
                                            JOIN `show` sh ON sh.id = s.show_id')
                              ->bindValue(":currenttime",date('Y-m-d H:i'))
                              ->queryAll();
        $next_shows = array();
        foreach ($next as $show){
          //if (!isset($next_shows[$show['channel_id']])) 
          $next_shows[$show['channel_id']] = $show;
        }

        $categories = Category::model()->findAll('id<>14 AND id<>15 AND id<>5 ORDER BY name');

        $this->pageTitle = 'TV Spored';
        $this->pageDesc = "TV spored za popularne Slovenske kanale v prihajajočem tednu. Podrobne informacije o posmaznih oddajah s slikami in opisi. POP TV, A Kanal, Slo 1, Slo 2 ,...";
        $this->keywords = 'tv spored, spored, danes, a kanal, pop tv, slo, eurosport, filmi nanizanke, nadaljevanke, resničnostne oddaje, imdb ocena, sezona, del';
        
        $this->render('current-schedule', array("schedule"=>$current, "channels" => $channels, 'upcoming'=>$next_shows, 'categories'=>$categories));
    }
    
    /**
     * moving permanently
     * 
     * @param type $slug
     * @param type $secondary
     */
    public function actionKanal($slug, $secondary = 'danes') {
        Yii::app()->getRequest()->redirect(
                Yii::app()->createAbsoluteUrl('site/spored',array("slug"=>$slug, "secondary" => $secondary))
                , true, 301);
    }
    
    
    /**
     * 
     */
    public function actionSpored($slug, $secondary = 'danes') {
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
        $cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.min.js');
        
        $date = humanToDate($secondary);

        
        $schedule = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory','show.customGenre.genre', 'show.customCategory.category'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"day_date = :currenttime AND channel.slug = :channelslug",
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => "start",
                                                                'params' => array(':currenttime'=>$date,
                                                                                  ":channelslug"=>$slug)
                                                                ), 
                                                          array());
        $days = array();
        $min_days = -1;
        //if (dateToHuman(time(), false, true) == 'vceraj') $min_days = -1;
        $max_days = 8;
        for ($index = $min_days; $index < $max_days; $index++) {
            $days[] = array('slug'=> dateToHuman(strtotime($index.' day'), false, true),'name'=> dateToHuman(strtotime($index.' day')));
        }
        
        $channel = Channel::model()->findByAttributes(array("slug"=>$slug));
        
        
        if ($secondary != 'vceraj' && $secondary != 'danes' && $secondary != 'jutri' && strpos($secondary, '-') === false){
            $title = 'TV spored v '.$secondary.' na '.$channel->name;
            //$title = 'Spored '.$channel->name." - ".$secondary;
        }else if (strpos($secondary, '-') !== false){
            $title = 'TV spored '.str_replace('-','.',$secondary).'. na '.$channel->name;
            //$title = 'TV spored '.$channel->name." - ".str_replace('-','.',$secondary);
        }
        else {
            $title = 'TV spored '.$secondary.' na '.$channel->name;
            //$title = 'TV spored '.$channel->name." - ".$secondary;
        }
        
        
        $next = strtotime($date.' + 1 day');
        if ($next > strtotime(($max_days-1).' days')) $next = null;
        
        $prev = strtotime($date.' - 1 day');
        if ($prev < strtotime(date('Y-m-d',strtotime($min_days.' day')))) $prev = null;
        
        $cat = $gen = array();
        foreach ($schedule as $item){
            if (isset($item->show->customGenre->genre)) $gen[$item->show->customGenre->genre->slug] = $item->show->customGenre->genre->name;
        }
        
        $this->pageTitle = 'TV spored '.$channel->name." za ".$secondary;
        $this->pageDesc = 'TV spored za '.$channel->name.' z opisi, slikami in ocenami. Spored za '.$channel->name.' za danes, jutri in prihajajoči teden.';
        $this->keywords = $channel->name.', včeraj, danes, jutri, '.  implode(', ',$gen).', imdb ocena, sezona, del, ponedeljek, torek, sreda, četrtek, petek, sobota, nedelja';
        
        if (strtotime($date) >= strtotime(date('Y-m-d'))) header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT", true, 200);
        else header("Last-Modified: " . gmdate("D, d M Y H:i:s", strtotime($date)) . " GMT", true, 200);
        header("Pragma: ");        
        $this->render('channel', array("schedule"=>$schedule,"channel"=>$slug, "channel_name"=>$channel->name, "day"=>$secondary, "dates" => $days, 'title'=>$title, 'next_date'=>$next, 'prev_date'=>$prev));
    }
    
    
     
    private function getHtml($link, $userAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_1_4 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B350 Safari/8536.25', $header = array(), $proxy = false, $post = array()) {
        $httpClient = new elHttpClient();
        $httpClient->setUserAgent($userAgent);
        if ($proxy == true) {
            $proxy_ip = array("101.226.249.237", "117.102.122.218", "119.188.94.145", "120.202.249.230", "122.55.96.83", "148.251.234.73", "162.223.88.243", "175.103.47.130", "177.184.8.123", "180.166.56.47", "182.163.56.88", "183.238.133.43", "190.102.17.240", "190.181.18.232", "190.221.23.158", "197.218.204.202", "198.2.202.55", "198.2.202.58", "198.99.224.134", "200.150.97.27", "219.141.225.149", "31.220.43.28", "50.63.137.198", "58.214.5.229", "63.221.140.143", "80.91.88.36", "83.172.144.19", "83.222.126.179", "89.218.38.202", "91.121.204.88", "94.247.25.163", "94.247.25.164");
            $httpClient->setProxy($proxy_ip[mt_rand(0,count($proxy_ip)-1)], 80);
        }
        $httpClient->enableRedirects();
        $httpClient->setHeaders(array_merge(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8")));
        if ($post == array()) { $htmlDataObject = $httpClient->get($link, $header);}
        elseif ($post != "") { $htmlDataObject = $httpClient->post($link, $post, $header); }
        return $htmlDataObject->httpBody;
    }
    
    
    /**
     * moving permanently
     * 
     * @param type $slug
     * @param type $secondary
     */
    public function actionSporedi($slug, $category = null, $slugpart = null, $secondary = null) {
        Yii::app()->getRequest()->redirect(
                Yii::app()->createAbsoluteUrl('site/oddaja',array("slug"=>$slug, "secondary" => $secondary, 'category'=>$category, 'slugpart'=>$slugpart))
                , true, 301);
    }    
    
    /**
     * 
     */
    public function actionOddaja($slug, $category = null, $slugpart = null, $secondary = null) {
        
        //redirect
        if ($slugpart == null || is_numeric($slugpart)){
            if (is_numeric($slugpart)) $secondary = $slugpart;
            
            $slugpart = substr($slug, strrpos($slug, "-")+1);
            $slug = substr($slug, 0, strrpos($slug, "-"));
            
            Yii::app()->getRequest()->redirect(
                Yii::app()->createAbsoluteUrl('site/oddaja',array("slug"=>$slug,'secondary'=>$secondary, 
                                      'category'=>$category, 'slugpart'=>$slugpart ))
                , true, 301);
        }else $slug .= '-'.$slugpart;
        
        
        $baseUrl = Yii::app()->baseUrl; 
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile('https://addevent.com/libs/atc/1.6.1/atc.min.js');
        $cs->registerScript("add_to_calendar_setup",'
          window.addeventasync = function(){
            addeventatc.settings({ css : false,	});
          };
        ');
        $cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.min.js');
        
		
        $show = Show::model()->with(array('customCategory','customCategory.category', 'customGenre','customGenre.genre','directors','actors'))->findByAttributes(array("slug" => $slug));
        if ($show == null || $show->modified == null){
            $showName = str_replace("-",' ',substr($slug, 0, -9));
            $suggested = $this->getRecomended();
            $this->render('show', array("show" => null,'schedule'=> null,"image"=>null,'whenAndWhere'=>null, 'reminder_title'=>null, 'reminder_description' => null,'similar'=>$showName, 'suggested' =>$suggested));
            return;
        }
        
        $image = imagePath($show->imdb_url, $show->title, (isset($show->customGenre->genre->slug) ? $show->customGenre->genre->slug : ''), (isset($show->customCategory->category->slug) ? $show->customCategory->category->slug : ''));
        $this->fbImage = basename($image);
        $this->fbImageResize = true;

        $folder = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['coverPhotos'];
        if ($show->imdb_url) $filename = toAscii($show->title.' '.my_hash($show->imdb_url)).".jpg";
        else $filename = toAscii($show->title).".jpg";
        
        $folder = $folder . substr($filename, 0, 2). DIRECTORY_SEPARATOR;
        if (isset($_GET['img'])){
            // remove img
            if ($_GET['img'] == 0 && $image != null){
                unlink($folder.$filename);
                $image = null;
            }else{
                if ($_GET['img'] == '' && $image == null){
                    // download selected image
                    $full_html = $this->getHtml($show->imdb_url, 'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/45.0');
                
                    if (strpos($full_html, 'class="poster"') !== false){
                        $html = substr($full_html, strpos($full_html, 'class="poster"'), 500);
                        $p = strpos($html, '<img');
                        $html = substr($html, $p, strpos($html,'/>',$p+1) - $p);
                        $p = strpos($html, 'src="');
                        $html = substr($html, $p+5, strpos($html,'"',$p+5) - $p-5);

                        $image_data = $this->getHtml($html);

                        if (!is_dir($folder)) mkdir($folder, 0777, true);
                        @file_put_contents($folder.$filename, $image_data);
                        $image = imagePath($show->imdb_url, $show->title, (isset($show->customGenre->genre) ? $show->customGenre->genre->slug : ''), (isset($show->customCategory->category->slug) ? $show->customCategory->category->slug : ''));
                    }
                }else if(is_string($_GET['img'])){
                    // download selected image
                    $image_data = $this->getHtml($_GET['img']);
                    
                    if (!is_dir($folder)) mkdir($folder, 0777, true);
                    @file_put_contents($folder.$filename, $image_data);
                    $image = imagePath($show->imdb_url, $show->title, (isset($show->customGenre->genre) ? $show->customGenre->genre->slug : ''), (isset($show->customCategory->category->slug) ? $show->customCategory->category->slug : ''));
                }
            }
        }
        
        // date details
        $schedule = $whenandwhere = $whenandwhere_1 = null;
        if ($secondary){
            $schedule = Schedule::model()->with('channel')->findByPk($secondary);
            if ($schedule){
                $when = dateToHuman($schedule->start, false, false, true);
                $time = date('H:i',strtotime($schedule->start));
                if (($when != 'Včeraj' && $when != 'Danes' && $when != 'Jutri') && strpos($when, '-') === false){
                    $whenandwhere_1 = 'na '.$schedule->channel->name.' v '.$when.' ob '.$time;
                    $whenandwhere = 'V '.$when.' ob '.$time.' na '.$schedule->channel->name;
                }else if (strpos($secondary, '-') !== false){
                    $whenandwhere_1 = $whenandwhere = str_replace('-','.',$when).' ob '.$time.' na '.$schedule->channel->name;
                } else {
                    $whenandwhere_1 = 'na '.$schedule->channel->name.' '.ucfirst($when).' ob '.$time;
                    $whenandwhere = ucfirst($when).' ob '.$time.' na '.$schedule->channel->name;
                }
            }
        }
        
        // simmilar shows
        $similar_shows = $this->getSimmilarShows($show);
        
        
        $reminder_title = $show->title.(isset($schedule->id) ? ", ".Yii::app()->dateFormatter->formatDateTime(strtotime($schedule->start),'medium',"short").' na '.$schedule->channel->name : "");
            
        $reminder_description = (isset($show->customGenre->genre->name) ? $show->customGenre->genre->name.', ' : ''). $show->country." ".$show->year.PHP_EOL;
        $reminder_description .= PHP_EOL.$show->description;
        $reminder_description .= PHP_EOL.PHP_EOL."Več si lahko preberete tukaj: ".Yii::app()->createAbsoluteUrl('site/oddaja', array('slug'=>substr($show->slug, 0, strrpos($show->slug, "-")),
                                                                                                                'secondary'=>(isset($schedule->id) ? $schedule->id : null),
                                                                                                                'category'=>(isset($show->customCategory->category) ? $show->customCategory->category->slug : 'oddaja'),
                                                                                                                'slugpart'=>substr($show->slug, strrpos($show->slug, "-")+1) 
                                                                                                                  ));
        
        
        $this->pageTitle = $show->title.' '.$whenandwhere_1;
        $this->pageDesc = trim_text($show->description." ".(isset($show->customGenre->genre->name) ? $show->customGenre->genre->name.', ' : ''). $show->country." ".$show->year.', '.$show->title.' '.$whenandwhere_1, 150);
        $this->keywords = (($show->country != null) ? $show->country.', ': '' ).(($show->year != null) ? $show->year.', ': '' ).
                          (($show->customGenre != null && $show->customGenre->genre != null) ? $show->customGenre->genre->name.', ': '' ).
                          (($show->customCategory != null && $show->customCategory->category != null) ? $show->customCategory->category->name.', ': '' ).
                          (($show->season != null) ? $show->season.'. sezona, ':'' ).(($show->episode != null) ? $show->episode.'. del, ':'' ).", imdb ocena";
        
  
        //header('Cache-Control: cache, private, must-revalidate, max-age=31536000');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s", strtotime($show->modified)) . " GMT", true, 200);
        header("Pragma: ");
        
        if ($schedule && strtotime($schedule->start) < time()){
          header("Link: <".Yii::app()->createAbsoluteUrl('site/oddaja', array('slug'=>substr($show->slug, 0, strrpos($show->slug, "-")),
                                                                              'category'=>(isset($show->customCategory->category) ? $show->customCategory->category->slug : 'oddaja'),
                                                                              'slugpart'=>substr($show->slug, strrpos($show->slug, "-")+1) 
                                                                              )).">; rel=canonical");
        }
        
        $this->render('show', array("show" => $show,'schedule'=> $schedule,"image"=>$image,
                      'whenAndWhere'=>$whenandwhere, 'reminder_title'=>$reminder_title, 'reminder_description' => $reminder_description,
                      'similar'=>$similar_shows));
    }
    
    
    /**
     * 
     */
    public function actionIgralec($slug) {
        $schedule = Schedule::model()->with(array('channel', 'show', /*'show.customCategory', 'show.customCategory.category',*/ 'show.actors'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND actors.slug = :personname AND start > :currenttime",
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => "DATE_ADD(start, INTERVAL length MINUTE)",
                                                                'params' => array(':personname'=>$slug,':currenttime'=>date('Y-m-d'))
                                                                ), 
                                                          array());
        $schedule_past = Schedule::model()->with(array('channel', 'show', /*'show.customCategory', 'show.customCategory.category',*/ 'show.actors'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND actors.slug = :personname AND start < :currenttime",
                                                                //"order" => "channel.active, channel.name",
                                                                "group" => "original_title LIMIT 10",
                                                                'params' => array(':personname'=>$slug,':currenttime'=>date('Y-m-d'))
                                                                ), 
                                                          array());
        
        $favs = getFavs();
        if ($favs) $favs = " IF(slug IN (".$favs."),0,1), ";
        $channels = Channel::model()->findAllByAttributes(array(),"active > 0 AND id IN (SELECT channel_id FROM schedule WHERE start > NOW() GROUP BY channel_id) ORDER BY ".$favs." active, name");
        
        $person = Person::model()->findByAttributes(array("slug"=>$slug));
        
        $name = '';
        if (isset($person)) $name = $person->name;
        $this->pageTitle = "Igralec ".$name;
        $this->pageDesc = "Spored oddaj v katerih igra ".$name.". Oddaje z igralcem ".$name." za danes, jutri in prihajajoči teden.";
        $this->keywords = 'igralci, '.$name.', oddaja, danes, na sporedu, tv spored, imdb ocena';
        
        $suggested = null;
        if (count($schedule) == 0){
            $suggested = $this->getRecomended();
        }
        
        /*header("Link: <".Yii::app()->createAbsoluteUrl('site/oddaja', array('slug'=>substr($show->slug, 0, strrpos($show->slug, "-")),
                                                                    'category'=>(isset($show->customCategory->category) ? $show->customCategory->category->slug : 'oddaja'),
                                                                    'slugpart'=>substr($show->slug, strrpos($show->slug, "-")+1) 
                                                                    )).">; rel=canonical"); */
        
        $this->render('person', array("schedule"=>$schedule, "channels" => $channels, 'person'=>$person, 'suggested'=>$suggested, 'past_shows'=>$schedule_past, 'type_of_person' => "actor"));
    }
    
    
    /**
     * 
     */
    public function actionReziser($slug) {
        $schedule = Schedule::model()->with(array('channel', 'show', 'show.directors'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND directors.slug = :personname AND start > :currenttime",
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => "DATE_ADD(start, INTERVAL length MINUTE)",
                                                                'params' => array(':personname'=>$slug,':currenttime'=>date('Y-m-d'))
                                                                ), 
                                                          array());
        
        $schedule_past = Schedule::model()->with(array('channel', 'show',  'show.directors'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=>"channel.active > 0 AND directors.slug = :personname AND start < :currenttime",
                                                                //"order" => "channel.active, channel.name",
                                                                "group" => "original_title LIMIT 10",
                                                                'params' => array(':personname'=>$slug,':currenttime'=>date('Y-m-d'))
                                                                ), 
                                                          array());        
        
        $favs = getFavs();
        if ($favs) $favs = " IF(slug IN (".$favs."),0,1), ";
        $channels = Channel::model()->findAllByAttributes(array(),"active > 0 AND id IN (SELECT channel_id FROM schedule WHERE start > NOW() GROUP BY channel_id) ORDER BY ".$favs." active, name");

        $person = Person::model()->findByAttributes(array("slug"=>$slug));
        
        $name = '';
        if (isset($person)) $name = $person->name;
        
        $this->pageTitle = "Režiser ".$name;
        $this->pageDesc = "Spored oddaj, ki jih je režiral ".$name.". Oddaje režiserja ".$name." za danes jutri in prihodnji teden.";
        $this->keywords = 'režiserji, '.$name.', oddaja, danes, na sporedu, tv spored, imdb ocena';
        
        $suggested = null;
        if (count($schedule) == 0){
            $suggested = $this->getRecomended();
        }
        
        $this->render('person', array("schedule"=>$schedule, "channels" => $channels, 'person'=>$person, 'suggested'=>$suggested, 'past_shows'=>$schedule_past, 'type_of_person' => "director"));
    }
    
    
        /**
     * moving permanently
     * 
     * @param type $slug
     * @param type $secondary
     */
    public function actionOddaje($slug) {
        $slugpart = substr($slug, strrpos($slug, "-")+1);
        $slug = substr($slug, 0, strrpos($slug, "-"));
            
        Yii::app()->getRequest()->redirect(Yii::app()->createAbsoluteUrl('site/ponovnoNaSporedu',array("slug"=>$slug, 'slugpart'=>$slugpart )) , true, 301);
    }
    
    /**
     * 
     */
    public function actionPonovnoNaSporedu($slug, $slugpart=null) {
        $inSlug = $slug;
        $search = ucwords(str_replace("-", " ", $inSlug));
        //redirect
        if ($slugpart == null){
            $slugpart = substr($inSlug, strrpos($inSlug, "-")+1);
            $slug = substr($inSlug, 0, strrpos($inSlug, "-"));
            
            Yii::app()->getRequest()->redirect(Yii::app()->createAbsoluteUrl('site/ponovnoNaSporedu',array("slug"=>$slug, 'slugpart'=>$slugpart )) , true, 301);
        }else $slug = $inSlug.'-'.$slugpart;
        
        $show = Show::model()->findByAttributes(array('slug' => $slug ));
        
        if (!$show){
          $show = Show::model()->findByAttributes(array(), array("condition"=> 'slug LIKE "'.$inSlug.'%"'));
        }
        
        $schedule = null;
        if ($show){
          $schedule = Schedule::model()->with(array('channel', 'show', 'show.customCategory', 'show.customCategory.category'))
                                     ->findAllByAttributes(array(), 
                                                          array("condition"=>"show.original_title = :showname AND start > :currenttime",
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => "start",
                                                                'params' => array(':showname'=>$show->original_title,':currenttime'=>date('Y-m-d'))
                                                                ), 
                                                          array());
        }
        if (!$schedule){
        $schedule = Schedule::model()->with(array('channel', 'show', 'show.customCategory', 'show.customCategory.category'))
                                     ->findAllByAttributes(array(), 
                                                          array("condition"=>"(show.original_title = :showname OR show.title = :showname ) AND start > :currenttime",
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => "start", //"DATE_ADD(start, INTERVAL length MINUTE)",
                                                                'params' => array(':showname'=>$search,':currenttime'=>date('Y-m-d'))
                                                                ), 
                                                          array());    
        }
        
        $favs = getFavs();
        if ($favs) $favs = " IF(slug IN (".$favs."),0,1), ";
        $channels = Channel::model()->findAllByAttributes(array(),"active > 0 AND id IN (SELECT channel_id FROM schedule WHERE start > NOW() GROUP BY channel_id) ORDER BY ".$favs." active, name");
        
        $this->pageTitle = $show->title;
        if (!trim($this->pageTitle) && !empty($show->originalTitle)) $this->pageTitle = $show->originalTitle;
        if (!trim($this->pageTitle)) $this->pageTitle = $search;
        
        if (isset($show->title) && $show->title == '') $show->title = $this->pageTitle;
        
        $this->pageDesc = "Kdaj bo ".$this->pageTitle." ponovno na sporedu? Mogoče ".$this->pageTitle." prihaja na vaš tv ekran v prihajajočem tednu.";
        $this->keywords = 'ponovno, tv spored, '.$this->pageTitle.", ".(($show->country != null) ? $show->country.', ': '' ).(($show->year != null) ? $show->year.', ': '' ).
                          (($show->customGenre != null && $show->customGenre->genre != null) ? $show->customGenre->genre->name.', ': '' ).(($show->customCategory != null && $show->customCategory->category != null) ? $show->customCategory->category->name.', ': '' );
        
        
        $suggested = null;
        //if (count($schedule) == 0){
            //$suggested = $this->getRecomended();
        //}
        if (count($schedule) > 0){
            foreach ($schedule as $sim){
                $suggested = $this->getSimmilarShows($sim->show);
                break;
            }
        }else{
            $suggested = $this->getRecomended();
        }
        
        if (count($schedule) == 0){
          header("Link: <".Yii::app()->createAbsoluteUrl('site/oddaja', array('slug'=>substr($show->slug, 0, strrpos($show->slug, "-")),
                                                                              'category'=>(isset($show->customCategory->category) ? $show->customCategory->category->slug : 'oddaja'),
                                                                              'slugpart'=>substr($show->slug, strrpos($show->slug, "-")+1) 
                                                                              )).">; rel=canonical");
        }
            
        $this->render('shows', array("schedule"=>$schedule, "channels" => $channels, "show"=>$show, 'suggested'=>$suggested));
    }

    
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIskanje($q = '') {
        
        $search = urldecode($q);
        $search_partial = "%".$search."%";
        
        $where = '';
        $where_parameters = array();
        $datelimit = false;
        
        if (is_numeric($search)){
            
            if ((float)$search <= 10){
                // imdb rating
                $where = 'AND imdb_rating >= :imdb_rating';
                $where_parameters = array(":imdb_rating" => ($search*10));
            }else{
                // year
                $where = 'AND year = :year';
                $where_parameters = array(":year" => $search);
            }
        }else{
            // AND episode, season
            $re = "/(\\d)[\\.|' ']+(del|epizoda|sezona)/i"; 
            preg_match_all($re, $search, $matches);
            if (count($matches[0]) > 0){
                
                for ($index = 0; $index < count($matches[0]); $index++) {
                    if (strtolower($matches[2][$index]) == 'del' || strtolower($matches[2][$index]) == 'epizoda'){
                         $where .= ' AND episode = :episode ';
                         $where_parameters = array_merge($where_parameters,array(':episode' => (int)$matches[1][$index]));
                    }
                    if (strtolower($matches[2][$index]) == 'sezona'){
                         $where .= ' AND season = :season ';
                         $where_parameters = array_merge($where_parameters,array(':season' => (int)$matches[1][$index]));
                    }
                    
                    $search = trim(str_replace($matches[0][$index], "", $search));
                }
            }
            
            // AND ocena
            $re = "/(ocena)[' '\\:]+(\\d[\\.|,]?\\d?)/i"; 
            preg_match_all($re, $search, $matches);
            if (count($matches[0]) > 0){
                $where .= ' AND imdb_rating >= :rating ';
                $where_parameters = array_merge($where_parameters,array(':rating' => ($matches[2][0]*10)));
                    
                $search = trim(str_replace($matches[0][0], "", $search));
            }
            
            // AND days
            $re = "/(v[c|č]eraj|danes|jutri|pojutri[s|š]nem|ponedeljek|torek|sreda|[c|č]etrtek|petek|sobota|nedelja)/iu"; 
            preg_match_all($re, $search, $matches);
            if (count($matches[0]) > 0){
                $where .= " AND (";

                for ($index = 0; $index < count($matches[0]); $index++) {
                    $date_search = '';
                    
                    if ($matches[0][$index] == 'včeraj') $date_search = 'vceraj';
                    //else if (strtolower($matches[0][$index]) == 'pojutrišnem') $date_search = 'pojutrisnem';
                    else if (strtolower($matches[0][$index]) == 'včeraj') $date_search = 'vceraj';
                    else if (strtolower($matches[0][$index]) == 'četrtek') $date_search = 'cetrtek';
                    else $date_search = strtolower($matches[0][$index]);
                    
                    $date_search = humanToDate($date_search);
                    
                    if ($index > 0) $where .= ' OR ';
                    $where .= ' day_date = :date'.$index.' ';
                    $where_parameters = array_merge($where_parameters,array(':date'.$index => $date_search));
                    
                    $search = trim(str_replace($matches[0][$index], "", $search));
                }
                
                $where .= ")";
                $datelimit = true;
            }
            
            // AND time slots
            //6-12  12-19  19-23 23-06
            
            if (stripos($search, "trenutno") !== false){
                $where .= ' AND :currenttimesearch >= start AND :currenttimesearch < DATE_ADD(start, INTERVAL length MINUTE)';
                $where_parameters = array_merge($where_parameters,array(':currenttimesearch' => date('Y-m-d H:i') ));
                $search = trim(str_replace("trenutno", "", $search));
                
                $datelimit = true;
            }elseif (stripos($search, "zjutraj") !== false){
                $where .= " AND TIME(start) BETWEEN '06:00' AND '12:00'";
                $search = trim(str_replace("zjutraj", "", $search));
                
                $datelimit = true;
            }elseif (stripos($search, "popoldan") !== false){
                $where .= " AND TIME(start) BETWEEN '12:00' AND '19:00'";
                $search = trim(str_replace("popoldan", "", $search));
                
                $datelimit = true;
            }elseif (mb_stripos($search, "zvečer") !== false || stripos($search, "zvecer") !== false){
                $where .= " AND TIME(start) BETWEEN '19:00' AND '23:00'";
                $search = trim(str_replace("zvečer", "", $search));
                $search = trim(str_replace("zvecer", "", $search));
                
                $datelimit = true;
            }elseif (mb_stripos($search, "ponoči") !== false || stripos($search, "ponoci") !== false){
                $where .= " AND (TIME(start) > '23:00' OR TIME(start) < '06:00')";
                $search = trim(str_replace("ponoči", "", $search));
                $search = trim(str_replace("ponoci", "", $search));
                
                $datelimit = true;
            }

            
            $search_partial = "%".$search."%";
            
            // regular search
            $where .= ' AND (title LIKE :title OR original_title LIKE :title OR channel.name LIKE :title OR category.name = :category OR category.name = :category_partial OR genre.name = :genre)';
            $where_parameters = array_merge($where_parameters,array(":title" => $search_partial, ":category" => $search, ":category_partial" => $search_partial, ":genre" => $search));
        }
        if ($datelimit){
            $where = "channel.active > 0 ".$where;
        }else{
            $where = "channel.active > 0 AND start >= :currenttime ".$where;
            $where_parameters = array_merge(array(':currenttime'=>date('Y-m-d H:i',strtotime('-1 hour'))), $where_parameters );
        }
        $current = Schedule::model()->with(array('channel', 'show', 'show.customGenre', 'show.customCategory','show.customGenre.genre', 'show.customCategory.category'))
                                    ->findAllByAttributes(array(), 
                                                          array("condition"=> $where,
                                                                //"order" => "channel.active, channel.name",
                                                                "order" => "DATE_ADD(start, INTERVAL length MINUTE) LIMIT 50",
                                                                'params' => $where_parameters
                                                                ));
        
        $favs = getFavs();
        if ($favs) $favs = " IF(slug IN (".$favs."),0,1), ";
        $channels = Channel::model()->findAllByAttributes(array(),"active > 0 AND id IN (SELECT channel_id FROM schedule WHERE start > NOW() GROUP BY channel_id) ORDER BY ".$favs." active, name");
        
        $search = urldecode($q);
        if (!$search){
            $this->pageTitle = 'Iskalnik po tv sporedu';
            $this->pageDesc = "Napredno iskanje tv sporedov po dnevih po IMDB oceni po sezoni ali delu in še več.";
            $this->keywords = 'tv spored, sporedi, imdb, sezona , danes, a kanal, pop tv, slo, eurosport, filmi nanizanke, nadaljevanke, resničnostne oddaje';
            $current = null;
        }else{
            $this->pageTitle = 'Iskanje oddaje '.$search;
            $this->pageDesc = "Iskanje tv sporedov za iskalni niz: ".$search;
            $this->keywords = 'tv spored, sporedi, imdb, danes, a kanal, pop tv, slo, eurosport, filmi nanizanke, nadaljevanke, resničnostne oddaje';
        }
        
        $suggested = null;
        if (count($current) == 0){
            $suggested = $this->getRecomended();
        }
        
        $this->render('search', array("schedule"=>$current, "channels" => $channels, "search" => $search, 'suggested' => $suggested));
    }
    
    
    /**
     * 
     */
    public function actionPriljubljeni(){
        
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
        $cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.min.js');
        
        $favs = getFavs();
        if ($favs) $favs = " IF(slug IN (".$favs."),0,1), ";
        $channels = Channel::model()->findAllByAttributes(array(),"active > 0 ORDER BY ".$favs." active, name");
        
        $this->render('favourites', array("channels" => $channels));
    }
    
    
    /**
     * 
     */
    public function actionZgodovina($m = '', $c = '', $d = ''){
        return;
        $title = $breadcrumbs = $months = $days = $channels = $shows = '';
        $this->pageTitle = 'Zgodovina TV sporedov';
        
        if ($m == ''){
            $months = Schedule::model()->findAll("start > now()-interval 3 month GROUP BY YEAR(start), MONTH(start) ORDER BY YEAR(start) DESC, MONTH(start)");  // two inputs per show
        }else if($d == ''){
            
            $days = Schedule::model()->findAll("EXTRACT(YEAR_MONTH FROM `start`) = :month GROUP BY DAY(start) ORDER BY start ASC", array(":month" => str_replace("-", "", $m) ));  // two inputs per show
            $year = date("Y",strtotime($m.'-01'));
            $month = date("m",strtotime($m.'-01'));
            
            $title =  monthNames($month)." ".$year;
            $this->pageTitle = 'Zgodovina TV sporedov za '.$title;
            $breadcrumbs = '<a href="'.Yii::app()->createUrl('site/zgodovina').'">Celotna zgodovina</a> > '.$title;
            
        }else if($c == ''){
            $year = date("Y",strtotime($m.'-'.$d));
            $month = date("m",strtotime($m.'-'.$d));
            
            $title = (int)$d.". ".monthNames($month)." ".$year;
            
            $breadcrumbs = '<a href="'.Yii::app()->createUrl('site/zgodovina').'">Celotna zgodovina</a>'
                           .' > '.
                           '<a href="'.Yii::app()->createUrl('site/zgodovina',array('m'=>$m)).'">'.monthNames($month)." ".$year.'</a>'
                           .' > '.$d.". ".dayNames(date("N",strtotime($m.'-'.$d)));
            
            $channels = Schedule::model()->findAll("DATE(`start`) = :date GROUP BY channel_id ORDER BY start ASC", array(":date" => $m.'-'.$d ));  // two inputs per show
            
            $this->pageTitle = 'Zgodovina TV sporedov za '.$title;
        }else{
            $year = date("Y",strtotime($m.'-'.$d));
            $month = date("m",strtotime($m.'-'.$d));
            $ch = Channel::model()->findByPk($c);
            
            $title = $ch->name.", ".(int)$d.". ".monthNames($month)." ".$year;
            
            $breadcrumbs = '<a href="'.Yii::app()->createUrl('site/zgodovina').'">Celotna zgodovina</a>'
                           .' > '.
                           '<a href="'.Yii::app()->createUrl('site/zgodovina',array('m'=>$m)).'">'.monthNames($month)." ".$year.'</a>'
                           .' > '.
                           '<a href="'.Yii::app()->createUrl('site/zgodovina',array('m'=>$m, "d"=>$d)).'">'.$d.". ".dayNames(date("N",strtotime($m.'-'.$d))).'</a>'
                           .' > '.$ch->name;
            
            $shows = Schedule::model()->findAll("DATE(`start`) = :date AND channel_id = :channel ORDER BY start ASC", array(":date" => $m.'-'.$d, ":channel" => $c ));  // two inputs per show
            
            $this->pageTitle = 'Zgodovina TV sporedov za '.$title;
        }
        
        $this->render('history', array("title"=>$title, "breadcrumbs" => $breadcrumbs, 'months' => $months, 'days' =>$days, "channels" => $channels, "shows" => $shows ));
        
        
        
    }
    
    
     public function actionTestparser($channel, $offset = 0, $extend = false){
        $class_name = "Parser".str_replace("-",'',ucfirst($channel))."Class";

        $insert_show = new ShowManipulator();
        $string = '';

        // verify class
        if (!@class_exists($class_name)){
            $string .= "<h1>Schedule parser missing: ".$class_name."</h1>";
            return; // no parser for this channel
        }

        // load shows per day
        $parser = new $class_name();
        $shows = $parser->schedule(date("Y-m-d",strtotime("+".$offset." day")));

        if (!$shows || count($shows) <= 0){
            $string .= "<h1>No shows for channel ".$channel."</h1>";
            return;
        }
        
        // details about a show
        $channel_shows = [];
        foreach ($shows as $show){
            $fullShow = $parser->showInfo($show);

            $channel_shows[] = $fullShow;
        }
        unset($shows);
        
        
        foreach ($channel_shows as $num => $show){
            if ($extend) $db_show = $insert_show->insertShow($show, true);

            $string .= "<h3>ROW: ".$num."</h3>";
            foreach ($show as $key => $value) {
                if (isset($db_show->$key) && $value != $db_show->$key){
                    $db_value = $db_show->$key;
                    if ($key == 'custom_category_id' && isset($db_show->customCategory)) $db_value = $db_show->$key." (<i>".$db_show->customCategory->name."</i>)";
                    if ($key == 'custom_genre_id' && isset($db_show->customGenre)) $db_value = $db_show->$key." (<i>".$db_show->customGenre->name."</i>)";

                    $string .="&nbsp;&nbsp;&nbsp;&nbsp;<strong>".$key."</strong> => ".$value." | <span style='color:#BB4444;'>".$db_value."</span></br>\n";
                }else $string .= "&nbsp;&nbsp;&nbsp;&nbsp;".$key." => ".$value."</br>\n";
            }
            $string .= "</br>\n";
        }
        
        $this->render('parser', array("string"=>$string));
    } 

}
