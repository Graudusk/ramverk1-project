SET NAMES utf8;

CREATE DATABASE IF NOT EXISTS `travel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `travel`;

CREATE USER 'user'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL ON *.* TO 'user'@'localhost';

