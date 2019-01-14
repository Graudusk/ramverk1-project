SET NAMES utf8;

CREATE DATABASE IF NOT EXISTS `travel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `travel`;

CREATE USER 'user'@'localhost' IDENTIFIED BY 'user';

GRANT ALL PRIVILEGES ON *.* TO 'user'@'localhost';

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
USE `travel`;


INSERT INTO `User`
    (`email`, `name`, `password`)
    VALUES
        ("test@test.com", "Admin", "$2y$10$WZ9Htf2X5yGqXGVP5rwtRO7/rJNjpT3J9g./G/fttVtPIuHFQgjnW"),
        ("123@test.com", "Eric", "$2y$10$WZ9Htf2X5yGqXGVP5rwtRO7/rJNjpT3J9g./G/fttVtPIuHFQgjnW");

INSERT INTO `Question` (`title`, `question`, `user`, `slug`, `created`)
    VALUES
        ("What to do in Japan?", "I'm travelling to Tokyo, Japan in April and don't know what to do!
 
 Please help me!
 
 /Eric", "2", "what-to-do-in-japan", NOW()),
        ("Best country", "What is the best country to travel to in the world?", "2", "best-country", NOW()),
        ("test", "Test", "1", "test-1", NOW()),
        ("test", "Test", "1", "test-2", NOW()),
        ("test", "Test", "1", "test-3", NOW());

INSERT INTO `Answer`
    (`answer`, `user`, `question`, `created`)
    VALUES
        ("Go to Tokyo!", "1", "1", NOW()),
        ("Europe is fun!", "1", "2", NOW());

INSERT INTO `Tag`
    (`tag`, `slug`, `question`)
    VALUES
        ("Japan", "japan", "1"),
        ("Tokyo", "tokyo", "1"),
        ("World", "world", "2"),
        ("Travel", "travel", "2");

INSERT INTO `Comment`
    (`text`, `user`, `type`, `post`, `created`)
    VALUES
        ("Europe is not a country", "2", "answer", "2", NOW()),
        ("Yes it is!", "1", "answer", "2", NOW()),
        ("Lol", "2", "question", "1", NOW());
