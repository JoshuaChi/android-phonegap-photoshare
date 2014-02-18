<?php
class UserManager{
  public static function addUserPhoto($userArray=array(), $photoId=''){
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
  

}