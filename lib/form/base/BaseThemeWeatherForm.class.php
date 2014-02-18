<?php

/**
 * ThemeWeather form base class.
 *
 * @method ThemeWeather getObject() Returns the current form's model object
 *
 * @package    photoShare
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseThemeWeatherForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'theme_id'   => new sfWidgetFormInputHidden(),
      'weather_id' => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'theme_id'   => new sfValidatorPropelChoice(array('model' => 'Theme', 'column' => 'id', 'required' => false)),
      'weather_id' => new sfValidatorPropelChoice(array('model' => 'Weather', 'column' => 'id', 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('theme_weather[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ThemeWeather';
  }


}
