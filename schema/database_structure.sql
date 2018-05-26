/*
 Navicat Premium Data Transfer

 Source Server         : azuremysql
 Source Server Type    : MySQL
 Source Server Version : 50626
 Source Host           : evi-inventory.mysql.database.azure.com:3306
 Source Schema         : evi_inventory

 Target Server Type    : MySQL
 Target Server Version : 50626
 File Encoding         : 65001

 Date: 13/12/2017 14:51:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for borrowed_inventory
-- ----------------------------
DROP TABLE IF EXISTS `borrowed_inventory`;
CREATE TABLE `borrowed_inventory`  (
  `Borrowed_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Borrower_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Inventory_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Purposed` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Location` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Borrowed_Date` date NOT NULL,
  `Quantities` int(11) NOT NULL,
  `Completeness` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Borrowed_Photo` mediumblob NOT NULL,
  `Agreement_Letter` mediumblob NOT NULL,
  `Remark` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`Borrowed_ID`) USING BTREE,
  INDEX `Evi_Indentifier`(`Inventory_ID`) USING BTREE,
  INDEX `Borrower_ID`(`Borrower_ID`) USING BTREE,
  CONSTRAINT `borrowed_inventory_ibfk_1` FOREIGN KEY (`Inventory_ID`) REFERENCES `inventory` (`Inventory_ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `borrowed_inventory_ibfk_2` FOREIGN KEY (`Borrower_ID`) REFERENCES `worker` (`KTP/ID`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department`  (
  `Department_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Job_Division` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Parent` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Office` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`Department_ID`) USING BTREE,
  INDEX `department_ibfk_3`(`Parent`) USING BTREE,
  INDEX `department_ibfk_1`(`Job_Division`) USING BTREE,
  INDEX `department_ibfk_2`(`Office`) USING BTREE,
  CONSTRAINT `department_ibfk_1` FOREIGN KEY (`Job_Division`) REFERENCES `division` (`Division_Name`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `department_ibfk_2` FOREIGN KEY (`Office`) REFERENCES `office` (`Office_ID`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'One office can have more departments/Division' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for division
-- ----------------------------
DROP TABLE IF EXISTS `division`;
CREATE TABLE `division`  (
  `Division_Name` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Function` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`Division_Name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'detail info of job division, where one office can have many division and vice versa.' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for document
-- ----------------------------
DROP TABLE IF EXISTS `document`;
CREATE TABLE `document`  (
  `Document_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Document_Category` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Received_Date` date NULL DEFAULT NULL,
  `To_Department` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Document_No` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Document_Date` date NULL DEFAULT NULL,
  `Sender` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Recipient` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `CC` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Subject` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Used_for` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Summary` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Image` mediumblob NULL,
  `Remark` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Created_Date` datetime(0) NULL DEFAULT NULL,
  `Created_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Modified_Date` datetime(0) NULL DEFAULT NULL,
  `Modified_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Document_ID`) USING BTREE,
  INDEX `Document_Category`(`Document_Category`) USING BTREE,
  CONSTRAINT `document_ibfk_1` FOREIGN KEY (`Document_Category`) REFERENCES `document_category` (`Name`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for document_attachment
-- ----------------------------
DROP TABLE IF EXISTS `document_attachment`;
CREATE TABLE `document_attachment`  (
  `Attachment_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Attachment_Category` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Order_Number` int(11) NOT NULL DEFAULT 1,
  `Attachment_From` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `File` mediumblob NOT NULL,
  `Summary` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Created_Date` datetime(0) NULL DEFAULT NULL,
  `Created_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Modified_Date` datetime(0) NULL DEFAULT NULL,
  `Modified_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Remark` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`Attachment_ID`) USING BTREE,
  INDEX `Attachment_Category`(`Attachment_Category`) USING BTREE,
  INDEX `Attachment_from`(`Attachment_From`) USING BTREE,
  CONSTRAINT `document_attachment_ibfk_1` FOREIGN KEY (`Attachment_Category`) REFERENCES `document_category` (`Name`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `document_attachment_ibfk_2` FOREIGN KEY (`Attachment_from`) REFERENCES `document` (`Document_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for document_category
-- ----------------------------
DROP TABLE IF EXISTS `document_category`;
CREATE TABLE `document_category`  (
  `Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Example` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`Name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for employment
-- ----------------------------
DROP TABLE IF EXISTS `employment`;
CREATE TABLE `employment`  (
  `Display_Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`Display_Name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for inventory
-- ----------------------------
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory`  (
  `Inventory_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'This is Evi Identifier that gives by AEConsult',
  `Serial/ID_Number` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'This is for IMEI and Serial number if it is have',
  `Item_Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Make/model` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Department` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Storage_Location` int(11) NULL DEFAULT NULL,
  `Storage_Room` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Date_Purchased` date NOT NULL,
  `Where_Purchased` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Purchase_Price` decimal(30, 0) NOT NULL,
  `Item_Condition` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Quantities` int(255) NULL DEFAULT NULL,
  `All_Complete` enum('Yes','No') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Photo` mediumblob NOT NULL,
  `Completeness` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Completeness_Photo` mediumblob NOT NULL,
  `Created_Date` datetime(0) NULL DEFAULT NULL,
  `Created_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Modified_Date` datetime(0) NULL DEFAULT NULL,
  `Modified_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Remark` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Validation_Status` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`Inventory_ID`) USING BTREE,
  INDEX `Inv_department_idx`(`Department`) USING BTREE,
  INDEX `Validation_Status`(`Validation_Status`) USING BTREE,
  INDEX `Storage_Location`(`Storage_Location`) USING BTREE,
  INDEX `Item_Condition_idx`(`Item_Condition`) USING BTREE,
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department` (`Department_ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`Item_Condition`) REFERENCES `inventory_condition` (`Name`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`Validation_Status`) REFERENCES `inventory_validation_status` (`ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `inventory_ibfk_4` FOREIGN KEY (`Storage_Location`) REFERENCES `inventory_location` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for inventory_category
-- ----------------------------
DROP TABLE IF EXISTS `inventory_category`;
CREATE TABLE `inventory_category`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category_Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Formating_Identity` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Example` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for inventory_completeness
-- ----------------------------
DROP TABLE IF EXISTS `inventory_completeness`;
CREATE TABLE `inventory_completeness`  (
  `Completeness_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Parent_Inventories` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ID/Serial_Number` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Item_Condition` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Photo` mediumblob NULL,
  `Created_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Created_Date` datetime(0) NULL DEFAULT NULL,
  `Modified_Date` datetime(0) NULL DEFAULT NULL,
  `Modified_By` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Validation_Status` int(11) NOT NULL DEFAULT 0,
  `Remark` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`Completeness_ID`) USING BTREE,
  INDEX `Parrent_Inventories`(`Parent_Inventories`) USING BTREE,
  INDEX `Item_Condition`(`Item_Condition`) USING BTREE,
  CONSTRAINT `inventory_completeness_ibfk_2` FOREIGN KEY (`Parent_Inventories`) REFERENCES `inventory` (`Inventory_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventory_completeness_ibfk_3` FOREIGN KEY (`Item_Condition`) REFERENCES `inventory_condition` (`Name`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for inventory_condition
-- ----------------------------
DROP TABLE IF EXISTS `inventory_condition`;
CREATE TABLE `inventory_condition`  (
  `Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`Name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for inventory_location
-- ----------------------------
DROP TABLE IF EXISTS `inventory_location`;
CREATE TABLE `inventory_location`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Parent_Location` int(11) NULL DEFAULT NULL,
  `Nearest_Office` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Location_Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Province` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Region` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `City` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Street` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `ZIP` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MapCoordinate` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `Parent_Location`(`Parent_Location`) USING BTREE,
  INDEX `Nearest_Office`(`Nearest_Office`) USING BTREE,
  CONSTRAINT `inventory_location_ibfk_1` FOREIGN KEY (`Parent_Location`) REFERENCES `inventory_location` (`ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `inventory_location_ibfk_2` FOREIGN KEY (`Nearest_Office`) REFERENCES `office` (`Office_ID`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for inventory_validation_status
-- ----------------------------
DROP TABLE IF EXISTS `inventory_validation_status`;
CREATE TABLE `inventory_validation_status`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for mail_option
-- ----------------------------
DROP TABLE IF EXISTS `mail_option`;
CREATE TABLE `mail_option`  (
  `Active` tinyint(1) NOT NULL DEFAULT 0,
  `Display_Name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Host` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Port` int(11) NOT NULL,
  `User_Name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Encryption` enum('ssl','tls','','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'ssl',
  PRIMARY KEY (`User_Name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for office
-- ----------------------------
DROP TABLE IF EXISTS `office`;
CREATE TABLE `office`  (
  `Office_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Awesome_Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ZIP` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Province` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Region` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `City` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Street` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Address` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Phone 1` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Phone 2` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `MapCoordinate` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Latitude, Longitude',
  PRIMARY KEY (`Office_ID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for returned_inventory
-- ----------------------------
DROP TABLE IF EXISTS `returned_inventory`;
CREATE TABLE `returned_inventory`  (
  `Returned_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Borrowed_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Reported_Staff_ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Receiver (yang menerima saat mengembalikan)',
  `Returned_Date` date NOT NULL,
  `Item_Condition` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Returned_Photo` mediumblob NOT NULL,
  `Remark` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`Returned_ID`) USING BTREE,
  INDEX `Borrowed_ID`(`Borrowed_ID`) USING BTREE,
  INDEX `Reported_Staff_ID`(`Reported_Staff_ID`) USING BTREE,
  INDEX `Item_Condition`(`Item_Condition`) USING BTREE,
  CONSTRAINT `returned_inventory_ibfk_1` FOREIGN KEY (`Borrowed_ID`) REFERENCES `borrowed_inventory` (`Borrowed_ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `returned_inventory_ibfk_2` FOREIGN KEY (`Reported_Staff_ID`) REFERENCES `worker` (`KTP/ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `returned_inventory_ibfk_3` FOREIGN KEY (`Item_Condition`) REFERENCES `inventory_condition` (`Name`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting`  (
  `Key_Name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Value` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for thumbnail
-- ----------------------------
DROP TABLE IF EXISTS `thumbnail`;
CREATE TABLE `thumbnail`  (
  `Row_ID` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Table_Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Column_Name` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Content` mediumblob NULL,
  PRIMARY KEY (`Row_ID`, `Table_Name`, `Column_Name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `KTP/ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Token for user account verification or user password reset.',
  `user_status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = OK, 1 = Account verification required, 2 = Password reset requested.',
  PRIMARY KEY (`User_ID`) USING BTREE,
  INDEX `KTP/ID`(`KTP/ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user_perms
-- ----------------------------
DROP TABLE IF EXISTS `user_perms`;
CREATE TABLE `user_perms`  (
  `User_ID` int(20) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `perm_name` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`User_ID`, `page_name`, `perm_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for worker
-- ----------------------------
DROP TABLE IF EXISTS `worker`;
CREATE TABLE `worker`  (
  `KTP/ID` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Staff_Name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Date_of_birth` date NULL DEFAULT NULL,
  `Gender` enum('Male','Female') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Number` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Photo` mediumblob NOT NULL,
  `KTP_Photo` mediumblob NOT NULL,
  `Department` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Employment` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Employment/Function/Holder/Position',
  PRIMARY KEY (`KTP/ID`) USING BTREE,
  INDEX `Employment_idx`(`Employment`) USING BTREE,
  INDEX `Department_idx`(`Department`) USING BTREE,
  CONSTRAINT `worker_ibfk_1` FOREIGN KEY (`Employment`) REFERENCES `employment` (`Display_Name`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `worker_ibfk_2` FOREIGN KEY (`Department`) REFERENCES `department` (`Department_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- View structure for inventory_loans_condition
-- ----------------------------
DROP VIEW IF EXISTS `inventory_loans_condition`;
CREATE ALGORITHM = UNDEFINED DEFINER = `admininventory`@`%` SQL SECURITY DEFINER VIEW `inventory_loans_condition` AS select DISTINCT i.*,b.`Borrower_ID`, IF (ISNULL( r.`Returned_ID`), 'Borrowed' , 'Returned') AS 'Loan_Condition', IF (ISNULL( r.`Returned_ID`), b.`Borrowed_ID` , r.`Returned_ID`) AS 'Condition_ID' FROM `inventory` AS i INNER JOIN `borrowed_inventory` AS b ON i.`Inventory_ID` = b.`Inventory_ID` left JOIN `returned_inventory` AS r ON r.`Borrowed_ID` = b.`Borrowed_ID` 

-- ----------------------------
-- Function structure for url_encode
-- ----------------------------
DROP FUNCTION IF EXISTS `url_encode`;
delimiter ;;
CREATE DEFINER=`admininventory`@`%` FUNCTION `url_encode`(s varchar(4096)) RETURNS varchar(4096) CHARSET latin1
    READS SQL DATA
    DETERMINISTIC
BEGIN
	#Routine body goes here...
DECLARE c VARCHAR(4096) DEFAULT '';
       DECLARE pointer INT DEFAULT 1;
       DECLARE s2 VARCHAR(4096) DEFAULT '';
 
       IF ISNULL(s) THEN
           RETURN NULL;
       ELSE
       SET s2 = '';
       WHILE pointer <= length(s) DO
          SET c = MID(s,pointer,1);
          IF c = ' ' THEN
             SET c = '+';
          ELSEIF NOT (ASCII(c) BETWEEN 48 AND 57 OR
                ASCII(c) BETWEEN 65 AND 90 OR
                ASCII(c) BETWEEN 97 AND 122) THEN
             SET c = concat("%",LPAD(CONV(ASCII(c),10,16),2,0));
          END IF;
          SET s2 = CONCAT(s2,c);
          SET pointer = pointer + 1;
       END while;
       END IF;
       RETURN s2;
       
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
