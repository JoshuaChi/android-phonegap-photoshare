<?php

class myUser extends sfBasicSecurityUser
{
	public function authenticate(User $user, $remember = false) {
		$this->setAttribute ('user', $user);
		$this->setAuthenticated (true);	
	}
	
	public function getUserObject(){
		if ($this->hasAttribute ('user'))
			return $this->getAttribute ('user');
			
		return new User();
	}
	
	public function getCurrentTheme(){
		return ThemePeer::getCurrentTheme();
	}
}
