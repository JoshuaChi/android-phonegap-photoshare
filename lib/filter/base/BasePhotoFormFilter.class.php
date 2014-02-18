<?php

/**
 * Photo filter form base class.
 *
 * @package    photoShare
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePhotoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'theme_id'           => new sfWidgetFormPropelChoice(array('model' => 'Theme', 'add_empty' => true)),
      'title'              => new sfWidgetFormFilterInput(),
      'path'               => new sfWidgetFormFilterInput(),
      'description'        => new sfWidgetFormFilterInput(),
      'is_active'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'views'              => new sfWidgetFormFilterInput(),
      'comments'           => new sfWidgetFormFilterInput(),
      'location'           => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'photo_comment_list' => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'user_photo_list'    => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'theme_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Theme', 'column' => 'id')),
      'title'              => new sfValidatorPass(array('required' => false)),
      'path'               => new sfValidatorPass(array('required' => false)),
      'description'        => new sfValidatorPass(array('required' => false)),
      'is_active'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'views'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'comments'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'location'           => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'photo_comment_list' => new sfValidatorPropelChoice(array('model' => 'User', 'required' => false)),
      'user_photo_list'    => new sfValidatorPropelChoice(array('model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('photo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPhotoCommentListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PhotoCommentPeer::PHOTO_ID, PhotoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PhotoCommentPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PhotoCommentPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addUserPhotoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UserPhotoPeer::PHOTO_ID, PhotoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UserPhotoPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UserPhotoPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Photo';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'theme_id'           => 'ForeignKey',
      'title'              => 'Text',
      'path'               => 'Text',
      'description'        => 'Text',
      'is_active'          => 'Boolean',
      'views'              => 'Number',
      'comments'           => 'Number',
      'location'           => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'photo_comment_list' => 'ManyKey',
      'user_photo_list'    => 'ManyKey',
    );
  }
}
