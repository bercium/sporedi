<?php

Yii::import('application.models._base.BaseSubscriber');

class Subscriber extends BaseSubscriber
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}