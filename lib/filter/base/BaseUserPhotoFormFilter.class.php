<?php

/**
 * UserPhoto filter form base class.
 *
 * @package    photoShare
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserPhotoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('user_photo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserPhoto';
  }

  public function getFields()
  {
    return array(
      'user_id'    => 'ForeignKey',
      'photo_id'   => 'ForeignKey',
      'created_at' => 'Date',
    );
  }
}
