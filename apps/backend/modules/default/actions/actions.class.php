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
  public function executeIndex(sfWebRequest $request){

  }
  
  public function executeSecure(sfWebRequest $request){

  }
  
  public function executeLogin(sfWebRequest $request){
    if($this->getUser()->isAuthenticated()){ 
			return $this->redirect('@homepage'); 
		}
		
		
		if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)){
      if($request->getParameter('name') && $request->getParameter('password')){
        $u = UserPeer::retrieveByName($request->getParameter('name'));

        if(!empty($u) && $u->getPassword() == md5($request->getParameter('password')) && $u->getIsAdmin()){
					$this->getUser()->authenticate($u);
          $this->redirect('@homepage');
        }
      }      
    }
  }
  
  public function executeLogout(sfWebRequest $request){
		if($this->getUser()->isAuthenticated()){ 
			$this->getUser()->setAuthenticated(false);	
		}
		return $this->redirect('@homepage'); 
	}
}
