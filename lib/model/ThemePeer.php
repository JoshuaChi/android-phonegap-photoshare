<?php


/**
 * Skeleton subclass for performing query and update operations on the 'themes' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu Jul 14 15:16:20 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ThemePeer extends BaseThemePeer {

  public static function getCurrentTheme(){
    $c = new Criteria();
    $c->add(self::IS_ACTIVE, true);
    $t = self::doSelectOne($c);
    if(empty($t)){
      $theme = new Theme();
      $theme->setTitle('No theme currently');
      $theme->setDescription('');
      $t = $theme;
    }
    
    return $t;
  }

	public static function incrPhotoNumber($id=null){
		if(empty($id)){
			return null;
		}
		
		$t = self::retrieveByPk($id);
		$t->setCurrentPhotoNumbers($t->getCurrentPhotoNumbers()+1);
		$t->save();
	}
} // ThemePeer
