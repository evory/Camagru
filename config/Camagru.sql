SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE Camagru;
use Camagru;

CREATE TABLE IF NOT EXISTS `user` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `hash` VARCHAR(60) NOT NULL,
    `htoken` VARCHAR(60) NULL,
    `confirm_token` VARCHAR(60) NULL,
    PRIMARY KEY (`id`));
    ENGINE = InnoDB;
    COMMIT;

-- CREATE TABLE IF NOT EXISTS `pictures` (
--     `username` VARCHAR NOT NULL,
--     `pics` TEXT NOT NULL,
--     `text` TEXT NULL,
--     `likes` INT NOT NULL,
--     `time` DATETIME NOT NULL);
--     ENGINE=InnoDB DEFAULT CHARSET=utf8;
