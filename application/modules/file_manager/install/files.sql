# STEP 1: Create the files Table

/* MSSQL */

CREATE TABLE dbo.files (
  id int NOT NULL PRIMARY KEY IDENTITY,
  name varchar(255) NOT NULL,
  filename varchar(255) NOT NULL,
  full_path varchar(255) NOT NULL,
  url_path varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  extension varchar(255) NOT NULL,
  mimetype varchar(255) NOT NULL,
  width varchar(25) DEFAULT NULL,
  height varchar(25) DEFAULT NULL,
  filesize int NOT NULL,
  alt_attribute varchar(255) DEFAULT NULL,
  file_set varchar(255) DEFAULT NULL,
  author_id int NOT NULL,
  updated_on int NOT NULL,
  created_on  int NOT NULL,
  title  varchar(255) DEFAULT NULL,
  link  varchar(255) DEFAULT NULL,
 dir_id int NOT NULL
)
GO

/* MYSQL */

CREATE TABLE files (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  filename varchar(255) NOT NULL,
  full_path varchar(255) NOT NULL,
  url_path varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  extension varchar(255) NOT NULL,
  mimetype varchar(255) NOT NULL,
  width varchar(25) DEFAULT NULL,
  height varchar(25) DEFAULT NULL,
  filesize int NOT NULL,
  alt_attribute varchar(255) DEFAULT NULL,
  file_set varchar(255) DEFAULT NULL,
  author_id int NOT NULL,
  updated_on int NOT NULL,
  created_on  int NOT NULL,
  title  varchar(255) DEFAULT NULL,
  link  varchar(255) DEFAULT NULL,
  dir_id bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


# STEP 2: Create the Filesets Table

/* MYSQL*/

CREATE TABLE filesets (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;