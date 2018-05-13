<?php

class ShowController extends GxController {
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
				'users'=>array("@"),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Show'),
		));
	}

	public function actionCreate() {
		$model = new Show;


		if (isset($_POST['Show'])) {
			$model->setAttributes($_POST['Show']);
			$relatedData = array(
				'directors' => $_POST['Show']['directors'] === '' ? null : $_POST['Show']['directors'],
				'actors' => $_POST['Show']['actors'] === '' ? null : $_POST['Show']['actors'],
				);

			if ($model->saveWithRelated($relatedData)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Show');


		if (isset($_POST['Show'])) {
			$model->setAttributes($_POST['Show']);
			/*$relatedData = array(
				'directors' => $_POST['Show']['directors'] === '' ? null : $_POST['Show']['directors'],
				'actors' => $_POST['Show']['actors'] === '' ? null : $_POST['Show']['actors'],
				);*/
			if ($model->save()/*WithRelated($relatedData)*/) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Show')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Show');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Show('search');
		$model->unsetAttributes();

		if (isset($_GET['Show']))
			$model->setAttributes($_GET['Show']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}