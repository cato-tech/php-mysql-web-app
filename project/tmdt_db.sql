-- ============================================
-- DATABASE: tmdt_db
-- Tạo database và toàn bộ bảng
-- ============================================

CREATE DATABASE IF NOT EXISTS `tmdt_db`
  CHARACTER SET utf8
  COLLATE utf8_unicode_ci;

USE `tmdt_db`;

-- ============================================
-- Bảng CONGTY
-- ============================================
CREATE TABLE IF NOT EXISTS `congty` (
  `idcty`    INT(11)      NOT NULL AUTO_INCREMENT,
  `tencty`   VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diachi`   VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dienthoai`VARCHAR(20)  COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax`      VARCHAR(20)  COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idcty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `congty` (`idcty`,`tencty`,`diachi`,`dienthoai`,`fax`) VALUES
(1,'Apple','USA','123456','111'),
(2,'Samsung','Korea','222222','222'),
(3,'Oppo','China','333333','333'),
(4,'Vivo','China','444444','444');

-- ============================================
-- Bảng SANPHAM
-- ============================================
CREATE TABLE IF NOT EXISTS `sanpham` (
  `idsp`    INT(11)      NOT NULL AUTO_INCREMENT,
  `tensp`   VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gia`     FLOAT        DEFAULT NULL,
  `mota`    TEXT         COLLATE utf8_unicode_ci,
  `hinh`    VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `giamgia` FLOAT        DEFAULT 0,
  `idcty`   INT(11)      DEFAULT NULL,
  PRIMARY KEY (`idsp`),
  KEY `idcty` (`idcty`),
  CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`idcty`) REFERENCES `congty` (`idcty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sanpham` (`idsp`,`tensp`,`gia`,`mota`,`hinh`,`giamgia`,`idcty`) VALUES
(1,'iPhone 16',500,'iPhone mới nhất 2024, chip A18, camera 48MP','iphone16.jpg',0,1),
(2,'iPhone 13',130,'iPhone 13, chip A15, màn hình Super Retina XDR','iphone13.jpg',0,1),
(3,'Samsung S23 Ultra',250,'Samsung cao cấp, S Pen, camera 200MP','samsungs23.jpg',10,2),
(4,'Samsung A56',100,'Samsung tầm trung, pin 5000mAh','samsunga56.jpg',10,2),
(5,'Oppo F11',125,'Oppo F11, camera popup, pin 4000mAh','oppof11.jpg',15,3),
(6,'Oppo Reno 5',115,'Oppo Reno 5, sạc nhanh 65W','opporeno5.jpg',15,3),
(7,'Vivo Y03',90,'Vivo Y03, pin trâu, giá rẻ','vivoy03.jpg',5,4);

-- ============================================
-- Bảng KHACHHANG
-- ============================================
CREATE TABLE IF NOT EXISTS `khachhang` (
  `idkh`            INT(11)      NOT NULL AUTO_INCREMENT,
  `email`           VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password`        VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hodem`           VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ten`             VARCHAR(50)  COLLATE utf8_unicode_ci DEFAULT NULL,
  `diachi`          VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diachinhanhang`  VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dienthoai`       VARCHAR(20)  COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idkh`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tài khoản mẫu: email=user@tmdt.com / password=123456
INSERT INTO `khachhang` (`idkh`,`email`,`password`,`hodem`,`ten`,`diachi`,`diachinhanhang`,`dienthoai`) VALUES
(1,'user@tmdt.com','123456','Nguyen Van','A','Ho Chi Minh','123 Nguyen Trai','0901234567');

-- ============================================
-- Bảng DATHANG
-- ============================================
CREATE TABLE IF NOT EXISTS `dathang` (
  `iddh`         INT(11)  NOT NULL AUTO_INCREMENT,
  `idkh`         INT(11)  DEFAULT NULL,
  `ngaydathang`  DATETIME DEFAULT NULL,
  `trangthai`    TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`iddh`),
  KEY `idkh` (`idkh`),
  CONSTRAINT `dathang_ibfk_1` FOREIGN KEY (`idkh`) REFERENCES `khachhang` (`idkh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ============================================
-- Bảng DATHANG_CHITIET
-- ============================================
CREATE TABLE IF NOT EXISTS `dathang_chitiet` (
  `iddh`    INT(11) NOT NULL,
  `idsp`    INT(11) NOT NULL,
  `soluong` INT(11) DEFAULT 1,
  `dongia`  FLOAT   DEFAULT NULL,
  `giamgia` FLOAT   DEFAULT 0,
  PRIMARY KEY (`iddh`,`idsp`),
  KEY `idsp` (`idsp`),
  CONSTRAINT `ct_ibfk_1` FOREIGN KEY (`iddh`) REFERENCES `dathang` (`iddh`),
  CONSTRAINT `ct_ibfk_2` FOREIGN KEY (`idsp`) REFERENCES `sanpham` (`idsp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ============================================
-- Bảng TAIKHOAN (admin)
-- ============================================
CREATE TABLE IF NOT EXISTS `taikhoan` (
  `iduser`   INT(11)     NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` VARCHAR(255)COLLATE utf8_unicode_ci DEFAULT NULL,
  `phanquyen`ENUM('admin','user') COLLATE utf8_unicode_ci DEFAULT 'user',
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `taikhoan` (`username`,`password`,`phanquyen`) VALUES
('admin','admin123','admin');
