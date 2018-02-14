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
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `picture` (
    `id_pic` INT(10) NOT NULL AUTO_INCREMENT ,
    `username` VARCHAR(255) NOT NULL ,
    `pics` TEXT NOT NULL ,
    `description` VARCHAR(255) NULL ,
    `like` INT(5) NULL ,
    `date_time` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`id_pic`))
    ENGINE = InnoDB;
