SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `Camagru`;
use Camagru;

CREATE TABLE IF NOT EXISTS `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `hash` VARCHAR(255) NOT NULL,
    `commentemail` INT NULL DEFAULT '1',
    `htoken` VARCHAR(255) NULL,
    `confirm_token` VARCHAR(255) NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `pictures` (
    `id_pic` INT NOT NULL AUTO_INCREMENT ,
    `username` VARCHAR(255) NOT NULL ,
    `pics` TEXT NOT NULL ,
    `description` VARCHAR(255) NULL ,
    `like` INT NULL ,
    `date_time` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`id_pic`))
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `comments` (
    `id_comment` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `id_pic` INT NOT NULL,
    `comment` VARCHAR(255) NOT NULL,
    `date_time` VARCHAR(255) NULL,
    PRIMARY KEY (`id_comment`))
    ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `likes` (
    `id_like` INT NOT NULL AUTO_INCREMENT,
    `id_pic` INT NOT NULL,
    `username` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_like`))
    ENGINE = InnoDB;
