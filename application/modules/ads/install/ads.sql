CREATE TABLE dbo.ads (
  id int NOT NULL PRIMARY KEY IDENTITY,
  title varchar(255) NOT NULL,
  body nvarchar(max),
  category_id int DEFAULT NULL,
  author_id int NOT NULL,
  created int NOT NULL,
  updated int DEFAULT NULL,
  updated_by int DEFAULT NULL,
  status varchar(5) NOT NULL DEFAULT('DRAFT'),
  featured_image varchar(255) DEFAULT NULL,
  featured_image_raw varchar(255) DEFAULT NULL
)
GO