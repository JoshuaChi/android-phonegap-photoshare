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
      foreach(PhotoPeer::getMobileOverview($this->theme->getId()) as $p){
        array_push($result, array('id'=>$p->getId(), 'title'=>$p->getTitle(), 'createdAt'=>$p->getCreatedAt()));
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
  
  public function executeUpload(sfWebRequest $request)
  {
    $files = $request->getFiles();
    $posts = $request->getPostParameters();
    
    // sfContext::getInstance()->getLogger()->debug("--------\n");
    // sfContext::getInstance()->getLogger()->debug(print_r($files, true));
    // sfContext::getInstance()->getLogger()->debug(print_r($posts, true));
    // sfContext::getInstance()->getLogger()->debug("--------\n");
    

    $this->getResponse()->setContentType('application/json');
    if( ($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)) &&
     UserManager::isAuthenticated($posts)){
      foreach ($files as $f)
      {
        PhotoManager::upload($f, $posts);
      }    
    }
    

    return $this->renderText(json_encode(array()));
  }
  
  public function executeLike(sfWebRequest $request)
  {
    $data_json = json_encode(array('s'=>"0"));
    
    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
      $this->getResponse()->setContentType('application/json');
      
      $posts = $request->getPostParameters();
      if($posts['userId'] && $posts['photoTitle'])
      {
        $c = new Criteria();
        $c->add(PhotoPeer::TITLE, $posts['photoTitle']);
        $p = PhotoPeer::doSelectOne($c);
        if($p)
        {
          $c = new Criteria();
          $c->add(LikePeer::USER_ID, $posts['userId']);
          $c->add(LikePeer::PHOTO_ID, $p->getId());
          $l = LikePeer::doSelectOne($c);
          if(!$l)
          {
            $like = new Like();
            $like->setUserId($posts['userId']);
            $like->setPhotoId($p->getId());
            $like->save(); 
          }
        }
      }
      $data_json = json_encode(array('s'=>"1"));
    }
    
    return $this->renderText($data_json);
  }
  
  public function executeView(sfWebRequest $request)
  {
    $data_json = json_encode(array('s'=>'0', 'id'=>-1, 'count'=>"0"));
    
    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
      $this->getResponse()->setContentType('application/json');
      
      $posts = $request->getPostParameters();
      if($posts['userId'] && $posts['photoTitle'])
      {
        $c = new Criteria();
        $c->add(PhotoPeer::TITLE, $posts['photoTitle']);
        $p = PhotoPeer::doSelectOne($c);
        if($p)
        {
          $c = new Criteria();
          $c->add(LikePeer::USER_ID, $posts['userId']);
          $c->add(LikePeer::PHOTO_ID, $p->getId());
          $l = LikePeer::doSelectOne($c);

          $c = new Criteria();
          $c->add(LikePeer::PHOTO_ID, $p->getId());
          $count = LikePeer::doCount($c);
          if(!$count)
          {
            $count = 0;
          }     
          if($l)
          {
            $data_json = json_encode(array('s'=>'0', 'id'=>$p->getId(), 'count'=>$count));
          }
          else
          {
            $data_json = json_encode(array('s'=>'1', 'id'=>$p->getId(), 'count'=>$count));
          }
          
        }
      }
    }
    
    return $this->renderText($data_json);
  }
}