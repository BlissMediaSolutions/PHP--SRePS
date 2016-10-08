INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 30 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 4);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(5, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(15, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 29 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(8, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 28 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(4, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 20);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(6, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(6, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(9, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(10, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 27 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(4, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 3);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 26 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(7, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 25 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(10, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(14, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 3);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 24 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(4, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 13);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(5, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 7);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 23 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(10, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 3);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(5, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 22 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 4);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 21 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(3, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(9, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 8);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(10, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(11, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(12, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(14, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(15, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 29);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 20 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 19 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(12, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 4);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(13, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 8);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 18 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(7, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(8, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 40);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 17 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(9, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(3, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(4, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 19);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(13, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 16 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(6, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(2, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 4);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 9);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(14, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 9);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(15, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 15 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(9, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 14 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(5, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 3);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(6, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 13 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(11, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(12, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 3);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 12 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 200);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(2, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(3, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(4, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(5, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(6, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(7, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(8, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(9, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(11, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(12, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(13, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(14, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(15, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 11 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(2, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 10 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(5, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 3);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 9 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(11, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 8 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 15);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(2, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 18);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 7 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(9, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(15, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 6 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(3, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 10);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 5 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(4, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 14);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 4 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(2, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(12, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(13, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 5);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(6, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 3 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 8);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 2 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(15, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(11, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(12, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 2);

INSERT INTO Sale(SaleDateTime) VALUES (NOW() - INTERVAL 1 DAY);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(1, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 100);

INSERT INTO Sale(SaleDateTime) VALUES (NOW());
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(3, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);
INSERT INTO SaleLine(ProductId, SaleId, Quantity) Values(14, (SELECT Id FROM Sale ORDER BY Id desc LIMIT 1), 1);