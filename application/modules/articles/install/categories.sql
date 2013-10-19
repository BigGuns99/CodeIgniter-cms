
/* MSSQL */
CREATE TABLE dbo.categories (
  id int NOT NULL PRIMARY KEY IDENTITY,
  name varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
)

/* MYSQL*/

CREATE TABLE categories (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  parentID bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;