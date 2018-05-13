<?php

/**
 * This is the model base class for the table "category".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Category".
 *
 * Columns in table "category" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 *
 */
abstract class BaseCategory extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'category';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Category|Categories', $n);
	}

	public static function representingColumn() {
		return 'slug';
	}

	public function rules() {
		return array(
			array('slug, name', 'required'),
			array('slug, name', 'length', 'max'=>100),
			array('id, slug, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
            'shows' => array(self::HAS_MANY, 'Show', 'category_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'slug' => Yii::t('app', 'Slug'),
			'name' => Yii::t('app', 'Name'),
            'shows' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('slug', $this->slug, true);
		$criteria->compare('name', $this->name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}