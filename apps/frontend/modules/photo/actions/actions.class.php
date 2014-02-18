<?php

/**
 * photo actions.
 *
 * @package    photoShare
 * @subpackage photo
 * @author     Your name here
 */
class photoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->theme = ThemePeer::getCurrentTheme();
    $this->forward404Unless($this->photo = PhotoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Photo does not exist (%s).', $request->getParameter('id')));
		$this->user = UserPhotoPeer::getUserByPhotoId($this->photo->getId());
		$this->photo->setViews(($this->photo->getViews() + 1));
		$this->photo->save();
		$this->comments = PhotoCommentPeer::retrieveAllByPhotoId($this->photo->getId());
  }
  
  public function executeBrowse(sfWebRequest $request)
  {
    $this->theme = ThemePeer::getCurrentTheme();
    $this->getResponse()->setContentType('application/json');
    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
      $result = array();
      foreach(PhotoPeer::getRandomPhotos($this->theme->getId()) as $p){
        array_push($result, array('title'=>$p->getTitle(), 'createdAt'=>$p->getCreatedAt()));
      }
      $data_json=json_encode($result);
    }else{
      $data_json=json_encode(array());
    }
    
    return $this->renderText($data_json);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PhotoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PhotoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Photo = PhotoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Photo does not exist (%s).', $request->getParameter('id')));
    $this->form = new PhotoForm($Photo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Photo = PhotoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Photo does not exist (%s).', $request->getParameter('id')));
    $this->form = new PhotoForm($Photo);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Photo = PhotoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Photo does not exist (%s).', $request->getParameter('id')));
    $Photo->delete();

    $this->redirect('photo/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Photo = $form->save();

      $this->redirect('photo/edit?id='.$Photo->getId());
    }
  }
  
  public function executeUpload(sfWebRequest $request){
    $files = $request->getFiles();
    $posts = $request->getPostParameters();
    sfContext::getInstance()->getLogger()->debug("--------\n");
  	sfContext::getInstance()->getLogger()->debug(print_r($files, true));
  	sfContext::getInstance()->getLogger()->debug(print_r($posts, true));
    sfContext::getInstance()->getLogger()->debug("--------\n");
    
    
    
    
    foreach ($files as $f)
    {
      PhotoManager::upload($f, $posts);
    }
    
    

    return sfView::NONE;
  }
}