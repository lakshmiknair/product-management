-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2021 at 03:07 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `products_mgmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(300) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(15,4) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_price`, `product_quantity`, `product_image`) VALUES
(18, 'Echo Dot (3rd Gen) - Smart speaker with Alexa - Charcoal', 'Meet Echo Dot - Our most popular smart speaker with a fabric design. It is our most compact smart speaker that fits perfectly into small spaces.', '39.9900', 2, 0x31363235383733323034363032323335373432666630642e6a7067),
(19, 'Ring Video Doorbell – 1080p HD video, improved motion detection, easy installation – Satin Nickel (2020 release)', '1080p HD video doorbell with enhanced features that let you see, hear, and speak to anyone from your phone, tablet, or PC.', '99.9900', 3, 0x353131303137373135363032323335366339383665332e6a7067),
(20, 'Echo Dot (3rd Generation) - Sandstone with 2 Smart Bulb Kit by Sengled', 'This bundle contains the Echo Dot (3rd Generation) and the Element Classic by Sengled Starter Kit.', '75.9900', 1, 0x363036353730303030363032323337653431663036662e6a7067),
(21, 'Blink Mini – Compact indoor plug-in smart security camera, 1080 HD video, night vision, motion detection, two-way audio, Works with Alexa – 1 camera', '1080P HD indoor, plug-in security camera with motion detection and two way audio that lets you monitor the inside of your home day and night.', '34.9900', 2, 0x353439363138313335363032323335653964363633392e6a7067),
(22, 'Echo Show 8 Adjustable Stand - Black', 'Simple and secure magnetic attachment to Echo Show 8. Easily tilt forward or backward to improve viewing angle.\r\n', '24.9900', 3, 0x393535353832323938363032323336363839643039342e6a7067);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
