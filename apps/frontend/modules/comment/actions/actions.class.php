<?php

/**
 * comment actions.
 *
 * @package    photoShare
 * @subpackage comment
 * @author     Your name here
 */
class commentActions extends sfActions
{
  public function executeAdd(sfWebRequest $request)
  {
    if(!$request->isMethod(sfRequest::POST) || !$request->getParameter('photo_id') || !$request->getParameter('user_id') || !$request->getParameter('description')){
      $this->getUser()->setFlash('notice', 'You are not allowed to do this!');
			return $this->redirect('@homepage');
		}

		
		$p = PhotoPeer::retrieveByPk($request->getParameter('photo_id'));
		if(empty($p)){
			$this->getUser()->setFlash('notice', 'This photo does\'t exist!');
			return $this->redirect('@homepage');
		}
		
		$p->setComments($p->getComments()+1);
		$p->save();
		
    $pc = new PhotoComment();
		$pc->setUserId($request->getParameter('user_id'));
		$pc->setPhotoId($request->getParameter('photo_id'));
		$pc->setDescription($request->getParameter('description'));
		$pc->save();
		
		$this->redirect('photo/index?id='.$p->getId());
  }
}
