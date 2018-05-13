<?php

/**
 * This is the model base class for the table "subscriber".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Subscriber".
 *
 * Columns in table "subscriber" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $email
 * @property integer $weekly_schedule
 * @property string $hash
 * @property string $categories
 * @property string $channels
 * @property string $genres
 * @property string $subscribed
 *
 */
abstract class BaseSubscriber extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'subscriber';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Subscriber|Subscribers', $n);
	}

	public static function representingColumn() {
		return 'email';
	}

	public function rules() {
		return array(
			array('weekly_schedule', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>255),
			array('hash', 'length', 'max'=>32),
			array('categories, channels, genres', 'length', 'max'=>500),
			array('subscribed', 'safe'),
			array('email, weekly_schedule, hash, categories, channels, genres, subscribed', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, email, weekly_schedule, hash, categories, channels, genres, subscribed', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'email' => Yii::t('app', 'Email'),
			'weekly_schedule' => Yii::t('app', 'Weekly Schedule'),
			'hash' => Yii::t('app', 'Hash'),
			'categories' => Yii::t('app', 'Categories'),
			'channels' => Yii::t('app', 'Channels'),
			'genres' => Yii::t('app', 'Genres'),
			'subscribed' => Yii::t('app', 'Subscribed'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('weekly_schedule', $this->weekly_schedule);
		$criteria->compare('hash', $this->hash, true);
		$criteria->compare('categories', $this->categories, true);
		$criteria->compare('channels', $this->channels, true);
		$criteria->compare('genres', $this->genres, true);
		$criteria->compare('subscribed', $this->subscribed, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}