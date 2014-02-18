<?php

/**
 * Weather filter form base class.
 *
 * @package    photoShare
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseWeatherFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'              => new sfWidgetFormFilterInput(),
      'body_class'         => new sfWidgetFormFilterInput(),
      'description'        => new sfWidgetFormFilterInput(),
      'max_photo_number'   => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'theme_weather_list' => new sfWidgetFormPropelChoice(array('model' => 'Theme', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'              => new sfValidatorPass(array('required' => false)),
      'body_class'         => new sfValidatorPass(array('required' => false)),
      'description'        => new sfValidatorPass(array('required' => false)),
      'max_photo_number'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'theme_weather_list' => new sfValidatorPropelChoice(array('model' => 'Theme', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('weather_filters[%s]');

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

    $criteria->addJoin(ThemeWeatherPeer::WEATHER_ID, WeatherPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ThemeWeatherPeer::THEME_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ThemeWeatherPeer::THEME_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Weather';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'title'              => 'Text',
      'body_class'         => 'Text',
      'description'        => 'Text',
      'max_photo_number'   => 'Number',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'theme_weather_list' => 'ManyKey',
    );
  }
}
