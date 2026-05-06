-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 11 Avril 2026 à 15:48
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `tmdt_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `congty`
--

CREATE TABLE `congty` (
  `idcty` int(11) NOT NULL auto_increment,
  `tencty` varchar(100) collate utf8_unicode_ci default NULL,
  `diachi` varchar(255) collate utf8_unicode_ci default NULL,
  `dienthoai` varchar(20) collate utf8_unicode_ci default NULL,
  `fax` varchar(20) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`idcty`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `congty`
--

INSERT INTO `congty` (`idcty`, `tencty`, `diachi`, `dienthoai`, `fax`) VALUES
(1, 'Apple', 'USA', '123456', '111'),
(2, 'Samsung', 'Korea', '222222', '222'),
(3, 'Oppo', 'China', '333333', '333');

-- --------------------------------------------------------

--
-- Structure de la table `sanpham`
--

CREATE TABLE `sanpham` (
  `idsp` int(11) NOT NULL auto_increment,
  `tensp` varchar(100) collate utf8_unicode_ci default NULL,
  `gia` float default NULL,
  `mota` text collate utf8_unicode_ci,
  `hinh` varchar(255) collate utf8_unicode_ci default NULL,
  `giamgia` float default NULL,
  `idcty` int(11) default NULL,
  PRIMARY KEY  (`idsp`),
  KEY `idcty` (`idcty`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `sanpham`
--

INSERT INTO `sanpham` (`idsp`, `tensp`, `gia`, `mota`, `hinh`, `giamgia`, `idcty`) VALUES
(1, 'iPhone 16', 500, 'iPhone mới nhất', 'iphone16.jpg', 0, 1),
(2, 'iPhone 13', 130, 'iPhone mới nhất', 'iphone13.jpg', 0, 1),
(3, 'Samsung S23 ultra', 250, 'Samsung cao cấp', 'samsungs23.jpg', 10, 2),
(4, 'Samsung A56', 100, 'Samsung cao cấp', 'samsunga56.jpg', 10, 2),
(5, 'Oppo F11', 125, 'Oppo cao cấp', 'oppof11.jpg', 15, 3),
(6, 'Oppo RENO 5', 115, 'Oppo cao cấp', 'opporeno5.jpg', 15, 3);

-- --------------------------------------------------------

--
-- Structure de la table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `iduser` int(11) NOT NULL auto_increment,
  `username` varchar(50) collate utf8_unicode_ci default NULL,
  `password` varchar(255) collate utf8_unicode_ci default NULL,
  `hodem` varchar(100) collate utf8_unicode_ci default NULL,
  `ten` varchar(50) collate utf8_unicode_ci default NULL,
  `phanquyen` enum('admin','user') collate utf8_unicode_ci default NULL,
  `landangnhapcuoi` datetime default NULL,
  PRIMARY KEY  (`iduser`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `taikhoan`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`idcty`) REFERENCES `congty` (`idcty`);
