CREATE TABLE clashLog (
  id INTEGER(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  crashDate DATETIME,
  crashType VARCHAR(255),
  crashDetails VARCHAR(255),
  crashLocation VARCHAR(255),
  buildModel VARCHAR(255),
  buildOsVersion VARCHAR(255)
);