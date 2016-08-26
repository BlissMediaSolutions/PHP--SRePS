CREATE DATABASE IF NOT EXISTS php_SRePS;
USE php_SRePS;

DROP TRIGGER IF EXISTS TRIG_Product_Insert_Checks; 
DROP TRIGGER IF EXISTS TRIG_Product_Update_Checks;
DROP TRIGGER IF EXISTS TRIG_SaleLine_Insert_Checks;
DROP TRIGGER IF EXISTS TRIG_SaleLine_Update_Checks;
DROP TABLE IF EXISTS SaleLine, Sale, Customer, Product, ProductGroup;

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
    QuantityOnHand int NOT NULL,
    QuantitySold int NOT NULL,
    QuantityToOrder int NOT NULL,
    QuantityRequested int NOT NULL,
    CONSTRAINT FK_Product_ProductGroup FOREIGN KEY (ProductGroupId) REFERENCES ProductGroup(Id)
);

CREATE TABLE Customer(
	Id int PRIMARY KEY AUTO_INCREMENT,
    FirstName varchar(50) NOT NULL,
    FamilyName varchar(50) NOT NULL,
    PhoneNumber varchar(10)
);

CREATE TABLE Sale(
	Id int PRIMARY KEY AUTO_INCREMENT,
    CustomerId int,
    SaleDateTime datetime NOT NULL,
    CONSTRAINT Sale_Customer FOREIGN KEY (CustomerId) REFERENCES Customer(Id)
);

CREATE TABLE SaleLine(
	Id int PRIMARY KEY AUTO_INCREMENT,
    ProductId int NOT NULL,
    SaleId int NOT NULL,
    Quantity int NOT NULL,
    CONSTRAINT FK_SaleLine_Product FOREIGN KEY (ProductId) REFERENCES Product(Id),
    CONSTRAINT FK_SaleLine_Sale FOREIGN KEY (SaleId) REFERENCES Sale(Id)
);

#Create triggers to mimic CHECK constraints
delimiter //
CREATE TRIGGER TRIG_Product_Insert_Checks BEFORE INSERT ON Product
FOR EACH ROW
BEGIN
	DECLARE msg varchar(128);
	IF NEW.Price < 0 THEN
		set msg = concat('TRIG_Product_Insert_Checks Error:',
			'Trying to insert a negative value into Product.Price: ', 
            cast(NEW.Price as char));
	ELSEIF NEW.QuantityOnHand < 0 THEN
		set msg = concat('TRIG_Product_Insert_Checks Error:',
			'Trying to insert a negative value into Product.QuantityOnHand: ', 
            cast(NEW.QuantityOnHand as char));
	ELSEIF NEW.QuantitySold < 0 THEN
		set msg = concat('TRIG_Product_Insert_Checks Error:',
			'Trying to insert a negative value into Product.QuantitySold: ', 
            cast(NEW.QuantitySold as char));
	ELSEIF NEW.QuantityToOrder < 0 THEN
		set msg = concat('TRIG_Product_Insert_Checks Error:',
			'Trying to insert a negative value into Product.QuantityToOrder: ', 
            cast(NEW.QuantityToOrder as char));
	ELSEIF NEW.QuantityRequested < 0 THEN
		set msg = concat('TRIG_Product_Insert_Checks Error:',
			'Trying to insert a negative value into Product.QuantityRequested: ', 
            cast(NEW.QuantityRequested as char));
	END IF;
    IF msg IS NOT NULL THEN
		signal sqlstate '45000' set message_text = msg;
	END IF;
END
//


CREATE TRIGGER TRIG_Product_Update_Checks BEFORE UPDATE ON Product
FOR EACH ROW
BEGIN
	DECLARE msg varchar(128);
	IF NEW.Price < 0 THEN
		set msg = concat('TRIG_Product_Update_Checks Error:',
			'Trying to update a negative value in Product.Price: ', 
            cast(new.QuantityOnHand as char));
	ELSEIF NEW.QuantityOnHand < 0 THEN
		set msg = concat('TRIG_Product_Update_Checks Error:',
			'Trying to update a negative value in Product.QuantityOnHand: ', 
            cast(new.QuantityOnHand as char));
	ELSEIF NEW.QuantitySold < 0 THEN
		set msg = concat('TRIG_Product_Update_Checks Error:',
			'Trying to update a negative value in Product.QuantitySold: ', 
            cast(new.QuantitySold as char));
	ELSEIF NEW.QuantityToOrder < 0 THEN
		set msg = concat('TRIG_Product_Update_Checks Error:',
			'Trying to update a negative value in Product.QuantityToOrder: ', 
            cast(new.QuantityToOrder as char));
	ELSEIF NEW.QuantityRequested < 0 THEN
		set msg = concat('TRIG_Product_Update_Checks Error:',
			'Trying to update a negative value in Product.QuantityRequested: ', 
            cast(new.QuantityRequested as char));
	END IF;
    IF msg IS NOT NULL THEN
		signal sqlstate '45000' set message_text = msg;
	END IF;
END
//

CREATE TRIGGER TRIG_SaleLine_Insert_Checks BEFORE INSERT ON SaleLine
FOR EACH ROW
BEGIN
	DECLARE msg varchar(128);
	IF NEW.Quantity < 1 THEN
		set msg = concat('TRIG_SaleLine_Insert_Checks Error:',
			'Trying to insert a non-positive value into SaleLine.Quantity: ', 
            cast(NEW.Quantity as char));
	END IF;
    IF msg IS NOT NULL THEN
		signal sqlstate '45000' set message_text = msg;
	END IF;
END
//

CREATE TRIGGER TRIG_SaleLine_Update_Checks BEFORE UPDATE ON SaleLine
FOR EACH ROW
BEGIN
	DECLARE msg varchar(128);
	IF NEW.Quantity < 1 THEN
		set msg = concat('TRIG_SaleLine_Update_Checks Error:',
			'Trying to update a non-positive value in SaleLine.Quantity: ', 
            cast(NEW.Quantity as char));
	END IF;
    IF msg IS NOT NULL THEN
		signal sqlstate '45000' set message_text = msg;
	END IF;
END
//

delimiter ;


#Insert static reference data
INSERT INTO ProductGroup(Name) VALUES('Painkillers');
INSERT INTO ProductGroup(Name) VALUES('Prescription drugs');
INSERT INTO ProductGroup(Name) VALUES('Vitamins');
INSERT INTO ProductGroup(Name) VALUES('Fragrances');
INSERT INTO ProductGroup(Name) VALUES('Weight loss');
INSERT INTO ProductGroup(Name) VALUES('Dental care');

INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol 500mg 100 tablets', 9.99, 400, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol 500mg 50 tablets', 6.99, 250, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol Rapid 20 tablets', 4.49, 382, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Nurofen 200mg 96 tablets', 15.99, 382, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Nurofen for Children 1-5 Years Strawberry', 17.99, 37, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Prescription drugs'), 'Lipitor 20mg Tablets 30', 6.99, 21, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Prescription drugs'), 'Plavix 75mg Tablets 28 (a)', 7.29, 3, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Vitamins'), 'Swisse Ultiboost Calcium + Vitamin D', 13.00, 421, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Vitamins'), 'Herron Osteo Eze Active Plus MSM 120 Tablets', 40.83, 21, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES(NULL, 'Blackmores Odourless Fish Oil 1000mg Bulk Pack 500 Capsules', 38.20, 7, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES(NULL, 'Ansell Glove Hany Disposable 24', 3.99, 21, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested) 
VALUES(NULL, 'Morning Fresh Dishwashing Liquid Lemon 400ml', 1.50, 20, 0, 0, 0);