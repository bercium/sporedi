<?php

/**
 * This is the model base class for the table "custom_genre".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CustomGenre".
 *
 * Columns in table "custom_genre" available as properties of the model,
 * followed by relations of table "custom_genre" available as properties of the model.
 *
 * @property integer $id
 * @property integer $genre_id
 * @property string $name
 *
 * @property Genre $genre
 */
abstract class BaseCustomGenre extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'custom_genre';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'CustomGenre|CustomGenres', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('genre_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('genre_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, genre_id, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'genre' => array(self::BELONGS_TO, 'Genre', 'genre_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'genre_id' => null,
			'name' => Yii::t('app', 'Name'),
			'genre' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('genre_id', $this->genre_id);
		$criteria->compare('name', $this->name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}