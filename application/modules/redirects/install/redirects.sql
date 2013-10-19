CREATE TABLE dbo.redirects (
  id int NOT NULL PRIMARY KEY IDENTITY,
  articleID int NOT NULL,
  redirect nvarchar(max)
)
GO