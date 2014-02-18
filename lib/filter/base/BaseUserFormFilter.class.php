<?php

/**
 * User filter form base class.
 *
 * @package    photoShare
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(),
      'email'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_admin'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'login_count'        => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'photo_comment_list' => new sfWidgetFormPropelChoice(array('model' => 'Photo', 'add_empty' => true)),
      'user_photo_list'    => new sfWidgetFormPropelChoice(array('model' => 'Photo', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'password'           => new sfValidatorPass(array('required' => false)),
      'is_admin'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'login_count'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'photo_comment_list' => new sfValidatorPropelChoice(array('model' => 'Photo', 'required' => false)),
      'user_photo_list'    => new sfValidatorPropelChoice(array('model' => 'Photo', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

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

    $criteria->addJoin(PhotoCommentPeer::USER_ID, UserPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PhotoCommentPeer::PHOTO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PhotoCommentPeer::PHOTO_ID, $value));
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

    $criteria->addJoin(UserPhotoPeer::USER_ID, UserPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UserPhotoPeer::PHOTO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UserPhotoPeer::PHOTO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'email'              => 'Text',
      'password'           => 'Text',
      'is_admin'           => 'Boolean',
      'login_count'        => 'Number',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'photo_comment_list' => 'ManyKey',
      'user_photo_list'    => 'ManyKey',
    );
  }
}
