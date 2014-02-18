<?php

/**
 * Photo form base class.
 *
 * @method Photo getObject() Returns the current form's model object
 *
 * @package    photoShare
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePhotoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'theme_id'           => new sfWidgetFormPropelChoice(array('model' => 'Theme', 'add_empty' => false)),
      'title'              => new sfWidgetFormInputText(),
      'path'               => new sfWidgetFormInputText(),
      'description'        => new sfWidgetFormTextarea(),
      'is_active'          => new sfWidgetFormInputCheckbox(),
      'views'              => new sfWidgetFormInputText(),
      'comments'           => new sfWidgetFormInputText(),
      'location'           => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'photo_comment_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'User')),
      'user_photo_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'User')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'theme_id'           => new sfValidatorPropelChoice(array('model' => 'Theme', 'column' => 'id')),
      'title'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'path'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'        => new sfValidatorString(array('required' => false)),
      'is_active'          => new sfValidatorBoolean(),
      'views'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'comments'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'location'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'photo_comment_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'User', 'required' => false)),
      'user_photo_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('photo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Photo';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['photo_comment_list']))
    {
      $values = array();
      foreach ($this->object->getPhotoComments() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('photo_comment_list', $values);
    }

    if (isset($this->widgetSchema['user_photo_list']))
    {
      $values = array();
      foreach ($this->object->getUserPhotos() as $obj)
      {
        $values[] = $obj->getUserId();
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
    $c->add(PhotoCommentPeer::PHOTO_ID, $this->object->getPrimaryKey());
    PhotoCommentPeer::doDelete($c, $con);

    $values = $this->getValue('photo_comment_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PhotoComment();
        $obj->setPhotoId($this->object->getPrimaryKey());
        $obj->setUserId($value);
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
    $c->add(UserPhotoPeer::PHOTO_ID, $this->object->getPrimaryKey());
    UserPhotoPeer::doDelete($c, $con);

    $values = $this->getValue('user_photo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserPhoto();
        $obj->setPhotoId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
