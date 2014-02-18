<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    photoShare
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'password'           => new sfWidgetFormInputText(),
      'is_admin'           => new sfWidgetFormInputCheckbox(),
      'login_count'        => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'photo_comment_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Photo')),
      'user_photo_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Photo')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 75)),
      'password'           => new sfValidatorString(array('max_length' => 40)),
      'is_admin'           => new sfValidatorBoolean(),
      'login_count'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'photo_comment_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Photo', 'required' => false)),
      'user_photo_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Photo', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'User', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['photo_comment_list']))
    {
      $values = array();
      foreach ($this->object->getPhotoComments() as $obj)
      {
        $values[] = $obj->getPhotoId();
      }

      $this->setDefault('photo_comment_list', $values);
    }

    if (isset($this->widgetSchema['user_photo_list']))
    {
      $values = array();
      foreach ($this->object->getUserPhotos() as $obj)
      {
        $values[] = $obj->getPhotoId();
      }

      $this->setDefault('user_photo_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePhotoCommentList($con);
    $this->saveUserPhotoList($con);
  }

  public function savePhotoCommentList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['photo_comment_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PhotoCommentPeer::USER_ID, $this->object->getPrimaryKey());
    PhotoCommentPeer::doDelete($c, $con);

    $values = $this->getValue('photo_comment_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PhotoComment();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setPhotoId($value);
        $obj->save();
      }
    }
  }

  public function saveUserPhotoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_photo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UserPhotoPeer::USER_ID, $this->object->getPrimaryKey());
    UserPhotoPeer::doDelete($c, $con);

    $values = $this->getValue('user_photo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserPhoto();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setPhotoId($value);
        $obj->save();
      }
    }
  }

}
