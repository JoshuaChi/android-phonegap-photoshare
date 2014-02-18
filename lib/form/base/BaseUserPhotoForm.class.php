<?php

/**
 * UserPhoto form base class.
 *
 * @method UserPhoto getObject() Returns the current form's model object
 *
 * @package    photoShare
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUserPhotoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormInputHidden(),
      'photo_id'   => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'photo_id'   => new sfValidatorPropelChoice(array('model' => 'Photo', 'column' => 'id', 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'UserPhoto', 'column' => array('user_id', 'photo_id')))
    );

    $this->widgetSchema->setNameFormat('user_photo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserPhoto';
  }


}
