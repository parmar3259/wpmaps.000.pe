-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2023 at 08:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phulkarieva`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartdata`
--

CREATE TABLE `cartdata` (
  `cart_id` int(225) NOT NULL,
  `user_id` int(225) NOT NULL,
  `product_id` int(225) NOT NULL,
  `product_size` varchar(225) NOT NULL,
  `product_color` varchar(225) NOT NULL,
  `product_quantity` int(225) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cartdata`
--

INSERT INTO `cartdata` (`cart_id`, `user_id`, `product_id`, `product_size`, `product_color`, `product_quantity`) VALUES
(83, 26, 2, 'XXL', 'Blue', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(255) NOT NULL,
  `catname` varchar(225) NOT NULL,
  `imgpath` varchar(225) NOT NULL,
  `cat_of_month` varchar(255) NOT NULL,
  `upload_through` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `catname`, `imgpath`, `cat_of_month`, `upload_through`) VALUES
(1, 'T-Shirts', 'https://drive.google.com/file/d/1HS0vFsCqDOR8piGkQzivji15D7hROtoJ/view?usp=drive_link', '', 'json'),
(2, 'Jeans', 'https://drive.google.com/file/d/1-FLec-Kj5yLDf7cQ4I5QjlZV298uhoDC/view?usp=drive_link', '', 'json'),
(3, 'Dresses', 'https://drive.google.com/file/d/1-I10tOzBd24iLV-PROo5AK1yUM_vdVfw/view?usp=drive_link', '', 'json'),
(4, 'Shoes', 'https://drive.google.com/file/d/1-J3j02A6DgBUTAdWuui0qKuJzRxZtWM4/view?usp=drive_link', '', 'json'),
(5, 'Hats', 'https://drive.google.com/file/d/1HS0vFsCqDOR8piGkQzivji15D7hROtoJ/view?usp=drive_link', '', 'json'),
(6, 'Jackets', 'https://drive.google.com/file/d/1HS0vFsCqDOR8piGkQzivji15D7hROtoJ/view?usp=drive_link', '', 'json'),
(7, 'Socks', 'https://drive.google.com/file/d/1-FLec-Kj5yLDf7cQ4I5QjlZV298uhoDC/view?usp=drive_link', '', 'json'),
(8, 'Sweaters', 'https://drive.google.com/file/d/1-I10tOzBd24iLV-PROo5AK1yUM_vdVfw/view?usp=drive_link', '', 'json'),
(9, 'Shorts', 'https://drive.google.com/file/d/1-J3j02A6DgBUTAdWuui0qKuJzRxZtWM4/view?usp=drive_link', '', 'json'),
(10, 'Scarves', 'https://drive.google.com/file/d/1HS0vFsCqDOR8piGkQzivji15D7hROtoJ/view?usp=drive_link', '', 'json');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(225) NOT NULL,
  `fullname` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `roll` varchar(225) NOT NULL,
  `phone_number` bigint(255) DEFAULT NULL,
  `user_address` varchar(225) DEFAULT NULL,
  `user_address2` varchar(225) DEFAULT NULL,
  `user_city` varchar(225) DEFAULT NULL,
  `city_zipcode` bigint(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `fullname`, `email`, `password`, `roll`, `phone_number`, `user_address`, `user_address2`, `user_city`, `city_zipcode`) VALUES
(26, 'hardik parmar', 'hardik23259@gmail.com', '$2y$10$j7XFoeR3KE5NUlRhtMSfJ.cHg9IBRZQm7APL36O846ajovM5BozF2', 'admin', NULL, NULL, NULL, NULL, NULL),
(27, 'hardik parmar', 'admin@gmail.com', '$2y$10$BCFnQWQwSvCQdyATuQ5uYez47V76ff1Ch.SItVaAHynyp5ihRV11e', 'admin', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(225) NOT NULL,
  `user_id` int(225) NOT NULL,
  `user_email` varchar(225) NOT NULL,
  `invoice_id` int(225) NOT NULL,
  `cart_data` mediumtext NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(225) NOT NULL,
  `product_name` varchar(225) NOT NULL,
  `product_brand` varchar(255) NOT NULL,
  `category_name` varchar(225) NOT NULL,
  `size_option` varchar(225) NOT NULL,
  `product_size` varchar(225) NOT NULL,
  `product_rate` int(225) NOT NULL,
  `product_color` varchar(225) DEFAULT NULL,
  `product_description` varchar(5000) NOT NULL,
  `product_Specification` varchar(2556) NOT NULL,
  `product_image_path` varchar(225) NOT NULL,
  `upload_through` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_brand`, `category_name`, `size_option`, `product_size`, `product_rate`, `product_color`, `product_description`, `product_Specification`, `product_image_path`, `upload_through`) VALUES
(3, 'Product 3', 'Brand A', 'Shoes', 'digit', '8', 15, 'Green', 'Description for Product 3', 'Specification for Product 3', 'https://drive.google.com/file/d/1-FLec-Kj5yLDf7cQ4I5QjlZV298uhoDC/view?usp=drive_link', 'json'),
(4, 'Product 4', 'Brand C', 'Jeans', 'digit', '12', 25, 'Yellow', 'Description for Product 4', 'Specification for Product 4', 'https://drive.google.com/file/d/1-FLec-Kj5yLDf7cQ4I5QjlZV298uhoDC/view?usp=drive_link', 'json'),
(5, 'Product 5', 'Brand B', 'Shoes', 'roman', 'XL,C,L,S,XXL', 35, 'Purple', 'Description for Product 5', 'Specification for Product 5', 'https://drive.google.com/file/d/1-FLec-Kj5yLDf7cQ4I5QjlZV298uhoDC/view?usp=drive_link', 'json'),
(6, 'hardik parmar', 'asd qc3w', 'Jackets', 'digit', '23,345,657', 9875, 'blue', 'asdad', 'asdsad', './assets/uploads/products/shirt.jpg', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartdata`
--
ALTER TABLE `cartdata`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartdata`
--
ALTER TABLE `cartdata`
  MODIFY `cart_id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
