<?php

class backendSecurityFilter extends sfFilter
{
  public function execute($filterChain) {
    $context    = $this->getContext();
    $user       = $context->getUser();
    if($user->isAuthenticated() && $user->getUserObject()->getIsAdmin()){
      $user->addCredential('admin');
    }
    $filterChain->execute();   
  }
  
}
