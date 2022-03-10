CREATE DATABASE `simple-php-orm`;
USE `simple-php-orm`;
CREATE TABLE myobject (
    _id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(30) NOT NULL,
    lname VARCHAR(30) NOT NULL,
    age INT(10),
    gender VARCHAR(30) NOT NULL
)