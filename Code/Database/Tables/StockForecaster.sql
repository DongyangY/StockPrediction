-- phpMyAdmin SQL Dump
-- version 4.3.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 30, 2015 at 01:29 AM
-- Server version: 5.6.22
-- PHP Version: 5.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `StockForecaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `AIANN`
--

CREATE TABLE IF NOT EXISTS `AIANN` (
  `Date` varchar(50) NOT NULL,
  `Total` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AIBAY`
--

CREATE TABLE IF NOT EXISTS `AIBAY` (
  `Date` varchar(50) NOT NULL,
  `Total` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AISTS`
--

CREATE TABLE IF NOT EXISTS `AISTS` (
  `Date` varchar(50) NOT NULL,
  `Total` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AISVM`
--

CREATE TABLE IF NOT EXISTS `AISVM` (
  `Date` varchar(50) NOT NULL,
  `Total` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LPredictionBayesian`
--

CREATE TABLE IF NOT EXISTS `LPredictionBayesian` (
  `Symbol` varchar(20) NOT NULL,
  `Position` int(11) NOT NULL,
  `ClosePrice` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LPredictionSTS`
--

CREATE TABLE IF NOT EXISTS `LPredictionSTS` (
  `Symbol` varchar(20) NOT NULL,
  `Position` int(11) NOT NULL,
  `ClosePriceTarget` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PredictionANN`
--

CREATE TABLE IF NOT EXISTS `PredictionANN` (
  `Symbol` varchar(20) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `ClosePriceTarget` double NOT NULL,
  `RelativeDifference` double NOT NULL,
  `Action` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PredictionMACD`
--

CREATE TABLE IF NOT EXISTS `PredictionMACD` (
  `Symbol` varchar(20) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `EMAS` double NOT NULL,
  `EMAL` double NOT NULL,
  `DEA` double NOT NULL,
  `DIF` double NOT NULL,
  `Action` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PredictionSVM`
--

CREATE TABLE IF NOT EXISTS `PredictionSVM` (
  `Symbol` varchar(20) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `ClosePriceTarget` double NOT NULL,
  `RelativeDifference` double NOT NULL,
  `Action` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SPredictionBayesian`
--

CREATE TABLE IF NOT EXISTS `SPredictionBayesian` (
  `Symbol` varchar(20) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `ClosePriceTarget0` double NOT NULL,
  `ClosePriceTarget1` double NOT NULL,
  `ClosePriceTarget2` double NOT NULL,
  `RelativeDifference` double NOT NULL,
  `Action` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SPredictionSTS`
--

CREATE TABLE IF NOT EXISTS `SPredictionSTS` (
  `Symbol` varchar(20) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `ClosePriceTarget0` double NOT NULL,
  `ClosePriceTarget1` double NOT NULL,
  `ClosePriceTarget2` double NOT NULL,
  `RelativeDifference` double NOT NULL,
  `Action` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `StockHistorical`
--

CREATE TABLE IF NOT EXISTS `StockHistorical` (
  `Symbol` varchar(20) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `OpenPrice` double NOT NULL,
  `ClosePrice` double NOT NULL,
  `DaysLow` double NOT NULL,
  `DaysHigh` double NOT NULL,
  `Volume` bigint(20) NOT NULL,
  `CloseDifference` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `StockInfo`
--

CREATE TABLE IF NOT EXISTS `StockInfo` (
  `ID` bigint(20) NOT NULL,
  `Symbol` varchar(20) NOT NULL,
  `Fullname` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `StockRealtime`
--

CREATE TABLE IF NOT EXISTS `StockRealtime` (
  `Symbol` varchar(20) NOT NULL,
  `Time` varchar(50) NOT NULL,
  `Price` double NOT NULL,
  `Volume` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TradeRecord`
--

CREATE TABLE IF NOT EXISTS `TradeRecord` (
  `name` varchar(50) NOT NULL,
  `stockName` varchar(50) NOT NULL,
  `amount` double NOT NULL,
  `time` varchar(50) NOT NULL,
  `tradeId` bigint(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `name` varchar(50) NOT NULL,
  `money` double NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `UserStock`
--

CREATE TABLE IF NOT EXISTS `UserStock` (
  `name` varchar(50) NOT NULL,
  `stockName` varchar(50) NOT NULL,
  `amount` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `PredictionANN`
--
ALTER TABLE `PredictionANN`
  ADD PRIMARY KEY (`Symbol`,`Date`);

--
-- Indexes for table `PredictionSVM`
--
ALTER TABLE `PredictionSVM`
  ADD PRIMARY KEY (`Symbol`,`Date`);

--
-- Indexes for table `SPredictionBayesian`
--
ALTER TABLE `SPredictionBayesian`
  ADD PRIMARY KEY (`Symbol`,`Date`);

--
-- Indexes for table `StockHistorical`
--
ALTER TABLE `StockHistorical`
  ADD PRIMARY KEY (`Symbol`,`Date`);

--
-- Indexes for table `StockInfo`
--
ALTER TABLE `StockInfo`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `StockRealtime`
--
ALTER TABLE `StockRealtime`
  ADD PRIMARY KEY (`Symbol`,`Time`);

--
-- Indexes for table `TradeRecord`
--
ALTER TABLE `TradeRecord`
  ADD PRIMARY KEY (`tradeId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `UserStock`
--
ALTER TABLE `UserStock`
  ADD PRIMARY KEY (`name`,`stockName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `TradeRecord`
--
ALTER TABLE `TradeRecord`
  MODIFY `tradeId` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
