<?php

/**
 * user actions.
 *
 * @package    photoShare
 * @subpackage user
 * @author     Your name here
 */
class userActions extends sfActions
{
  public function executeLogin(sfWebRequest $request){
		//from mobile
		if($request->getParameter('m')){			
			$this->getResponse()->setContentType('application/json');
	    $result = array();
	    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
	      if($request->getParameter('name') && $request->getParameter('password')){
	        $u = UserPeer::retrieveByName($request->getParameter('name'));
	        if(!empty($u) && $u->getPassword() == md5($request->getParameter('password'))){
	          $result = array('id'=>"{$u->getId()}", 'name'=>$u->getName(), 'email'=>$u->getEmail(), 'login_count'=>"{$u->getLoginCount()}", 'created_at'=>$u->getCreatedAt());
	        }
	      }      
	    }
	    return $this->renderText(json_encode($result));	
			
		}else{
			if($this->getUser()->isAuthenticated()){ 
				return $this->redirect('@homepage'); 
			}
			
			
			if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
	      if($request->getParameter('name') && $request->getParameter('password')){
	        $u = UserPeer::retrieveByName($request->getParameter('name'));
	        if(!empty($u) && $u->getPassword() == md5($request->getParameter('password'))){
						$this->getUser()->authenticate($u);
	          $this->redirect('@homepage');
	        }
	      }      
	    }
		}
  }
  
  public function executeRegister(sfWebRequest $request){
		//from mobile
		if($request->getParameter('m')){
			
			$this->getResponse()->setContentType('application/json');
	    $result = array('fail'=>1);
	    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
	      if($request->getParameter('registerName') && $request->getParameter('registerPassword')){
	        $u = UserPeer::retrieveByName($request->getParameter('registerName'));
	        if(empty($u)){
	          $user = $this->registerUser($request);
	          if($user->getId()){
	            $result = array('success'=>1, 'name'=>$user->getName());
	          }
	        }else{ #duplicated user name
	            $result = array('success'=>2);
	        }
	      }      
	    }
	    return $this->renderText(json_encode($result));
			
		}else{
			if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
	      if($request->getParameter('registerName') && $request->getParameter('registerPassword')){
	        $u = UserPeer::retrieveByName($request->getParameter('registerName'));
	        if(empty($u)){
	          $user = $this->registerUser($request);
	          if($user->getId()){
							$this->getUser()->authenticate($user);
	            $this->redirect('@homepage');
	          }
	        }else{ #duplicated user name
	           $this->getUser()->setFlash('notice', 'This email has been registered!');
	        }
	      }
			}
		
  	}
	}  

	protected function registerUser(sfWebRequest $request){
		$user = new User();
    $user->setName($request->getParameter('registerName'));
    $user->setPassword(md5($request->getParameter('registerPassword')));
    if($request->getParameter('registerEmail')){
      $user->setEmail($request->getParameter('registerEmail'));
    }
    $user->save();
		
		return $user;
	}
	
	public function executeLogout(sfWebRequest $request){
			if($this->getUser()->isAuthenticated()){ 
				$this->getUser()->setAuthenticated(false);	
			}
			return $this->redirect('@homepage'); 
	}
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->Users = UserPeer::doSelect(new Criteria());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UserForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($User = UserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object User does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserForm($User);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($User = UserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object User does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserForm($User);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($User = UserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object User does not exist (%s).', $request->getParameter('id')));
    $User->delete();

    $this->redirect('user/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $User = $form->save();

      $this->redirect('user/edit?id='.$User->getId());
    }
  }
}