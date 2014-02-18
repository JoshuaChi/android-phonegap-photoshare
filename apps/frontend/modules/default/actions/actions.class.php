<?php

/**
 * default actions.
 *
 * @package    photoShare
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {  
    $this->theme = ThemePeer::getCurrentTheme();
    $this->randomPhotos = PhotoPeer::getRandomPhotos($this->theme->getId());
    $this->popularPhotos = PhotoPeer::getPopularPhotos($this->theme->getId());
    $this->newestPhotos = PhotoPeer::getNewestPhotos($this->theme->getId());
  }
}
