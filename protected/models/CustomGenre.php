<?php

Yii::import('application.models._base.BaseCustomGenre');

class CustomGenre extends BaseCustomGenre
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}