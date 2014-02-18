
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- likes
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `likes`;


CREATE TABLE `likes`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`photo_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`,`user_id`,`photo_id`),
	INDEX `likes_FI_1` (`user_id`),
	CONSTRAINT `likes_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`id`)
		ON DELETE CASCADE,
	INDEX `likes_FI_2` (`photo_id`),
	CONSTRAINT `likes_FK_2`
		FOREIGN KEY (`photo_id`)
		REFERENCES `photos` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- photos
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `photos`;


CREATE TABLE `photos`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`theme_id` INTEGER  NOT NULL,
	`title` VARCHAR(255),
	`path` VARCHAR(255),
	`description` TEXT,
	`is_active` TINYINT default 0 NOT NULL,
	`views` INTEGER default 0,
	`comments` INTEGER default 0,
	`location` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `photos_FI_1` (`theme_id`),
	CONSTRAINT `photos_FK_1`
		FOREIGN KEY (`theme_id`)
		REFERENCES `themes` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- photo_comments
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `photo_comments`;


CREATE TABLE `photo_comments`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`photo_id` INTEGER  NOT NULL,
	`description` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`,`user_id`,`photo_id`),
	INDEX `photo_comments_FI_1` (`user_id`),
	CONSTRAINT `photo_comments_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`id`)
		ON DELETE CASCADE,
	INDEX `photo_comments_FI_2` (`photo_id`),
	CONSTRAINT `photo_comments_FK_2`
		FOREIGN KEY (`photo_id`)
		REFERENCES `photos` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- themes
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `themes`;


CREATE TABLE `themes`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	`class_name` VARCHAR(255),
	`description` TEXT,
	`is_active` TINYINT default 0 NOT NULL,
	`current_photo_numbers` INTEGER default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- theme_weathers
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `theme_weathers`;


CREATE TABLE `theme_weathers`
(
	`theme_id` INTEGER  NOT NULL,
	`weather_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`theme_id`,`weather_id`),
	CONSTRAINT `theme_weathers_FK_1`
		FOREIGN KEY (`theme_id`)
		REFERENCES `themes` (`id`)
		ON DELETE CASCADE,
	INDEX `theme_weathers_FI_2` (`weather_id`),
	CONSTRAINT `theme_weathers_FK_2`
		FOREIGN KEY (`weather_id`)
		REFERENCES `weathers` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- users
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;


CREATE TABLE `users`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(20),
	`email` VARCHAR(75)  NOT NULL,
	`password` CHAR(40)  NOT NULL,
	`is_admin` TINYINT default 0 NOT NULL,
	`login_count` INTEGER default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `users_U_1` (`name`),
	KEY `users_I_1`(`email`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- user_photos
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user_photos`;


CREATE TABLE `user_photos`
(
	`user_id` INTEGER  NOT NULL,
	`photo_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`user_id`,`photo_id`),
	UNIQUE KEY `unique_user_photo` (`user_id`, `photo_id`),
	CONSTRAINT `user_photos_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`id`)
		ON DELETE CASCADE,
	INDEX `user_photos_FI_2` (`photo_id`),
	CONSTRAINT `user_photos_FK_2`
		FOREIGN KEY (`photo_id`)
		REFERENCES `photos` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- weathers
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `weathers`;


CREATE TABLE `weathers`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	`body_class` VARCHAR(255),
	`description` TEXT,
	`max_photo_number` INTEGER default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
