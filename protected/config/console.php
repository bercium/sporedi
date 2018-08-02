<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../components/global.php');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$a = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
    'timeZone' => 'Europe/Ljubljana',

	// preloading 'log' component
	'preload'=>array('log'),

	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.vendor.*',
        'ext.giix-components.*', // giix components
        'ext.mail.YiiMailMessage', // mail system
        'application.components.parsers.*',
	),    

	// application components
	'components'=>array(
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
        'db' => array(
                  'enableProfiling'=>YII_DEBUG,
                  'enableParamLogging'=>YII_DEBUG,
                  'initSQLs'=>array("set time_zone='+00:00';  wait_timeout=60;"),
            ),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
                    'logFile' => 'console.log',
                    'enabled'=>!YII_DEBUG,
				),
                array(
  					'levels'=>'trace, info',
                    'class'=>'CFileLogRoute',
                    'logFile' => 'console-info.log',
                    'enabled'=>true,
                    //'enabled'=>YII_DEBUG,
                    /*'categories'=>'system.db.*',*/
                ),
			),
		),
      
    'mail' => array(
        'class' => 'ext.mail.YiiMail',
        'transportType' => 'php', //smtp
        /*'transportOptions' => array_merge(array(
            'host' => 'smtp.gmail.com',
            'port' => '465',
            'encryption'=>'tls',
          ),require(dirname(__FILE__) . '/local-mail.php')
        ),*/
        'viewPath' => 'application.views.layouts.mail',
        'logging' => YII_DEBUG,
        'dryRun' => YII_DEBUG
    ),  
      
	),
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>array('spored@sporedi.net'=>'TV Spored'),
        'absoluteHost' => 'https://sporedi.net/',
        'coverPhotos'=>'uploads/covers/',
        'genresPhotos' => 'uploads/genres/',
        'categoriesPhotos' => 'uploads/categories/',
	),
    
);

$b = require(dirname(__FILE__) . '/local-console.php');

return array_merge_recursive_distinct($a,$b);