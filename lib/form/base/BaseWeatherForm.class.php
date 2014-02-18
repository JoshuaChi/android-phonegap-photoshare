<?php

/**
 * Weather form base class.
 *
 * @method Weather getObject() Returns the current form's model object
 *
 * @package    photoShare
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseWeatherForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'title'              => new sfWidgetFormInputText(),
      'body_class'         => new sfWidgetFormInputText(),
      'description'        => new sfWidgetFormTextarea(),
      'max_photo_number'   => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'theme_weather_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Theme')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'title'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'body_class'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'        => new sfValidatorString(array('required' => false)),
      'max_photo_number'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'theme_weather_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('weather[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Weather';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['theme_weather_list']))
    {
      $values = array();
      foreach ($this->object->getThemeWeathers() as $obj)
      {
        $values[] = $obj->getThemeId();
      }

      $this->setDefault('theme_weather_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveThemeWeatherList($con);
  }

  public function saveThemeWeatherList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['theme_weather_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ThemeWeatherPeer::WEATHER_ID, $this->object->getPrimaryKey());
    ThemeWeatherPeer::doDelete($c, $con);

    $values = $this->getValue('theme_weather_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ThemeWeather();
        $obj->setWeatherId($this->object->getPrimaryKey());
        $obj->setThemeId($value);
        $obj->save();
      }
    }
  }

}
