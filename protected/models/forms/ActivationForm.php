<?php

class ActivationForm extends CFormModel
{
	/**
	 * The password provided by the user
	 * @var string $password
	 */
	public $password;

	/**
	 * The activation key originally sent to the user's email
	 * @var string $activationKey
	 */
	public $activationKey;

	/**
	 * The user model
	 * @var Users $_user
	 */
	private $_user;

	/**
	 * The activation key metadata model. This is loaded to ensure it gets cleaned up properly
	 * @var UserMetadata $_meta
	 */
	private $_meta;

	/**
	 * Validation rules
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('password, activationKey', 'required'),
			array('password', 'length', 'min'=>8),
			array('activationKey', 'validateKey'),
			array('password', 'validateUserPassword'),
		);
	}

	/**
	 * Attribute labels
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'password'      => Yii::t('ciims.models.ActivationForm', 'Your Password'),
			'activationKey' => Yii::t('ciims.models.ActivationForm', 'Your Activation Key')
		);
	}

	/**
	 * Validates that the activation key belongs to a user and is valid
	 * @param array $attributes
	 * @param array $params
	 * return array
	 */
	public function validateKey($attributes=array(), $params=array())
	{
		$this->_meta = UserMetadata::model()->findByAttributes(array('key'=>'activationKey', 'value'=>$this->activationKey));

		if ($this->_meta == NULL)
		{
			$this->addError('activationKey', Yii::t('ciims.models.ActivationForm', 'The activation key you provided is invalid.'));
			return false;
		}

		return true;
	}

	/**
	 * Ensures that the password entered matches the one provided during registration
	 * @param array $attributes
	 * @param array $params
	 * return array
	 */
	public function validateUserPassword($attributes, $params)
	{
		if ($this->_user == NULL)
		{
			$this->addError('activationKey', Yii::t('ciims.models.ActivationForm', 'The activation key you provided is invalid.'));
			return false;
		}

		$result = password_verify($this->password, $this->_user->password);

		if ($result == false)
		{
			$this->addError('password', Yii::t('ciims.models.ActivationForm', 'The password you entered does not match the password you registered with.'));
			return false;
		}

		return true;
	}

	/**
	 * Makes the user an active user in the database, and deletes their activation token
	 * @return boolean
	 */
	public function save()
	{
		$userId = $this->_meta->user_id;
		$this->_user = Users::model()->findByPk($userId);

		if (!$this->validate())
			return false;

		$this->_user->status = Users::ACTIVE;
		
		if ($this->_user->save())
			return $this->_meta->delete();

		return false;
	}
}
