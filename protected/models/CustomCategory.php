<?php

Yii::import('application.models._base.BaseCustomCategory');

class CustomCategory extends BaseCustomCategory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}