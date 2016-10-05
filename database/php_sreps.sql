CREATE DATABASE IF NOT EXISTS php_SRePS;
USE php_SRePS;

DROP TRIGGER IF EXISTS TRIG_Product_Insert_Checks;
DROP TRIGGER IF EXISTS TRIG_Product_Update_Checks;
DROP TRIGGER IF EXISTS TRIG_SaleLine_Insert_Checks;
DROP TRIGGER IF EXISTS TRIG_SaleLine_Update_Checks;
DROP TRIGGER IF EXISTS TRIG_SaleLine_Insert;
DROP TRIGGER IF EXISTS TRIG_SaleLine_Update;
DROP TRIGGER IF EXISTS TRIG_SaleLine_Delete;
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
    IsHidden bit NOT NULL,
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

delimiter //
#Create triggers on the product table to mimic CHECK constraints
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
            cast(new.Price as char));
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

#Create triggers on the SaleLine table to act as check constraints and to
#keep the product QuantityOnHand and QuantitySold values consistent
CREATE TRIGGER TRIG_SaleLine_Insert BEFORE INSERT ON SaleLine
FOR EACH ROW
BEGIN
	DECLARE msg varchar(128);
	IF NEW.Quantity < 1 THEN
		set msg = concat('TRIG_SaleLine_Insert_Checks Error:',
			'Trying to insert a non-positive value into SaleLine.Quantity: ',
            cast(NEW.Quantity as char));
	ELSE
		UPDATE Product 
		SET 
			QuantityOnHand = QuantityOnHand - NEW.Quantity,
			QuantitySold = QuantitySold + NEW.Quantity
		WHERE Id = NEW.ProductId;
	END IF;
    IF msg IS NOT NULL THEN
		signal sqlstate '45000' set message_text = msg;
	END IF;
END
//

CREATE TRIGGER TRIG_SaleLine_Update BEFORE UPDATE ON SaleLine
FOR EACH ROW
BEGIN
	DECLARE msg varchar(128);
	IF NEW.Quantity < 1 THEN
		set msg = concat('TRIG_SaleLine_Update_Checks Error:',
			'Trying to update a non-positive value in SaleLine.Quantity: ',
            cast(NEW.Quantity as char));
	ELSE
		UPDATE Product 
		SET 
			QuantityOnHand = QuantityOnHand + OLD.Quantity,
			QuantitySold = QuantitySold - OLD.Quantity
		WHERE Id = OLD.ProductId;
		
		UPDATE Product
		SET
			QuantityOnHand = QuantityOnHand - NEW.Quantity,
			QuantitySold = QuantitySold + NEW.Quantity
		WHERE Id = NEW.ProductId;
	END IF;
    IF msg IS NOT NULL THEN
		signal sqlstate '45000' set message_text = msg;
	END IF;
END
//

CREATE TRIGGER TRIG_SaleLine_Delete BEFORE DELETE ON SaleLine
FOR EACH ROW
BEGIN
	UPDATE Product 
    SET 
		QuantityOnHand = QuantityOnHand + OLD.Quantity,
        QuantitySold = QuantitySold - OLD.Quantity
	WHERE Id = OLD.ProductId;
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

INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol 500mg 100 tablets', 9.99, 400, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol 500mg 50 tablets', 6.99, 250, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Panadol Rapid 20 tablets', 4.49, 382, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Nurofen 200mg 96 tablets', 15.99, 382, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Painkillers'), 'Nurofen for Children 1-5 Years Strawberry', 17.99, 37, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Prescription drugs'), 'Lipitor 20mg Tablets 30', 6.99, 21, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Prescription drugs'), 'Plavix 75mg Tablets 28 (a)', 7.29, 3, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Vitamins'), 'Swisse Ultiboost Calcium + Vitamin D', 13.00, 421, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Vitamins'), 'Herron Osteo Eze Active Plus MSM 120 Tablets', 40.83, 21, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Fragrances'), 'Marc Jacobs Daisy Eau de Toilette 100ml Spray', 65.20, 10, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Fragrances'), 'Calvin Klein CK One 200ml Eau de Toilette Spray', 37.99, 21, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Weight loss'), 'OptiSlim VLCD Bar Choc Fudge 5 Pack', 15.50, 35, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Weight loss'), 'Optislim VLCD Bars Variety 60g 15 Pack', 15.50, 45, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden) 
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Dental care'), 'Colgate Toothpaste Regular Flavour 250g', 3.20, 40, 0, 0, 0, 0);
INSERT INTO Product(ProductGroupId, Name, Price, QuantityOnHand, QuantitySold, QuantityToOrder, QuantityRequested, IsHidden)
VALUES((SELECT Id FROM ProductGroup WHERE Name = 'Dental care'), 'Colgate Toothpaste Total 190g', 5.55, 50, 0, 0, 0, 0);
