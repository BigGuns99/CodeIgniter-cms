# STEP 1: Create the Data Base

/* MSSQL */

CREATE TABLE dbo.directories (
  id int NOT NULL PRIMARY KEY IDENTITY,
  title varchar(255) NOT NULL,
  dir_name varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  server_path varchar(255) NOT NULL,
  url_path varchar(255) NOT NULL,
  parent_dir int DEFAULT NULL,
  author_id int NOT NULL,
)

/* MYSQL */

CREATE TABLE directories (
 id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  dir_name varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  server_path varchar(255) NOT NULL,
  url_path varchar(255) NOT NULL,
  parent_dir int DEFAULT NULL,
  author_id bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# STEP 2: Add the root Directory

INSERT INTO `directories`(`title`, `dir_name`, `description`, `server_path`, `url_path`, `parent_dir`, `author_id`) VALUES ('root','root','The root directory','assets/files','assets/files',0,1)