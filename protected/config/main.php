<?php

require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../components/global.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$a = array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'TV Spored',
        'sourceLanguage'=>'sl_SI',
        //'timeZone' => 'CET',
        'timeZone' => 'Europe/Ljubljana',
// preloading 'log' component
        'preload' => array('log'),
        // autoloading model and component classes
        'import' => array(
                'application.models.*',
                'application.components.*',
                'application.commands.*',
                'application.vendor.*',
                'ext.giix-components.*', // giix components
                'ext.mail.YiiMailMessage', // mail system
                'application.components.parsers.*',
        ),
        'modules' => array(
                'gii' => array(
                        'class' => 'system.gii.GiiModule',
                        'generatorPaths' => array(
                                'ext.giix-core', // giix generators
                        ),
                        // If removed, Gii defaults to localhost only. Edit carefully to taste.
                        'ipFilters' => array('127.0.0.1', '::1'),
                ),
        ),
        // application components
        'components' => array(
                'user' => array(
                        // enable cookie-based authentication
                        'allowAutoLogin' => true,
                        'autoUpdateFlash' => false,
                ),
                // uncomment the following to enable URLs in path-format
                'urlManager' => array(
                        'urlFormat' => 'path',
                        'showScriptName' => false,
                        'rules' => array(
                                '' => 'site/index',
                                'error' => 'site/error',
                                'customGenre/<action:\w+>' => 'customGenre/<action>',
                                'customCategory/<action:\w+>' => 'customCategory/<action>',
                                'show/<action:\w+>' => 'show/<action>',
                                'genre/<action:\w+>' => 'genre/<action>',
                                'schedule/<action:\w+>' => 'schedule/<action>',
                                
                                'sitemap/<slug:\d+>' => 'site/sitemap',
                                'gii/<controller:\w+>/<action:[\w]+>' => 'gii/<controller>/<action>',
                                'koledar' => 'calendar/index',
                                'koledar/<action:\w+>' => 'calendar/<action>',
                                'cron/<action:\w+>' => 'cron/<action>',
                                'priporocamo' => 'myschedule/index',
                                'priporocamo/<action:\w+>' => 'myschedule/<action>',
                                
                                '<slug:[\w-]+>/<action:\w+>/kanal' => 'site/kanal', // old reference
                                '<slug:[\w-]+>/spored/<secondary:[\w-]+>' => 'site/spored',
                                
                                '<slug:[\w-]+>/oddaje' => 'site/oddaje',
                                '<slug:[\w-]+>/ponovno-na-sporedu/<slugpart:\w+>' => 'site/ponovnoNaSporedu',
                                
                                '<slug:[\w-]+>/<category:[\w-]+>/<slugpart:\w+>/<secondary:[\w-]+>' => 'site/oddaja',
                                '<slug:[\w-]+>/<category:[\w-]+>/<slugpart:\w+>' => 'site/oddaja',
                                'sporedi/<slug:[\w-]+>/<category:[\w-]+>/<slugpart:\w+>/<secondary:[\w-]+>' => 'site/sporedi',
                                //'<slug:[\w-]+>/<category:[\w-]+>/<secondary:[\w-]+>' => 'site/oddaja',
                                //'<slug:[\w-]+>/<action:\w+>/<secondary:[\w-]+>' => 'site/<action>',
                                '<slug:[\w-]+>/<action:\w+>' => 'site/<action>',
                                '<action:\w+>' => 'site/<action>',
                                //'admin/<controller:\w+>/<action:[\w]+>' => '<controller>/<action>',
                                
                                //'http://<slug:[\w-]+>.sporedi.tv/<secondary:[\w-]+>/kanal' => 'site/kanal',
                                //'http://<slug:[\w-]+>.sporedi.tv/kanal' => 'site/kanal',
                                //'<slug:[\w-]+>' => 'site/iskanje?q=<slug>',
                                /*'<controller:\w+>/<id:\d+>' => '<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>/<data:\w+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',*/
                        ),
                ),
                'clientScript' => array(
                        'coreScriptPosition' => CClientScript::POS_END,
                        'defaultScriptPosition' => CClientScript::POS_END,
                        'defaultScriptFilePosition' => CClientScript::POS_END,
                ),
                // uncomment the following to use a MySQL database
                'db' => array(
                        'enableProfiling' => YII_DEBUG,
                        'enableParamLogging' => YII_DEBUG,
                        'initSQLs' => array("set time_zone='+00:00'; wait_timeout=60;"),
                ),
                'errorHandler' => array(
                        // use 'site/error' action to display errors
                        'errorAction' => 'site/error',
                ),
                'log' => array(
                        'class' => 'CLogRouter',
                        'routes' => array(
                                array(
                                        //'class'=>'CWebLogRoute',
                                        'levels' => 'error, warning, trace, info',
                                        'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                                        'ipFilters' => array('127.0.0.1'),
                                        'enabled' => YII_DEBUG,
                                ),
                                array(
                                        'levels' => 'error',
                                        'class' => 'CEmailLogRoute',
                                        'emails' => array('info@sporedi.net'),
                                        //'categories' => 'exception.*, system.*',
                                        'sentFrom' => 'script@sporedi.net',
                                        'subject' => 'Error on production for Sporedi.net',
                                        'utf8' => true,
                                        'enabled' => (!YII_DEBUG), // send mail only from production
                                        //'enabled'=>YII_DEBUG,
                                        //*'categories'=>'system.db.*',* /
                                        'except' => 'exception.CHttpException.*,system.db.CDbCommand,exception.CDbException'
                                ),
                                array(
                                        'levels' => 'error',
                                        'class' => 'CFileLogRoute',
                                        'logFile' => 'application.error.log',
                                        'enabled' => !YII_DEBUG,
                                //'enabled'=>YII_DEBUG,
                                /* 'categories'=>'system.db.*', */
                                ),
                                array(
                                        'levels' => 'warning',
                                        'class' => 'CFileLogRoute',
                                        'logFile' => 'application.warning.log',
                                        'enabled' => !YII_DEBUG,
                                /* 'categories'=>'system.db.*', */
                                ),
                        // uncomment the following to show log messages on web pages
                        /*
                          array(
                          'class'=>'CWebLogRoute',
                          ), */
                        ),
                ),
                'mail' => array(
                        'class' => 'ext.mail.YiiMail',
                        'transportType' => 'php', //smtp
                        /* 'transportOptions' => array_merge(array(
                          'host' => 'smtp.gmail.com',
                          'port' => '465',
                          'encryption'=>'tls',
                          ),require(dirname(__FILE__) . '/local-mail.php')
                          ), */
                        'viewPath' => 'application.views.layouts.mail',
                        'logging' => YII_DEBUG,
                        'dryRun' => YII_DEBUG
                ),
        ),
        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params' => array(
                // this is used in contact page
                'version'=>'1.6.6',
                'adminEmail'=>array('spored@sporedi.net'=>'TV Spored'),
                'absoluteHost' => 'http://sporedi.net/',
			    'mapsFolder'=>'data/',
				'coverPhotos'=>'uploads/covers/',
                'dataFolder'=>'uploads/maps/',
                'genresPhotos' => 'uploads/genres/',
                'categoriesPhotos' => 'uploads/categories/',
        ),
);

$b = require(dirname(__FILE__) . '/local-main.php');

return array_merge_recursive_distinct($a, $b);
