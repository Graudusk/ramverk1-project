
--
-- Create a database for test
--
-- DROP DATABASE IF EXISTS travel;
-- CREATE DATABASE IF NOT EXISTS travel;
-- USE travel;
USE erjh17;

-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;

--
-- Create a database user for the test database
--
GRANT ALL ON erjh17.* TO user@localhost IDENTIFIED BY 'user';

-- Ensure UTF8 on the database connection
SET NAMES utf8;
