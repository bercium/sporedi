<?php

class VanityUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        Yii::log(end(explode("/",$route)),  CLogger::LEVEL_INFO,'urlRule');
        
        if (end(explode("/",$route)) === 'kanal'){
          if (isset($params['id'])){
            $user = User::model()->findByPk($params['id']);
            // has vanity url or not
            if ($user && $user->vanityURL) return $user->vanityURL;
            else return "person/view/".$params['id'];
          }
        }
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
      
        //if (preg_match('%^([\w-]+)%', $pathInfo, $matches)){
        $search = '';
        if (strpos($pathInfo,"/") !== false){
          $matches = explode("/",$pathInfo);
          if (empty($matches[count($matches)-1])){
            if (isset($matches[count($matches)-2])) $search = $matches[count($matches)-2];
            else return false;
          }
          else $search = $matches[count($matches)-1];
        }else $search = $pathInfo;

        // get vanity name for users
        $user = User::model()->findByAttributes(array('vanityURL'=>$search));
        if ($user){
          Yii::log($user->id, CLogger::LEVEL_INFO, 'USERFOUND');
          $_GET['id'] = $user->id;
          return "person/view";
        }

          
        //}
        return false;  // this rule does not apply
    }
}