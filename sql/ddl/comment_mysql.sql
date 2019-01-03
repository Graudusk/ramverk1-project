--
-- Creating a small table.
-- Create a database and a user having access to this database,
-- this must be done by hand, se commented rows on how to do it.
--



--
-- Create a database for test
--
-- DROP DATABASE anaxdb;
-- CREATE DATABASE IF NOT EXISTS anaxdb;
USE anaxdb;



--
-- Create a database user for the test database
--
-- GRANT ALL ON anaxdb.* TO anax@localhost IDENTIFIED BY 'anax';



-- Ensure UTF8 on the database connection
SET NAMES utf8;



--
-- Table Comment
--
-- "id" INTEGER PRIMARY KEY NOT NULL,
-- "text" TEXT NOT NULL,
-- "user" INT,
-- "type" TEXT,
-- "post" INT,
-- "created" TIMESTAMP,
-- "updated" DATETIME
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
