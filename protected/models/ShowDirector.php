<?php

Yii::import('application.models._base.BaseShowDirector');

class ShowDirector extends BaseShowDirector
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}