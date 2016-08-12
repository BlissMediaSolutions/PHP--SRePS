CREATE DATABASE IF NOT EXISTS php_SRePS;
USE php_SRePS;

DROP TABLE IF EXISTS Sale, Product, ProductGroup;

#Create tables

CREATE TABLE ProductGroup(
	Id int PRIMARY KEY AUTO_INCREMENT,
    Name varchar(50) NOT NULL
);

CREATE TABLE Product(
	Id int PRIMARY KEY AUTO_INCREMENT,
    ProductGroupId int,
    Name varchar(100) NOT NULL,
    Price decimal(8,2),
    CONSTRAINT FK_Product_ProductGroup FOREIGN KEY (ProductGroupId) 
	REFERENCES ProductGroup(Id),
    CONSTRAINT CHK_Price CHECK (Price >= 0)
);

CREATE TABLE Sale(
	Id int PRIMARY KEY AUTO_INCREMENT,
    ProductId int NOT NULL,
    Quantity int NOT NULL,
    SaleDateTime datetime NOT NULL,
    CONSTRAINT FK_Sale_Product FOREIGN KEY (ProductId) 
    REFERENCES Product(Id),
    CONSTRAINT CHK_Quantity CHECK (Quantity >= 1)
);

#Insert static reference data
INSERT INTO ProductGroup(Name) VALUES('Painkillers');
INSERT INTO ProductGroup(Name) VALUES('Prescription drugs');
INSERT INTO ProductGroup(Name) VALUES('Vitamins');
INSERT INTO ProductGroup(Name) VALUES('Fragrances');
INSERT INTO ProductGroup(Name) VALUES('Weight loss');
INSERT INTO ProductGroup(Name) VALUES('Dental care');

INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol 500mg 100 tablets', 9.99);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol 500mg 50 tablets', 6.99);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol Rapid 20 tablets', 4.49);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Nurofen 200mg 96 tablets', 15.99);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Nurofen for Children 1-5 Years Strawberry', 17.99);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Prescription drugs'), 'Lipitor 20mg Tablets 30', 6.99);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Prescription drugs'), 'Plavix 75mg Tablets 28 (a)', 7.29);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Vitamins'), 'Swisse Ultiboost Calcium + Vitamin D', 13.00);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Vitamins'), 'Herron Osteo Eze Active Plus MSM 120 Tablets', 40.83);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES(NULL, 'Blackmores Odourless Fish Oil 1000mg Bulk Pack 500 Capsules', 38.20);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES(NULL, 'Ansell Glove Hany Disposable 24', 3.99);
INSERT INTO Product(ProductGroupId, Name, Price) 
VALUES(NULL, 'Morning Fresh Dishwashing Liquid Lemon 400ml', 1.50);