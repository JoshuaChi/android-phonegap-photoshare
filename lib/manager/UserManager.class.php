<?php
class UserManager{
  const HASH_PREFIX = "p1cst0rms.c0mI0vu98becs$%";
  
  public static function addUserPhoto($userArray=array(), $photoId='')
  {
    if(!empty($userArray) && !empty($photoId)){
      if(!empty($userArray['userName'])){
        if(!empty($userArray['userNew'])){
          $u = new User();
          $u->setName($userArray['userName']);
          $u->setPassword(md5($userArray['userPwd']));
          $u->save();
        }else{
          $c = new Criteria();
          $c->add(UserPeer::NAME, $userArray['userName']);
          $u = UserPeer::doSelectOne($c);
        }
        
        if(!empty($u)){
          $up = new UserPhoto();
          $up->setUserId($u->getId());
          $up->setPhotoId($photoId);
          $up->save();
          return true;
        }
      }
    }
    return false;
  }
  
  public static function isAuthenticated($userArray=array())
  {
    if(!empty($userArray) && !empty($userArray['userName']) && !empty($userArray['md5'])){      
      if ( md5(self::HASH_PREFIX.$userArray['userName']) == $userArray['md5'])
      {
        return true;
      }
    }
    return false;
  }

}