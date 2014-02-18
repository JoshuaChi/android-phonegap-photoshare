<?php

class ThemeFilter extends sfFilter
{
  /**
   * Executes this filter.
   *
   * @param sfFilterChain $filterChain A sfFilterChain instance
   */
  public function execute($filterChain)
  {
    // disable security on login and secure actions
    $context    = $this->getContext();
    $user       = $context->getUser();
    $request    = $context->getRequest();
    $currentTheme = $user->getCurrentTheme();
    
    if(!empty($currentTheme)){
      $return = ThemeManager::getCurrentThemePeopertes($currentTheme->getId(), $currentTheme->getCurrentPhotoNumbers());
      $user->setAttribute('current_weather', $return[0]);
      $user->setAttribute('next_weather', $return[1]);      
    }

    // the user has access, continue
    $filterChain->execute();
  }

}
