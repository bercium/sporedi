<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/default';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    public $pageDesc = '';
    public $keywords = '';
    public $fbImage = '';
    public $fbImageResize = false;
  
  
public function init(){
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
      
    //$cs->registerCssFile($baseUrl.'/css/foundation.css');
    if (YII_DEBUG){
        $cs->registerCssFile($baseUrl.'/css/main.css'.getVersionID());   
        $cs->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/normalize.min.css');
        $cs->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/foundation.min.css');
        $cs->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css');
    }else{
        $cs->registerCssFile($baseUrl.'/css/combined-all.min.css'.getVersionID());
    }

    // JAVASCRIPTS
    if (YII_DEBUG){
        //$cs->registerCoreScript('jquery');  //core jquery lib
        $cs->registerScriptFile($baseUrl.'/js/vendor/jquery.min.js', CClientScript::POS_END);  
        $cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', CClientScript::POS_END, array('async'=>'async'));  //modernizer
        $cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation.min.js', CClientScript::POS_END);

        //$cs->registerScriptFile($baseUrl.'/js/vendor/fastclick.js', CClientScript::POS_END, array('async'=>'async'));
        $cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js', CClientScript::POS_END, array('async'=>'async')); // foundation bug in FF with select so we need newest fastclick

        $cs->registerScriptFile($baseUrl.'/js/jquery.scrolldepth.min.js', CClientScript::POS_END, array('async'=>'async')); //scroll tracker
        //$cs->registerScriptFile($baseUrl.'/js/chosen.jquery.min.js');  // new dropdown
        //$cs->registerScriptFile($baseUrl.'/js/jquery.timers.min.js');  // timers
        //$cs->registerScriptFile('https://platform.twitter.com/widgets.js');

        // startup scripts
        $cs->registerScriptFile($baseUrl.'/js/app.js'.getVersionID(), CClientScript::POS_END, array('async'=>'async'));
        
        $cs->registerScript("scrollDepth","$(function() { $.scrollDepth({pixelDepth:false}); });");
    }
    
    
    $cs->registerScriptFile('//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',CClientScript::POS_HEAD, array('async'=>'async'));
    // google analytics
    $cs->registerScript("ganalytics","

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');


        ga('create', 'UA-9773251-9', 'auto');
        ga('require', 'displayfeatures');
        ga('send', 'pageview');
     ",CClientScript::POS_HEAD);
    //ga('set', '&uid', <?php echo ? >); // Set the user ID using signed-in user_id.
    //ga('require', 'linkid', 'linkid.js');
    $cs->registerScript("mobileads",'
        (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-0534207295672567",
          enable_page_level_ads: true
        });
     ',CClientScript::POS_HEAD);    
    
    
    
    parent::init();
  }
  
  public function run($in_actionID){
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
    
    if (YII_DEBUG){
        // general controller JS
        if (file_exists("js/controllers/".Yii::app()->controller->id."/controller.js"))
          $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/controller.js".getVersionID(), CClientScript::POS_END, array('async'=>'async'));
        // specific action JS
        if (!$in_actionID) $actionID = $this->defaultAction;
        else $actionID =  $in_actionID;

        if (file_exists("js/controllers/".Yii::app()->controller->id."/".$actionID.".js"))
          $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/".$actionID.".js".getVersionID(), CClientScript::POS_END, array('async'=>'async'));
    }else{
        if (!file_exists('assets/js')) mkdir("assets/js");
        $content = $name = '';
        $c1 = $c2 = false;
        // general controller JS
        if (file_exists("js/controllers/".Yii::app()->controller->id."/controller.js")){
            $name = Yii::app()->controller->id."-controller";
            $c1 = true;
        }
        // specific action JS
        if (!$in_actionID) $actionID = $this->defaultAction;
        else $actionID =  $in_actionID;

        if (file_exists("js/controllers/".Yii::app()->controller->id."/".$actionID.".js")){
            $name = Yii::app()->controller->id."-".$actionID;
            $c2 = true;
        }
        
        $name = substr(getVersionID(), 1).'-'.$name.".js";
        
        if (!file_exists("assets/js/".$name) && ($c1 || $c2)){
            if ($c1) $content = file_get_contents("js/controllers/".Yii::app()->controller->id."/controller.js");
            if ($c2) $content .= "\n\n".file_get_contents("js/controllers/".Yii::app()->controller->id."/".$actionID.".js");
            $content = file_get_contents("js/combined-all.min.js")."\n\n".$content;
            file_put_contents("assets/js/".$name, $content);
        }
        
        // load all combined JS files
        if ($c1 || $c2) $cs->registerScriptFile($baseUrl.'/assets/js/'.$name, CClientScript::POS_END, array('async'=>'async'));
        else $cs->registerScriptFile($baseUrl.'/js/combined-all.min.js'.getVersionID(), CClientScript::POS_END, array('async'=>'async'));
                
    }
    
    //echo "<br /><br /><br />".Yii::app()->controller->id."/".$actionID.".js".getVersionID();
    parent::run($in_actionID);
  }  
}
