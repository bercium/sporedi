<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);

class CronController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
                array('allow', // allow all users to perform actions
                        'actions' => array(),
                        'users' => array('*'),
                ),
                array('deny', // deny all users
                        'users' => array('*'),
                ),
        );
    }

    /**
     * 
     */
    function consoleCommand($controller, $action) {
        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
        $runner->addCommands($commandPath);

        $args = array('yiic', $controller, $action); // 'migrate', '--interactive=0'
        //$args = array_merge(array("yiic"), $args);
        ob_start();
        $runner->run($args);
        return htmlentities(ob_get_clean(), null, Yii::app()->charset);
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionTest() {
        echo "test";
        //echo absoluteURL()."\n<br />";
        //echo $this->consoleCommand('','');
    }


    public function actionUpdateschedule() {
        if (isset($_GET['force'])) echo $this->consoleCommand('update', 'forceschedule');
        else echo $this->consoleCommand('update', 'schedule');
    }
    
    
    public function actionTweet() {
        echo $this->consoleCommand('tweet', 'checkActiveSchedule');
    }

    public function actionWeeklyDigest() {
        if (isset($_GET['test'])) echo $this->consoleCommand('mailer', 'testWeeklyDigest');
        else echo $this->consoleCommand('mailer', 'weeklyDigest');
    }

}
