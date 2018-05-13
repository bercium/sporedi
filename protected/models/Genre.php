<?php

Yii::import('application.models._base.BaseGenre');

class Genre extends BaseGenre
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}