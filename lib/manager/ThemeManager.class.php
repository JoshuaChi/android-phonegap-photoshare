<?php
class ThemeManager
{
  /**
   * Get body class and storm type by theme id
   *
   * @return array('current_weather', 'next_weather')
   * @author Joshua Chi
   **/
  public static function getCurrentThemePeopertes($themeId=null, $currentPhotoNumbers=0){
    $weathers = ThemeWeatherPeer::retrieveAllByThemeId($themeId);
    $result = array(new Weather(), null);
    if(empty($weathers)){
      return $result;
    }
    $previewW = null;
    while($w = array_shift($weathers)){
      //if nothing matched or there is no weather can be popuped, we will returm the result
      if(count($weathers) == 0){
        $result = array($w, null);
      }else{
        // echo "- m: ".$w->getMaxPhotoNumber().' - c: '.$currentPhotoNumbers."<br />";
        if($w->getMaxPhotoNumber() > $currentPhotoNumbers){
          if(empty($previewW)){
            if($w2 = array_shift($weathers)){
              $result = array($w, $w2);
            }else{
              $result = array($w, null);
            }
          }else{
            $result = array($previewW, $w);
          }
          
          break;
        }        
        $previewW = $w;
      }      
    }
    
    return $result;
    
  }
  
}
?>