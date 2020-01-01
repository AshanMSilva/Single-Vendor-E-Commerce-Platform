-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2020 at 08:34 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_commerce_platform`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_Product_sales_count` ()  NO SQL
SELECT sum(quantity) as cc from orders INNER JOIN order_details using(order_id) where orders.order_date BETWEEN date1 and date2$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_most_sales_products` (IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT products.title, sum(order_details.quantity) as cc from orders INNER JOIN order_details using(order_id) INNER JOIN products using(product_id) WHERE orders.order_date BETWEEN date1 AND date2 GROUP BY order_details.product_id ORDER BY  cc DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reach_period` (IN `p_id` INT)  NO SQL
select sum(quantity) as cc, order_date from orders inner join order_details using(order_id)  where product_id=p_id group by order_date order by order_date$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_belonging_categories` (IN `id` INT)  NO SQL
SELECT categories.category_id, title FROM categories WHERE category_id IN (SELECT category_id FROM `product_category_relations` WHERE product_id = id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_customer_details` (IN `in_email` VARCHAR(50))  NO SQL
SELECT customers.customer_id, first_name, last_name, email, house_number, street, city, state, zip_code FROM `customers`  INNER JOIN (SELECT * FROM `registered_customers` WHERE registered_customers.email = in_email) AS reg_cust_details USING(customer_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reg_customer_by_id` (IN `id` INT)  NO SQL
SELECT cust_details.customer_id, first_name, last_name, email, house_number, street, city, state, zip_code FROM `registered_customers` INNER JOIN (SELECT * FROM `customers` WHERE customers.customer_id = id) AS cust_details USING(customer_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_category_products` (IN `id` INT)  NO SQL
SELECT * FROM `product_details` WHERE product_id IN (SELECT product_id FROM product_category_relations WHERE category_id = id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_customer_cart` (IN `id` INT)  NO SQL
SELECT products.product_id, title, brand, image, variant_id, sku, weight, price, stock, quantity FROM products INNER JOIN (SELECT * FROM optimized_cart_details WHERE customer_id = id) AS cust_cart USING(product_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_root_categories` ()  NO SQL
SELECT * FROM `categories` WHERE category_id NOT IN (SELECT sub_category_id FROM category_relations)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_sub_categories` (IN `id` INT)  NO SQL
SELECT * FROM `categories` WHERE category_id IN (SELECT sub_category_id FROM category_relations WHERE category_id = id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `top_selling_products` ()  NO SQL
SELECT product_details.product_id, title, brand, image, min_price, max_price, total_sales FROM product_details INNER JOIN (SELECT product_id, SUM(quantity) AS total_sales FROM order_details INNER JOIN (SELECT order_id FROM orders WHERE order_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) AS last_month_orders USING(order_id) GROUP BY product_id ORDER BY SUM(quantity) DESC) AS top_products USING(product_id) LIMIT 8$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calc_total_price` (`id` INT) RETURNS DECIMAL(15,2) BEGIN
	DECLARE total DECIMAL(15,2);
    SELECT SUM(price*quantity) INTO @total FROM variants INNER JOIN (SELECT variant_id, quantity FROM optimized_carts       	WHERE customer_id = id) AS unique_cart USING(variant_id);
	RETURN @total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `attribute_name` varchar(20) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`product_id`, `variant_id`, `attribute_name`, `value`) VALUES
(1, 1, 'RAM', '8GB'),
(1, 1, 'Storage', '128GB'),
(1, 1, 'Front Cam', '13MP'),
(1, 1, 'Back Cam', '18MP'),
(1, 1, 'Color', 'Black'),
(2, 2, 'RAM', '8GB'),
(2, 2, 'Processor', 'Intel Core i7-7500U 2.7GHz'),
(2, 2, 'Graphics', 'NVIDIA GeForce 940MX 4GB Dedicated VRAM'),
(2, 2, 'HDD', '1000GB'),
(2, 2, 'Color', 'Black'),
(2, 13, 'RAM', '8GB'),
(2, 13, 'Processor', 'Intel Core i7-8300U 3.0GHz'),
(2, 13, 'Graphics', 'NVIDIA GeForce 940MX 4GB Dedicated VRAM'),
(2, 13, 'HDD', '1000GB'),
(2, 13, 'Color', 'Grey');

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `customer_id` int(11) NOT NULL,
  `card_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `card_details`
--

INSERT INTO `card_details` (`customer_id`, `card_number`) VALUES
(15, '2261 6739 1032 5511');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `removed_flag` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`customer_id`, `product_id`, `variant_id`, `quantity`, `removed_flag`) VALUES
(15, 7, 18, 3, 0),
(15, 2, 13, 4, 0),
(15, 5, 5, 2, 0),
(15, 6, 6, 1, 0),
(15, 12, 12, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `title`, `description`, `image`) VALUES
(1, 'Electronic Devices', NULL, NULL),
(2, 'Toys', NULL, NULL),
(3, 'Smart Phones', NULL, NULL),
(4, 'Laptops', NULL, NULL),
(5, 'Speakers', NULL, NULL),
(6, 'Smart Watches', NULL, NULL),
(7, 'TVs', NULL, NULL),
(8, 'Computer Accessories', NULL, NULL),
(9, 'Diecast Toy Vehicles', NULL, NULL),
(10, 'Action Figures', NULL, NULL),
(11, 'Normal Laptops', NULL, NULL),
(12, 'Gaming Laptops', NULL, NULL),
(13, 'Normal TVs', NULL, NULL),
(14, 'Smart TVs', NULL, NULL),
(15, 'Subwoofers', NULL, NULL),
(16, 'Outdoor Speakers', NULL, NULL),
(17, 'Android Phones', NULL, NULL),
(18, 'iOS Phones', NULL, NULL),
(19, 'LCD TVs', NULL, NULL),
(20, 'LED TVs', NULL, NULL),
(21, 'Plasma TVs', NULL, NULL),
(22, 'Toy Vehicles', NULL, NULL),
(23, 'Ride On Toy Vehicles', NULL, NULL),
(24, 'Remote Control Vehicles', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_relations`
--

CREATE TABLE `category_relations` (
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_relations`
--

INSERT INTO `category_relations` (`category_id`, `sub_category_id`) VALUES
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 10),
(4, 11),
(4, 12),
(7, 13),
(7, 14),
(7, 19),
(7, 20),
(7, 21),
(3, 17),
(3, 18),
(5, 15),
(5, 16),
(2, 22),
(22, 9),
(22, 23),
(22, 24);

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `courier_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courier_contacts`
--

CREATE TABLE `courier_contacts` (
  `courier_id` int(11) NOT NULL,
  `contact_number` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`) VALUES
(1, 'John', 'Felix'),
(2, 'Sam', 'Howard'),
(3, 'Peter', 'Jenkinson'),
(4, 'Alice', 'Summerville'),
(5, 'Dean', 'Morgan'),
(6, 'Kaif', 'Ali'),
(7, 'Mary', 'Whitefield'),
(8, 'Shane', 'Cooper'),
(9, 'Sam', 'Winchester'),
(10, 'Danny', 'Wu'),
(11, 'Sophia', 'Morgan'),
(12, 'Zheng', 'Mei'),
(13, 'Calvin', 'Harris'),
(14, 'Alex', 'Benjamin'),
(15, 'Sahan', 'Jayasinghe'),
(16, 'Crowley', 'Stanford');

-- --------------------------------------------------------

--
-- Table structure for table `customer_contacts`
--

CREATE TABLE `customer_contacts` (
  `customer_id` int(11) NOT NULL,
  `contact_number` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_contacts`
--

INSERT INTO `customer_contacts` (`customer_id`, `contact_number`) VALUES
(16, '1234567890'),
(16, '0987654321'),
(15, '0714861225'),
(15, '0332270611');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `order_id` int(11) NOT NULL,
  `courier_id` int(11) DEFAULT NULL,
  `delivery_method` varchar(20) NOT NULL,
  `tracking_info` varchar(100) DEFAULT NULL,
  `estimated_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'in-progress',
  `customer_contact` varchar(12) NOT NULL,
  `house_number` int(11) DEFAULT NULL,
  `street` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`order_id`, `courier_id`, `delivery_method`, `tracking_info`, `estimated_date`, `completed_date`, `status`, `customer_contact`, `house_number`, `street`, `city`, `state`, `zip_code`) VALUES
(16, NULL, 'delivery', '5e0a1a95a0dd9_955736', '2020-01-07', NULL, 'in-progress', '112-1356-298', 21, 'Reed Avenue', 'New Orleans', 'Nevada', '45781'),
(17, NULL, 'delivery', '5e0ac2d450729_176886', '2020-01-05', NULL, 'in-progress', '112-1356-298', 21, 'Reed Avenue', 'New Orleans', 'Nevada', '45781');

-- --------------------------------------------------------

--
-- Table structure for table `guest_customers`
--

CREATE TABLE `guest_customers` (
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `main_cities`
--

CREATE TABLE `main_cities` (
  `city` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_cities`
--

INSERT INTO `main_cities` (`city`) VALUES
('Austin'),
('Beaumont'),
('Boston'),
('Chicago'),
('Cleveland'),
('Dallas'),
('Denver'),
('Detroit'),
('El Paso'),
('Houston'),
('Kansas City'),
('Las Vegas'),
('Miami'),
('Minneapolis'),
('New Orleans'),
('New York'),
('Philadelphia'),
('San Antonio'),
('San Diego'),
('San Francisco'),
('Seattle'),
('Washington, D.C.');

-- --------------------------------------------------------

--
-- Stand-in structure for view `optimized_carts`
-- (See below for the actual view)
--
CREATE TABLE `optimized_carts` (
`customer_id` int(11)
,`product_id` int(11)
,`variant_id` int(11)
,`quantity` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `optimized_cart_details`
-- (See below for the actual view)
--
CREATE TABLE `optimized_cart_details` (
`customer_id` int(11)
,`quantity` int(11)
,`product_id` int(11)
,`variant_id` int(11)
,`sku` varchar(25)
,`weight` decimal(10,3)
,`price` decimal(15,2)
,`stock` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ordered_categories`
-- (See below for the actual view)
--
CREATE TABLE `ordered_categories` (
`category_title` varchar(50)
,`category_description` varchar(150)
,`variant_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `customer_id`, `deleted`) VALUES
(1, '2019-10-28', 3, 0),
(2, '2019-11-05', 7, 0),
(3, '2019-11-16', 4, 0),
(4, '2019-11-16', 1, 0),
(5, '2019-11-21', 9, 0),
(6, '2019-11-26', 3, 0),
(7, '2019-12-02', 4, 0),
(8, '2019-12-02', 1, 0),
(9, '2019-12-04', 7, 0),
(10, '2019-12-07', 2, 0),
(11, '2019-12-08', 10, 0),
(12, '2019-12-08', 3, 0),
(13, '2019-12-08', 7, 0),
(14, '2019-12-12', 8, 0),
(15, '2019-12-15', 4, 0),
(16, '2019-12-30', 15, 0),
(17, '2019-12-31', 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `variant_id`, `quantity`) VALUES
(1, 8, 8, 1),
(1, 5, 16, 1),
(2, 3, 3, 1),
(3, 8, 8, 1),
(3, 10, 10, 2),
(4, 1, 1, 1),
(4, 13, 30, 2),
(4, 16, 36, 1),
(5, 8, 19, 1),
(5, 16, 37, 1),
(6, 1, 1, 1),
(6, 15, 34, 3),
(7, 11, 11, 1),
(8, 2, 13, 1),
(8, 5, 16, 2),
(9, 6, 6, 1),
(9, 13, 31, 1),
(10, 12, 12, 1),
(16, 7, 18, 1),
(16, 2, 13, 2),
(17, 7, 18, 1),
(17, 2, 13, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `card_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`order_id`, `payment_method`, `amount`, `card_number`) VALUES
(16, 'card', '362.00', '1425'),
(17, 'card', '362.00', '2261');

-- --------------------------------------------------------

--
-- Stand-in structure for view `price_range`
-- (See below for the actual view)
--
CREATE TABLE `price_range` (
`product_id` int(11)
,`min_price` decimal(15,2)
,`max_price` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `title`, `brand`, `image`) VALUES
(1, 'SAMSUNG_S10', 'Samsung', NULL),
(2, 'ACER_ASPIRE_F15', 'ACER', NULL),
(3, 'HP Elite Dragonfly', 'HP', NULL),
(4, 'HP Zbook 15u G5', 'HP', NULL),
(5, 'SONY XB402M Extra Bass', 'SONY', NULL),
(6, 'Plasma TV-TH27391YT', 'Panasonic', NULL),
(7, 'Huawei P9', 'Huawei', NULL),
(8, 'ACER Chromebook Spin511', 'ACER', NULL),
(9, 'ACER Nitro 7', 'ACER', NULL),
(10, 'SONY GTK-PG10 Outdoor Speaker', 'SONY', NULL),
(11, 'iPhone X', 'Apple', NULL),
(12, 'ASUS Predator 701', 'ASUS', NULL),
(13, 'Samsung Gear S3 Frontier Smartwatch', 'Samsung', NULL),
(14, 'Mercedes C63S Kids Ride-on Car', 'Unbranded', NULL),
(15, 'Monster Jam Mini Pack', 'Hot Wheels', NULL),
(16, 'Xiaomi mi band 4 BT5.0 Standard Edition', 'Xiaomi', NULL),
(17, 'LG Premier 2.0 Smart TV ', 'LG', NULL),
(18, 'Lego Marvel Avengers Minifigures', 'Lego', NULL),
(19, 'Technic RC Remote Control Racing Car', 'Lego', NULL),
(20, 'Sony Smart Band SWR30', 'SONY', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_category_relations`
--

CREATE TABLE `product_category_relations` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category_relations`
--

INSERT INTO `product_category_relations` (`product_id`, `category_id`) VALUES
(1, 17),
(2, 11),
(3, 11),
(4, 4),
(5, 15),
(6, 21),
(6, 13),
(7, 17),
(8, 11),
(9, 11),
(10, 16),
(11, 18),
(12, 12),
(13, 6),
(15, 9),
(14, 23),
(16, 6),
(17, 14),
(17, 20),
(18, 10),
(20, 6),
(19, 24);

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_details`
-- (See below for the actual view)
--
CREATE TABLE `product_details` (
`product_id` int(11)
,`title` varchar(100)
,`brand` varchar(50)
,`image` varchar(255)
,`min_price` decimal(15,2)
,`max_price` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `registered_customers`
--

CREATE TABLE `registered_customers` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `house_number` int(11) NOT NULL,
  `street` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `zip_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registered_customers`
--

INSERT INTO `registered_customers` (`customer_id`, `email`, `password`, `house_number`, `street`, `city`, `state`, `zip_code`) VALUES
(1, 'johnfelix145@example.com', 'jfgORVR1nMRSlU4ZqwRl4Q==', 75, 'Lorem Rd', 'Zuni', 'Rhode Island', '87771'),
(2, 'samhoward@example.com', 'pbI2BqjtDQR7tAI/d8xj0Q==', 19, 'Nascetur Ave', 'Housten', 'Texas', '32164'),
(3, 'peterjenkins@example.com', 'ucWn7dKzF+J//fu+xVZIpQ==', 148, 'Venenatis St.', 'Glen Haven', 'Nevada', '76891'),
(4, 'alicesummer@example.com', 'howZlIIY3Yx5XGXD4yliBg==', 6, 'Quam Street', 'Rowley', 'Alaska', '29510'),
(5, 'deanmorgan7@example.com', 'WQUWPmcK5gklqLYuykY0FA==', 27, 'Senectus St', 'El Paso', 'Texas', '37722'),
(6, 'kaifali215@example.com', 'H81c0+4gA69F5oKSSDxoBA==', 95, 'Dickinson Square', 'Dresden', 'New Jersey', '70862'),
(7, 'marywhite@nowhere.com', '4iT8zFUdJQ1W3YaH5e7Eig==', 46, 'Euismod Av', 'Paia', 'Vermont', '84684'),
(8, 'shanecooper@example.com', '1yFzehy7+zt+VMYMOIguCA==', 42, 'Lectus Ave', 'Glen Head', 'Illinois', '24015'),
(9, 'samwinchester6@example.com', '4NI3jN0oOvgQkZ4VJ7YK8g==', 16, 'Aenean Street', 'Roxboro', 'Alabama', '63402'),
(10, 'dannywu@nowhere.com', 'NmeE/vygrhgRMDQWs2pHPw==', 60, 'Dui. Rd', 'Soquel', 'South Dakota', '07396'),
(15, 'sahanjayasinghe.17@cse.mrt.ac.lk', '$2y$10$7yT9Hm4Ea/ncOlB40u1xrOOC8gS8GU3XdeEsansJZWdvYF1jbdyyS', 77, 'Loften Avenue', 'Philedelphia', 'Pennsylvania', '45107'),
(16, 'crowley@gmail.com', '$2y$10$O8TmBK5YsO3d05FtDWl9lOhl/4yv8LFBBQ/Lo6JraU2zansNiabXu', 23, 'main street', 'New Jersy', 'Philedelphia', '45107');

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `sku` varchar(25) NOT NULL,
  `weight` decimal(10,3) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`product_id`, `variant_id`, `sku`, `weight`, `price`, `stock`) VALUES
(1, 1, '345-298-2xx', '456.300', '84.76', 0),
(2, 2, '988cjj2ka', '2314.830', '138.00', 0),
(3, 3, '6ty-8729-vb45', '1875.270', '104.00', 0),
(4, 4, '80uy-bjdc3-j41nk', '1772.400', '122.00', 0),
(5, 5, 'bfehi-b72bq-72n9n', '420.500', '72.00', 0),
(6, 6, 'jhwd810-bjsc821', '2651.350', '88.56', 0),
(7, 7, 'chi9nw81-83nef9', '322.845', '82.00', 0),
(8, 8, 'hskq01-nsckh12-15db71', '1681.620', '103.00', 0),
(9, 9, 'aplm23-maqp12-pzw6v', '2027.000', '99.00', 0),
(10, 10, '6489anco', '3401.780', '52.00', 0),
(11, 11, '80qpz2-bcsu310', '486.500', '108.00', 0),
(12, 12, 'qa3-op7-xs2-l7ww', '1956.491', '149.00', 0),
(2, 13, '87ryjhxs923', '2730.100', '140.00', 3),
(3, 14, '82u-y17s-hd81', '1772.041', '115.00', 0),
(4, 15, '80uy-j27bj4-sj82', '1449.000', '123.00', 0),
(5, 16, 'bfgr7-ncsu91-nfei82n', '420.500', '77.00', 0),
(6, 17, 'jsghkqh8-bsc6714', '1945.580', '68.40', 0),
(7, 18, 'hwjhla92-ns882', '322.845', '82.00', 22),
(8, 19, 'nzc23-ml71q-lpoae4', '1558.410', '102.00', 0),
(9, 20, 'qb29npa-1hakno-aki1010', '2117.450', '98.00', 0),
(11, 21, 'nd901-za10lo6', '486.500', '108.00', 0),
(4, 22, '80uy-vhg27b-b763b', '1832.973', '116.00', 0),
(7, 23, 'nkdskj81-aazw2', '345.100', '93.00', 0),
(11, 24, '801aer-mpq012', '495.120', '111.00', 0),
(7, 25, 'balpq953-nzka12', '345.100', '93.00', 0),
(11, 26, 'pmxd87-sevm25', '496.720', '111.00', 0),
(12, 27, 's2i-qp1-b23-ga3e', '1872.410', '144.00', 0),
(13, 28, 'sgu82-fwx92', '84.390', '51.99', 0),
(13, 29, 'sgq05-am54d', '85.830', '54.20', 0),
(13, 30, 'sg4r9-e2ui8', '85.830', '52.78', 0),
(13, 31, 'sg3h2-6ciq0', '84.390', '51.99', 0),
(14, 32, 'w107y-jz34-33e', '5883.900', '87.00', 0),
(14, 33, 'w204m-6y2y-dr9', '5883.900', '87.00', 0),
(15, 34, 'up90zxx2ert', '825.910', '42.00', 0),
(15, 35, 'uq34axks431', '1022.350', '45.00', 0),
(16, 36, 'XM21qw-e56yzkj', '72.936', '22.00', 0),
(16, 37, 'XM4t6q3-niq981', '72.936', '22.00', 0);

-- --------------------------------------------------------

--
-- Structure for view `optimized_carts`
--
DROP TABLE IF EXISTS `optimized_carts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `optimized_carts`  AS  select `carts`.`customer_id` AS `customer_id`,`carts`.`product_id` AS `product_id`,`carts`.`variant_id` AS `variant_id`,`carts`.`quantity` AS `quantity` from `carts` where (`carts`.`removed_flag` = 0) ;

-- --------------------------------------------------------

--
-- Structure for view `optimized_cart_details`
--
DROP TABLE IF EXISTS `optimized_cart_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `optimized_cart_details`  AS  select `optimized_carts`.`customer_id` AS `customer_id`,`optimized_carts`.`quantity` AS `quantity`,`variants`.`product_id` AS `product_id`,`variants`.`variant_id` AS `variant_id`,`variants`.`sku` AS `sku`,`variants`.`weight` AS `weight`,`variants`.`price` AS `price`,`variants`.`stock` AS `stock` from (`optimized_carts` join `variants` on((`optimized_carts`.`variant_id` = `variants`.`variant_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `ordered_categories`
--
DROP TABLE IF EXISTS `ordered_categories`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ordered_categories`  AS  select `categories`.`title` AS `category_title`,`categories`.`description` AS `category_description`,`order_details`.`variant_id` AS `variant_id` from (`categories` join `order_details`) where `categories`.`category_id` in (select `product_category_relations`.`category_id` from `product_category_relations` where `product_category_relations`.`product_id` in (select `variants`.`product_id` from `variants` where `variants`.`variant_id` in (select `order_details`.`variant_id` from `order_details`))) ;

-- --------------------------------------------------------

--
-- Structure for view `price_range`
--
DROP TABLE IF EXISTS `price_range`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `price_range`  AS  select `variants`.`product_id` AS `product_id`,min(`variants`.`price`) AS `min_price`,max(`variants`.`price`) AS `max_price` from `variants` group by `variants`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `product_details`
--
DROP TABLE IF EXISTS `product_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_details`  AS  select `products`.`product_id` AS `product_id`,`products`.`title` AS `title`,`products`.`brand` AS `brand`,`products`.`image` AS `image`,`price_range`.`min_price` AS `min_price`,`price_range`.`max_price` AS `max_price` from (`products` join `price_range` on((`products`.`product_id` = `price_range`.`product_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `category_relations`
--
ALTER TABLE `category_relations`
  ADD KEY `category_id` (`category_id`),
  ADD KEY `sub_category_id` (`sub_category_id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`courier_id`);

--
-- Indexes for table `courier_contacts`
--
ALTER TABLE `courier_contacts`
  ADD KEY `courier_id` (`courier_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `tracking_info` (`tracking_info`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `courier_id` (`courier_id`);

--
-- Indexes for table `guest_customers`
--
ALTER TABLE `guest_customers`
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `main_cities`
--
ALTER TABLE `main_cities`
  ADD UNIQUE KEY `city` (`city`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category_relations`
--
ALTER TABLE `product_category_relations`
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `registered_customers`
--
ALTER TABLE `registered_customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `variants_ibfk_1` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`variant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attributes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_details`
--
ALTER TABLE `card_details`
  ADD CONSTRAINT `card_details_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `registered_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`variant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category_relations`
--
ALTER TABLE `category_relations`
  ADD CONSTRAINT `category_relations_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_relations_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courier_contacts`
--
ALTER TABLE `courier_contacts`
  ADD CONSTRAINT `courier_contacts_ibfk_1` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`courier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  ADD CONSTRAINT `customer_contacts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`courier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guest_customers`
--
ALTER TABLE `guest_customers`
  ADD CONSTRAINT `guest_customers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`variant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_category_relations`
--
ALTER TABLE `product_category_relations`
  ADD CONSTRAINT `product_category_relations_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category_relations_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registered_customers`
--
ALTER TABLE `registered_customers`
  ADD CONSTRAINT `registered_customers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
