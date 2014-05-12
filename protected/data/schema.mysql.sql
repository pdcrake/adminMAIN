CREATE DATABASE  `yourplace` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE  `yourplace`.`user` (
`uid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 40 ) NOT NULL ,
`surname` VARCHAR( 40 ) NOT NULL ,
`phone` VARCHAR( 10 ) NOT NULL ,
`dateofbirth` INT NOT NULL ,
`gender` VARCHAR( 10 ) NOT NULL ,
`image` VARCHAR( 30 ) NOT NULL ,
`password` VARCHAR( 40 ) NOT NULL
) ENGINE = INNODB;

CREATE TABLE  `yourplace`.`client` (
`cid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 40 ) NOT NULL ,
`email` VARCHAR( 40 ) NOT NULL ,
`phone` VARCHAR( 10 ) NOT NULL ,
`cat_id` INT NOT NULL ,
`time_begin` INT NOT NULL ,
`time_end` INT NOT NULL ,
`wifi` TINYINT NOT NULL ,
`smoking` TINYINT NOT NULL ,
`childroom` TINYINT NOT NULL ,
`logo` VARCHAR( 30 ) NOT NULL ,
`password` VARCHAR( 40 ) NOT NULL ,
INDEX (  `cat_id` ) ,
UNIQUE (
`email`
)

CREATE TABLE  `yourplace`.`place` (
`pid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cid` INT NOT NULL ,
INDEX (  `cid` )
) ENGINE = INNODB;

CREATE TABLE  `yourplace`.`certificate` (
`cert_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cid` INT NOT NULL ,
`name` VARCHAR( 30 ) NOT NULL ,
`description` TEXT NOT NULL ,
`condition` TEXT NOT NULL ,
`age_max` INT NOT NULL ,
`age_min` INT NOT NULL ,
`gender` INT NOT NULL ,
`attend_max` INT NOT NULL ,
`attend_min` INT NOT NULL ,
`mark_max` INT NOT NULL ,
`mark_min` INT NOT NULL ,
`mark_here` TINYINT NOT NULL ,
`star_max` INT NOT NULL ,
`star_min` INT NOT NULL ,
INDEX (  `cid` )
) ENGINE = INNODB;

CREATE TABLE  `yourplace`.`placeCertificate` (
`pc_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pid` INT NOT NULL ,
`cert_id` INT NOT NULL
) ENGINE = INNODB;

ALTER TABLE  `placeCertificate` ADD INDEX (  `cert_id` )
ALTER TABLE  `placeCertificate` ADD INDEX (  `pid` )

CREATE TABLE  `yourplace`.`notification` (
`nid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cid` INT NOT NULL ,
`message` TEXT NOT NULL ,
INDEX (  `cid` )
) ENGINE = INNODB;

CREATE TABLE  `yourplace`.`star` (
`sid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`uid` INT NOT NULL ,
`cert_id` INT NOT NULL ,
`amount` INT NOT NULL 
) ENGINE = INNODB;

ALTER TABLE  `star` ADD INDEX (  `cert_id` )
ALTER TABLE  `star` ADD INDEX (  `uid` )

CREATE TABLE  `yourplace`.`mark` (
`mid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`uid` INT NOT NULL ,
`cid` INT NOT NULL 
) ENGINE = INNODB;

ALTER TABLE  `mark` ADD INDEX (  `uid` )
ALTER TABLE  `mark` ADD INDEX (  `pid` )

CREATE TABLE  `yourplace`.`category` (
`cat_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`category_name` VARCHAR( 40 ) NOT NULL
) ENGINE = INNODB;

ALTER TABLE  `certificate` ADD FOREIGN KEY (  `cid` ) REFERENCES  `yourplace`.`client` (
`cid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `client` ADD FOREIGN KEY (  `cat_id` ) REFERENCES  `yourplace`.`category` (
`cat_id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `mark` ADD FOREIGN KEY (  `uid` ) REFERENCES  `yourplace`.`user` (
`uid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `mark` ADD FOREIGN KEY (  `cid` ) REFERENCES  `yourplace`.`client` (
`cid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `notification` ADD FOREIGN KEY (  `cid` ) REFERENCES  `yourplace`.`client` (
`cid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `place` ADD FOREIGN KEY (  `cid` ) REFERENCES  `yourplace`.`client` (
`cid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `placeCertificate` ADD FOREIGN KEY (  `pid` ) REFERENCES  `yourplace`.`place` (
`pid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `placeCertificate` ADD FOREIGN KEY (  `cert_id` ) REFERENCES  `yourplace`.`certificate` (
`cert_id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `star` ADD FOREIGN KEY (  `uid` ) REFERENCES  `yourplace`.`user` (
`uid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `star` ADD FOREIGN KEY (  `cert_id` ) REFERENCES  `yourplace`.`certificate` (
`cert_id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE  `yourplace`.`order` (
`oid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`uid` INT NOT NULL ,
`cert_id` INT NOT NULL ,
`time` INT NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE  `order` ADD INDEX (  `cert_id` )
ALTER TABLE  `order` ADD INDEX (  `uid` )

ALTER TABLE  `order` ADD FOREIGN KEY (  `uid` ) REFERENCES  `yourplace`.`user` (
`uid`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `order` ADD FOREIGN KEY (  `cert_id` ) REFERENCES  `yourplace`.`certificate` (
`cert_id`
) ON DELETE CASCADE ON UPDATE CASCADE ;
