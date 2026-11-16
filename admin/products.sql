CREATE TABLE `Products` (
  `product_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) unsigned NOT NULL,
  `stock` int unsigned NOT NULL DEFAULT '0',
  `on_sale` tinyint(1) NOT NULL DEFAULT '0',
  `sale_price` decimal(10,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO Products (product_id, name, image, price, stock)
VALUES
    (1, 'Apples', '../assets/Apples.jpg', 3.00, 25),
    (2, 'Bread', '../assets/Bread.jpg', 2.99, 15),
    (3, '3', '../assets/milk.jpg', 3.69, 10);
