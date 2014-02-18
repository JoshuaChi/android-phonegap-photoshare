<?php

/**
 * Theme filter form base class.
 *
 * @package    photoShare
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseThemeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                 => new sfWidgetFormFilterInput(),
      'class_name'            => new sfWidgetFormFilterInput(),
      'description'           => new sfWidgetFormFilterInput(),
      'is_active'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'current_photo_numbers' => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'theme_weather_list'    => new sfWidgetFormPropelChoice(array('model' => 'Weather', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'                 => new sfValidatorPass(array('required' => false)),
      'class_name'            => new sfValidatorPass(array('required' => false)),
      'description'           => new sfValidatorPass(array('required' => false)),
      'is_active'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'current_photo_numbers' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'theme_weather_list'    => new sfValidatorPropelChoice(array('model' => 'Weather', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('theme_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addThemeWeatherListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ThemeWeatherPeer::THEME_ID, ThemePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ThemeWeatherPeer::WEATHER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ThemeWeatherPeer::WEATHER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Theme';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'title'                 => 'Text',
      'class_name'            => 'Text',
      'description'           => 'Text',
      'is_active'             => 'Boolean',
      'current_photo_numbers' => 'Number',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'theme_weather_list'    => 'ManyKey',
    );
  }
}
