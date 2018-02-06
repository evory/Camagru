SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

  -- A rajouter dans export SQL

CREATE DATABASE Camagru;
USE Camagru;

    -- Fin

CREATE TABLE `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(50) NOT NULL,
    `username` varchar(20) NOT NULL,
    `hash` varchar(60) NOT NULL,
    `htoken` varchar(60) NULL,
    `confirm_token` varchar(60) NULL )
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8;
    ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);


CREATE TABLE `Camagru`.`picture` (
    `username` VARCHAR(255) NOT NULL ,
    `pics` TEXT NOT NULL ,
    `likes` INT NOT NULL ,
    `time` DATETIME NOT NULL )
    ENGINE = InnoDB;
    DEFAULT CHARSET=utf8
COMMIT;
