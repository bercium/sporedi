<?php

Yii::import('application.models._base.BaseSchedule');

class Schedule extends BaseSchedule
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}