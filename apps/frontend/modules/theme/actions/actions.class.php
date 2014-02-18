<?php

/**
 * theme actions.
 *
 * @package    photoShare
 * @subpackage theme
 * @author     Your name here
 */
class themeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setContentType('application/json');
    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
			$t = ThemePeer::getCurrentTheme();
      $result = array('id'=>"{$t->getId()}", 't'=>$t->getTitle(), 'd'=>$t->getDescription(), 'c'=>$t->getCreatedAt(), 'n'=>"{$t->getCurrentPhotoNumbers()}");
      $data_json=json_encode($result);
    }else{
      $data_json=json_encode(array());
    }
    
    return $this->renderText($data_json);
  }

}
