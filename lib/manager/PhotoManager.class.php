<?php
class PhotoManager{
  
  
  
  public static function upload($f, $userArray){
    sfContext::getInstance()->getLogger()->debug("------PhotoManager-------\n");  	
  	
  	
    $photoName = self::generateFilename($f['name'], self::getOriginalExtension($f['name']));
    
    sfContext::getInstance()->getLogger()->debug("--------\n");
  	sfContext::getInstance()->getLogger()->debug(print_r($photoName, true));
  	
  	
    $thumbnail = new sfThumbnail(100, 100, false, true, 75, 'sfImageMagickAdapter', array('method' => 'shave_all'));
    
    $thumbnail->loadFile($f['tmp_name']);
    $thumbnail->save(sfConfig::get('sf_upload_dir').'/thumbnail/'.$photoName, 'image/png');
  
    
    $uploadDir = sfConfig::get('sf_upload_dir') . '/photos';
    move_uploaded_file($f["tmp_name"], $uploadDir . "/" . $photoName );
    $photoId = PhotoPeer::addEntry($photoName, $userArray['photoDesc'], $userArray['photoLocation'], $userArray['themeId']);

    ThemePeer::incrPhotoNumber($userArray['themeId']);
    
    sfContext::getInstance()->getLogger()->debug("--------\n");
  	sfContext::getInstance()->getLogger()->debug(print_r($photoId, true));
    
    UserManager::addUserPhoto($userArray, $photoId);
  }  
  
  public static function generateFilename($name='', $extension='')
  {
    return sha1($name.rand(11111, 99999)).$extension;
  }
  
  public static function getOriginalExtension($name='', $default = 'jpg')
  {
    return (false === $pos = strrpos($name, '.')) ? $default : substr($name, $pos);
  }
}