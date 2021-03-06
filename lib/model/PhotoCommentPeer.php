<?php


/**
 * Skeleton subclass for performing query and update operations on the 'photo_comments' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu Aug 11 13:06:13 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PhotoCommentPeer extends BasePhotoCommentPeer {

	public static function retrieveAllByPhotoId($photoId=null){
		if(empty($photoId)){
			return null;
		}
		
		$c = new Criteria();
		$c->add(self::PHOTO_ID, $photoId);
		return self::doSelect($c);
	}
} // PhotoCommentPeer
