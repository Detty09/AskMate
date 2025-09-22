/*
 * AskMate, again
 *
 * Database schema
 * Version: 10.4.13-MariaDB
 */

CREATE DATABASE IF NOT EXISTS `ask_mate_again` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `ask_mate_again`;

SET FOREIGN_KEY_CHECKS = FALSE;

DROP TABLE IF EXISTS `registered_user`;
CREATE TABLE `registered_user`
(
    `id`                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `email`             TEXT NOT NULL,
    `password_hash`     TEXT NOT NULL,
    `registration_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image`
(
    `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `directory`   TEXT NOT NULL,
    `file_name`   TEXT NOT NULL,
    `upload_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question`
(
    `id`                 INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_image`           INT(11) UNSIGNED NULL,
    `id_registered_user` INT(11) UNSIGNED NOT NULL,
    `title`              VARCHAR(255) NOT NULL,
    `message`            TEXT NOT NULL,
    `vote_number`        INT(11) NOT NULL,
    `submission_time`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_image_on_question` FOREIGN KEY (`id_image`) REFERENCES `image`(`id`),
    CONSTRAINT `fk_registered_user_on_question` FOREIGN KEY (`id_registered_user`) REFERENCES `registered_user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer`
(
    `id`                 INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_question`        INT(11) UNSIGNED NOT NULL,
    `id_registered_user` INT(11) UNSIGNED NOT NULL,
    `message`            TEXT NOT NULL,
    `vote_number`        INT(11) NOT NULL,
    `submission_time`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_question_on_answer` FOREIGN KEY (`id_question`) REFERENCES `question`(`id`),
    CONSTRAINT `fk_registered_user_on_answer` FOREIGN KEY (`id_registered_user`) REFERENCES `registered_user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag`
(
    `id`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `rel_question_tag`;
CREATE TABLE `rel_question_tag`
(
    `id_question` INT(11) UNSIGNED NOT NULL,
    `id_tag`      INT(11) UNSIGNED NOT NULL,
    CONSTRAINT `fk_question_on_rel_question_tag` FOREIGN KEY (`id_question`) REFERENCES `question`(`id`),
    CONSTRAINT `fk_tag_on_rel_question_tag` FOREIGN KEY (`id_tag`) REFERENCES `tag`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

SET FOREIGN_KEY_CHECKS = TRUE;
