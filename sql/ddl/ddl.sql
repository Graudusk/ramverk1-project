
--
-- Create a database for test
--
-- DROP DATABASE IF EXISTS travel;
-- CREATE DATABASE IF NOT EXISTS travel;
-- USE travel;
-- USE erjh17;

-- -- Ensure UTF8 as chacrter encoding within connection.
-- SET NAMES utf8;

-- --
-- -- Create a database user for the test database
-- --
-- GRANT ALL ON erjh17.* TO user@localhost IDENTIFIED BY 'user';

-- -- Ensure UTF8 on the database connection
-- SET NAMES utf8;

--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `email` VARCHAR(80) UNIQUE NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created` DATETIME,
    `updated` DATETIME,
    `deleted` DATETIME,
    `active` DATETIME 
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Question
--

DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` TEXT NOT NULL,
    `question` TEXT NOT NULL,
    `user` INTEGER NOT NULL,
    `slug` TEXT NOT NULL,
    `created` DATETIME,
    `updated` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `answer` TEXT NOT NULL,
    `user` INTEGER NOT NULL,
    `question` INTEGER NOT NULL,
    `created` DATETIME,
    `updated` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Tag
--
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `tag` VARCHAR(256) NOT NULL,
    `slug` VARCHAR(256) NOT NULL,
    `question` INTEGER NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `text` TEXT NOT NULL,
    `user` INTEGER NOT NULL,
    `type` VARCHAR(20),
    `post` INTEGER NOT NULL,
    `created` DATETIME,
    `updated` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
