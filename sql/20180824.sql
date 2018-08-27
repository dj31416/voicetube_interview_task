CREATE TABLE `todolist`.`la_todo` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL , `title` VARCHAR(100) NOT NULL , `content` TEXT NOT NULL , `attachment` VARCHAR(150) NULL DEFAULT NULL , `created_at` INT(10) NOT NULL , `done_at` INT(10) NULL DEFAULT NULL , `deleted_at` INT(10) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


ALTER TABLE `la_todo` ADD `updated_at` INT(10) NOT NULL AFTER `created_at`;

ALTER TABLE `la_todo` CHANGE `created_at` `created_at` DATETIME(6) NOT NULL, CHANGE `updated_at` `updated_at` DATETIME(6) NOT NULL, CHANGE `done_at` `done_at` DATETIME(6) NULL DEFAULT NULL, CHANGE `deleted_at` `deleted_at` DATETIME(6) NULL DEFAULT NULL;
