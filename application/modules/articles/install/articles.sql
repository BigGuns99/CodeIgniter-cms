
/* MYSQL */

CREATE TABLE articles (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  created date NOT NULL,
  updated date NOT NULL,
  created_by int NOT NULL,
  summary text DEFAULT NULL,
  title text DEFAULT NULL,
  subheading text DEFAULT NULL,
  url text NOT NULL,
  category_id int,
  body longtext DEFAULT NULL,
  keywords text DEFAULT NULL,
  author_id int NOT NULL,
  created_on int, 
  updated_on int,
  description text DEFAULT NULL,
  status varchar(20) DEFAULT 'DRAFT',
  weight int,
  featured_image varchar(255) DEFAULT NULL,
  featured_image_raw varchar(255) DEFAULT NULL,
PRIMARY KEY (`id`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/* MSSQL */
CREATE TABLE dbo.articles (
  id int NOT NULL PRIMARY KEY IDENTITY,
  created date NOT NULL,
  updated date NOT NULL,
  created_by int NOT NULL,
  summary nvarchar(max) DEFAULT NULL,
  title nvarchar(max) DEFAULT NULL,
  subheading nvarchar(max) DEFAULT NULL,
  url varchar(255) NOT NULL,
  category_id int,
  body nvarchar(max) DEFAULT NULL,
  keywords nvarchar(max) DEFAULT NULL,
  author_id int NOT NULL,
  created_on int, 
  updated_on int,
  description nvarchar(max) DEFAULT NULL,
  status varchar(20) NOT NULL DEFAULT('DRAFT'),
  weight int,
  featured_image varchar(255) DEFAULT NULL,
  featured_image_raw varchar(255) DEFAULT NULL
)