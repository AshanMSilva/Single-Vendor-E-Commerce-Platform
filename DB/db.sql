-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2020 at 05:52 AM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_belonging_categories` (IN `id` INT)  NO SQL
SELECT categories.category_id, title FROM categories WHERE category_id IN (SELECT category_id FROM `product_category_relations` WHERE product_id = id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_category_with_most_orders` ()  NO SQL
select categories.title, sum(order_details.quantity) as cc from order_details join product_category_relations USING (product_id) join categories using(category_id) group by category_id order by cc DESC limit 10$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_customer_details` (IN `in_email` VARCHAR(50))  NO SQL
SELECT customers.customer_id, first_name, last_name, email, house_number, street, city, state, zip_code FROM `customers`  INNER JOIN (SELECT * FROM `registered_customers` WHERE registered_customers.email = in_email) AS reg_cust_details USING(customer_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_most_sales_products` (IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT products.title, sum(order_details.quantity*price)  as cc from orders INNER JOIN order_details using(order_id) INNER JOIN products using (product_id) INNER JOIN variants using(variant_id)  WHERE orders.order_date BETWEEN date1 AND date2  GROUP BY order_details.product_id ORDER BY order_date$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_order_info` (IN `o_id` INT)  NO SQL
SELECT orders.order_id as order_id, order_date, customer_id, deleted, payment_method, amount, card_number, courier_id, delivery_method, tracking_info, estimated_date, completed_date, status, customer_contact, house_number, street, city, state, last_name, zip_code, email, first_name , current_location FROM orders  join payments on orders.order_id=payments.order_id left JOIN (SELECT * FROM deliveries NATURAL JOIN couriers) as t on orders.order_id=t.order_id WHERE orders.order_id=o_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_order_info_by_track` (IN `track` VARCHAR(100))  NO SQL
SELECT orders.order_id as order_id, order_date, customer_id, deleted, payment_method, amount, card_number, courier_id, delivery_method, tracking_info, estimated_date, completed_date, status, customer_contact, house_number, street, city, state, last_name, zip_code, email, first_name , current_location FROM orders left join payments on orders.order_id=payments.order_id left JOIN (SELECT * FROM deliveries NATURAL JOIN couriers) as t on orders.order_id=t.order_id WHERE t.tracking_info=track$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_products_of_order` (IN `o_id` INT)  NO SQL
SELECT title , price , quantity FROM products natural join variants as t JOIN order_details on order_details.product_id = t.product_id and order_details.variant_id=t.variant_id WHERE order_details.order_id = o_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_quarter_sales` (IN `y_in` INT)  NO SQL
SELECT order_date ,Q , tt.product_id as product_id,title, brand , product_total ,product_quantity FROM (SELECT order_date ,Q , k.product_id as product_id,k.variant_id as variant_id , SUM(quantity*price) as product_total , SUM(quantity)as product_quantity FROM (SELECT * FROM (SELECT order_id as id, order_date,Quarter(`order_date`)as Q FROM `orders` WHERE YEAR(`order_date`)=y_in)as t JOIN `order_details` on t.id = order_details.order_id) as k JOIN variants on k.variant_id = variants.variant_id GROUP BY product_id , Q)as tt LEFT JOIN products on tt.product_id=products.product_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reach_period` (IN `p_id` INT)  NO SQL
select sum(quantity) as cc, order_date from orders inner join order_details using(order_id)  where product_id=p_id group by order_date order by order_date$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reg_customer_by_id` (IN `id` INT)  NO SQL
SELECT cust_details.customer_id, first_name, last_name, email, house_number, street, city, state, zip_code FROM `registered_customers` INNER JOIN (SELECT * FROM `customers` WHERE customers.customer_id = id) AS cust_details USING(customer_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_undeleted_orders` (IN `user_id` INT)  NO SQL
SELECT orders.order_id,orders.order_date,amount,t.status,t.tracking_info FROM orders LEFT OUTER JOIN (payments NATURAL join deliveries as t) on t.order_id=orders.order_id WHERE orders.customer_id=user_id and `deleted`=0$$

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
(2, 13, 'Color', 'Grey'),
(20, 44, 'Color', 'Black'),
(20, 44, 'Display', '1.4 inch E-ink'),
(20, 44, 'Resolution', '296 x 128'),
(20, 44, 'Waterproof', 'Yes'),
(20, 45, 'Color', 'Grey'),
(20, 45, 'Display', '1.4 inch E-ink'),
(20, 45, 'Resolution', '296 x 128'),
(20, 45, 'Waterproof', 'Yes'),
(20, 46, 'Color', 'Blue'),
(20, 46, 'Display', '1.4 inch E-ink'),
(20, 46, 'Resolution', '296 x 128'),
(20, 46, 'Waterproof', 'Yes'),
(20, 47, 'Color', 'White'),
(20, 47, 'Display', '1.4 inch E-ink'),
(20, 47, 'Resolution', '296 x 128'),
(20, 47, 'Waterproof', 'Yes');

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
(15, '2261 6739 1032 5511'),
(15, '1425 7842 8246 3924'),
(1, '1073 4497 2966 7215'),
(15, '1587 4565 9782 1568');

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
(15, 7, 18, 3, 1),
(15, 2, 13, 4, 1),
(15, 5, 5, 2, 1),
(15, 6, 6, 1, 1),
(15, 12, 12, 2, 1),
(15, 2, 2, 1, 1),
(15, 11, 24, 2, 1),
(1, 10, 10, 2, 1),
(1, 14, 33, 1, 1),
(15, 7, 23, 2, 1);

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
(1, 'Electronic Devices', NULL, 'img/category/electronic_devices.jpg'),
(2, 'Toys', NULL, 'img/category/toys.jpg'),
(3, 'Smart Phones', NULL, 'img/category/smartphones.jpg'),
(4, 'Laptops', NULL, 'img/category/laptops.jpg'),
(5, 'Speakers', NULL, 'img/category/speakers.jpg'),
(6, 'Smart Watches', NULL, 'img/category/smartwatches.jpg'),
(7, 'TVs', NULL, 'img/category/tvs.jpg'),
(8, 'Computer Accessories', NULL, 'img/category/comp_access.jpg'),
(9, 'Diecast Toy Vehicles', NULL, 'img/category/diecast_toy.jpg'),
(10, 'Action Figures', NULL, 'img/category/action_figures.jpg'),
(11, 'Normal Laptops', NULL, 'img/category/normal_laptops.jpg'),
(12, 'Gaming Laptops', NULL, 'img/category/gaming_laptops.jpg'),
(13, 'Normal TVs', NULL, 'img/category/normal_tv.jpg'),
(14, 'Smart TVs', NULL, 'img/category/smart_tv.jpg'),
(15, 'Subwoofers', NULL, 'img/category/subwoofers.jpg'),
(16, 'Outdoor Speakers', NULL, 'img/category/outdoor_speakers1.jpg'),
(17, 'Android Phones', NULL, 'img/category/android_phones.jpg'),
(18, 'iOS Phones', NULL, 'img/category/ios_phones.jpg'),
(19, 'LCD TVs', NULL, 'img/category/lcd_tv.jpg'),
(20, 'LED TVs', NULL, 'img/category/led_tv.jpg'),
(21, 'Plasma TVs', NULL, 'img/category/plasma_tv.jpg'),
(22, 'Toy Vehicles', NULL, 'img/category/toy_vehicles.jpg'),
(23, 'Ride On Toy Vehicles', NULL, 'img/category/ride_on_toys.jpg'),
(24, 'Remote Control Vehicles', NULL, 'img/category/remote_control.jpg');

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

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`courier_id`, `email`, `first_name`, `last_name`) VALUES
(1, 'courier1@example.com', 'cour1', 'courlast'),
(2, 'courier2@example.com', 'cour2', 'cour2last');

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
(16, 'Crowley', 'Stanford'),
(17, 'Gary', 'Benson');

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
  `current_location` varchar(20) DEFAULT NULL,
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

INSERT INTO `deliveries` (`order_id`, `courier_id`, `delivery_method`, `tracking_info`, `current_location`, `estimated_date`, `completed_date`, `status`, `customer_contact`, `house_number`, `street`, `city`, `state`, `zip_code`) VALUES
(1, 1, 'delivery', '1546902000_856740', NULL, '2019-08-22', '2019-08-21', 'delivered', '0765438902', 148, 'Venenatis St.', 'Glen Haven', 'Nevada', '76891'),
(2, 1, 'delivery', '1548316102_956471', NULL, '2018-08-31', '2019-08-31', 'delivered', '0724561093', 46, 'Euismod Av', 'Paia', 'Vermont', '84684'),
(3, NULL, 'store_pickup', '1549266502_539338 ', NULL, '2019-09-15', '2019-09-18', 'delivered', '0718854544', NULL, NULL, NULL, NULL, NULL),
(4, 2, 'delivery', '1550606109_751261 ', NULL, '2019-10-06', '2019-10-04', 'delivered', '0756129943', 108, 'Cursus. Road', 'Exeter', 'Michigan', '22087'),
(5, 1, 'delivery', '1552649373_480553 ', NULL, '2019-10-17', '2019-10-18', 'delivered', '0775553081', 16, 'Aenean Street', 'Roxboro', 'Alabama', '63402'),
(6, 2, 'delivery', '1554178202_913785', NULL, '2019-10-28', '2019-10-27', 'delivered', '0712340951', 148, 'Venenatis St.', 'Glen Haven', 'Nevada', '76891'),
(7, 2, 'delivery', '1554757112_150314 ', NULL, '2019-11-16', '2019-11-19', 'delivered', '0718854544', 6, 'Quam Street', 'Rowley', 'Alaska', '29510'),
(8, NULL, 'store_pickup', '1556281712_333568', NULL, '2019-11-24', '2019-12-02', 'delivered', '0756129943', NULL, NULL, NULL, NULL, NULL),
(9, 1, 'delivery', '1557756464_920138', NULL, '2019-12-12', '2019-12-12', 'delivered', '0782341887', 89, 'Euismod Av.', 'Roccasicura', 'Indiana', '33810'),
(10, NULL, 'store_pickup', '1560674838_446071', NULL, '2019-12-18', '2019-12-18', 'delivered', '0702226953', NULL, NULL, NULL, NULL, NULL),
(24, 1, 'delivery', '5e0c55d40c245_761106', NULL, '2020-01-11', NULL, 'delivered', '0714861225', 77, 'Loften Avenue', 'Philedelphia', 'Pennsylvania', '45107'),
(28, NULL, 'store_pickup', '5e0c652880256_307699', NULL, '2020-01-09', NULL, 'in-progress', '0778963295', NULL, NULL, NULL, NULL, NULL),
(29, 2, 'delivery', '5e0ca097c5710_674301', NULL, '2020-01-11', NULL, 'in-progress', '0712789301', 75, 'Lorem Rd', 'Zuni', 'Rhode Island', '87771'),
(30, NULL, 'delivery', '5e0d73bc5314b_111510', NULL, '2020-01-12', NULL, 'in-progress', '0714861225', 77, 'Loften Avenue', 'Philedelphia', 'Pennsylvania', '45107');

-- --------------------------------------------------------

--
-- Table structure for table `guest_customers`
--

CREATE TABLE `guest_customers` (
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guest_customers`
--

INSERT INTO `guest_customers` (`customer_id`) VALUES
(17);

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
(1, '2019-08-14', 3, 0),
(2, '2019-08-23', 7, 0),
(3, '2019-09-10', 4, 0),
(4, '2019-09-25', 1, 0),
(5, '2019-10-07', 9, 0),
(6, '2019-10-20', 3, 0),
(7, '2019-11-08', 4, 0),
(8, '2019-11-19', 1, 0),
(9, '2019-12-04', 7, 0),
(10, '2019-12-15', 2, 0),
(11, '2019-12-19', 10, 0),
(12, '2019-12-20', 3, 0),
(13, '2019-12-23', 7, 0),
(14, '2019-12-24', 8, 0),
(15, '2019-12-28', 4, 0),
(24, '2019-10-06', 15, 0),
(28, '2019-10-21', 17, 0),
(29, '2019-11-14', 1, 0),
(30, '2020-01-02', 15, 0);

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
(24, 7, 18, 3),
(24, 2, 13, 4),
(24, 5, 5, 2),
(24, 6, 6, 1),
(28, 12, 27, 2),
(29, 10, 10, 2),
(29, 14, 33, 1),
(11, 20, 45, 2),
(11, 15, 35, 1),
(11, 19, 43, 1),
(30, 2, 2, 1),
(30, 11, 24, 2),
(30, 7, 23, 2);

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
(24, 'card', '1038.56', '1425 7842 8246 3924'),
(28, 'cash', '288.00', NULL),
(29, 'card', '191.00', '1073 4497 2966 7215'),
(30, 'card', '546.00', '1587 4565 9782 1568');

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
(1, 'SAMSUNG_S10', 'Samsung', 'samsung-s10-1.jpg'),
(2, 'ACER_ASPIRE_F15', 'ACER', 'acer-aspire-f15.jpeg'),
(3, 'HP Elite Dragonfly', 'HP', 'hp-elitebook-dragonfly-01.jpg'),
(4, 'HP Zbook 15u G5', 'HP', 'customize.jpeg'),
(5, 'SONY XB402M Extra Bass', 'SONY', '81+UoKhBNPL._SX679_.jpg'),
(6, 'Plasma TV-TH27391YT', 'Panasonic', 'td-500x500.jpg'),
(7, 'Huawei P9', 'Huawei', '71+-S48Hx1L._AC_SX425_.jpg'),
(8, 'ACER Chromebook Spin511', 'ACER', '1548277946_chromebook_spin.jpg'),
(9, 'ACER Nitro 7', 'ACER', '71PUCl5W8XL._SX466_.jpg'),
(10, 'SONY GTK-PG10 Outdoor Speaker', 'SONY', '71PFd1oeF-L._AC_SX466_.jpg'),
(11, 'iPhone X', 'Apple', 'iPhoneX-silver-1.jpg'),
(12, 'ASUS Predator 701', 'ASUS', '41QveeKrBGL._AC_SY400_ML2_.jpg'),
(13, 'Samsung Gear S3 Frontier Smartwatch', 'Samsung', '59a880408457ae030239890c-big__17560.1566410479.jpg'),
(14, 'Mercedes C63S Kids Ride-on Car', 'Unbranded', 'IMG_5410-1.jpg'),
(15, 'Monster Jam Mini Pack', 'Hot Wheels', '712pOzhfOiL._AC_SX425_.jpg'),
(16, 'Xiaomi mi band 4 BT5.0 Standard Edition', 'Xiaomi', 's-l300.jpg'),
(17, 'LG Premier 2.0 Smart TV ', 'LG', 'G_L_940x620.jpg'),
(18, 'Lego Marvel Avengers Minifigures', 'Lego', 's-l300 (1).jpg'),
(19, 'Technic RC Remote Control Racing Car', 'Lego', '2019-SEMBO-Technic-RC-remote-control-car-toy-Building-Blocks-model-Kit-F1-formula-Racing-Car.jpg'),
(20, 'Sony Smart Band SWR30', 'SONY', 's-l30022.jpg');

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
(1, 'johnfelix145@example.com', '$2y$10$AtwE5nzXJSXTOg6uwtLkRu317OAFue.U7biPgvT.AXCZQMwrsd9gK', 75, 'Lorem Rd', 'Zuni', 'Rhode Island', '87771'),
(2, 'samhoward@example.com', '$2y$10$evVCkGUvD5Vm/ithaZK.WOavVa52ptCPFR/8rvVn43KbNPxp/JfvC', 19, 'Nascetur Ave', 'Housten', 'Texas', '32164'),
(3, 'peterjenkins@example.com', '$2y$10$QX/BXpgMhs48Ayh3S59jSuxxSqh04kvQhliGHWYBbzFOwAoUjW0nW', 148, 'Venenatis St.', 'Glen Haven', 'Nevada', '76891'),
(4, 'alicesummer@example.com', '$2y$10$iCO.zsH1lWd7y7.xlJB9o.MPQ9pEqV.Ohyrw16Sa155gqgm.amRyW', 6, 'Quam Street', 'Rowley', 'Alaska', '29510'),
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
(1, 1, '345-298-2xx', '456.300', '84.76', 40),
(2, 2, '988cjj2ka', '2314.830', '138.00', 25),
(3, 3, '6ty-8729-vb45', '1875.270', '104.00', 14),
(4, 4, '80uy-bjdc3-j41nk', '1772.400', '122.00', 22),
(5, 5, 'bfehi-b72bq-72n9n', '420.500', '72.00', -2),
(6, 6, 'jhwd810-bjsc821', '2651.350', '88.56', -1),
(7, 7, 'chi9nw81-83nef9', '322.845', '82.00', 16),
(8, 8, 'hskq01-nsckh12-15db71', '1681.620', '103.00', 24),
(9, 9, 'aplm23-maqp12-pzw6v', '2027.000', '99.00', 0),
(10, 10, '6489anco', '3401.780', '52.00', -2),
(11, 11, '80qpz2-bcsu310', '486.500', '108.00', 0),
(12, 12, 'qa3-op7-xs2-l7ww', '1956.491', '149.00', 0),
(2, 13, '87ryjhxs923', '2730.100', '140.00', -1),
(3, 14, '82u-y17s-hd81', '1772.041', '115.00', 23),
(4, 15, '80uy-j27bj4-sj82', '1449.000', '123.00', 7),
(5, 16, 'bfgr7-ncsu91-nfei82n', '420.500', '77.00', 10),
(6, 17, 'jsghkqh8-bsc6714', '1945.580', '68.40', 0),
(7, 18, 'hwjhla92-ns882', '322.845', '82.00', 19),
(8, 19, 'nzc23-ml71q-lpoae4', '1558.410', '102.00', 0),
(9, 20, 'qb29npa-1hakno-aki1010', '2117.450', '98.00', 0),
(11, 21, 'nd901-za10lo6', '486.500', '108.00', 0),
(4, 22, '80uy-vhg27b-b763b', '1832.973', '116.00', 0),
(7, 23, 'nkdskj81-aazw2', '345.100', '93.00', 30),
(11, 24, '801aer-mpq012', '495.120', '111.00', -2),
(7, 25, 'balpq953-nzka12', '345.100', '93.00', 0),
(11, 26, 'pmxd87-sevm25', '496.720', '111.00', 0),
(12, 27, 's2i-qp1-b23-ga3e', '1872.410', '144.00', -4),
(13, 28, 'sgu82-fwx92', '84.390', '51.99', 0),
(13, 29, 'sgq05-am54d', '85.830', '54.20', 0),
(13, 30, 'sg4r9-e2ui8', '85.830', '52.78', 0),
(13, 31, 'sg3h2-6ciq0', '84.390', '51.99', 0),
(14, 32, 'w107y-jz34-33e', '5883.900', '87.00', 0),
(14, 33, 'w204m-6y2y-dr9', '5883.900', '87.00', -1),
(15, 34, 'up90zxx2ert', '825.910', '42.00', 0),
(15, 35, 'uq34axks431', '1022.350', '45.00', 0),
(16, 36, 'XM21qw-e56yzkj', '72.936', '22.00', 0),
(16, 37, 'XM4t6q3-niq981', '72.936', '22.00', 0),
(17, 38, '77yu3-8qzm0-pq3xm', '1332.860', '58.20', 15),
(17, 39, '77de1-z56mef-904bv', '1445.900', '60.40', 12),
(17, 40, '78w3j-i3c70-lwl27', '1422.000', '60.40', 0),
(18, 41, 'qpl32xc-33uqnmb', '225.500', '13.00', 30),
(18, 42, '9os7w1-w12xmb', '275.000', '16.00', 20),
(19, 43, 'wpl00-zam34', '448.640', '29.99', 8),
(20, 44, 'bwcdu89320', '122.450', '25.48', 18),
(20, 45, 'nadkj92012', '122.450', '25.48', 22),
(20, 46, 'xwklj87220', '122.450', '25.48', 20),
(20, 47, 'rnscaj12853', '122.450', '25.48', 19);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
