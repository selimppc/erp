-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2014 at 08:01 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ur`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `pr_create_permission_reports`(IN `p_report_id` int)
BEGIN
	DECLARE done INT DEFAULT 0;
	DECLARE c_username  varchar(100);
	DECLARE c_rol_id  int(11);

  DECLARE cur1 CURSOR FOR SELECT username FROM tbl_users; 
	DECLARE cur2 CURSOR FOR SELECT rol_id FROM tbl_roles; 
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;

  OPEN cur1; 
	REPEAT
    FETCH cur1 INTO c_username; 
		IF NOT done THEN
			INSERT INTO tbl_reports_permissions(username, report_id, insert_, edit, delete_, view_) 
				VALUES (c_username, p_report_id, 0, 0, 0, 1); 
			
		END IF;
  UNTIL done END REPEAT;
	CLOSE cur1;	

	SET done = 0;
	OPEN cur2; 
	REPEAT
		FETCH cur2 INTO c_rol_id;    
		IF NOT done THEN   
			INSERT INTO tbl_reports_permissions_roles(rol_id, report_id, insert_, edit, delete_, view_) 
				VALUES (c_rol_id, p_report_id, 0, 0, 0, 1); 
		END IF;
  UNTIL done END REPEAT;
  CLOSE cur2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_im_ConfirmGRN`(p_id INT, p_insertuser VARCHAR(50))
BEGIN
	DECLARE vImNumber VARCHAR(50);
	DECLARE vStoreCur VARCHAR(50);
	DECLARE vExchangeRate DECIMAL(20,2);
	
	DECLARE vId INT;
	DECLARE vGrnNumber VARCHAR(50);
	DECLARE vStore VARCHAR(50);
	DECLARE vProCode VARCHAR(50);
	DECLARE vBatchNumber VARCHAR(50);
	DECLARE vExpireDate DATE;
	DECLARE vSupplierId VARCHAR(50);
	DECLARE vRcvQuantity INT;
	DECLARE vUnit VARCHAR(50);
	DECLARE vRate DECIMAL(20,3);
	DECLARE vCurrency VARCHAR(50);
	
	DECLARE No_DATA INT DEFAULT 0;
	
	DECLARE CurGrn CURSOR FOR -- This cursor declare for GRN Table
	SELECT b.id, a.im_grnnumber, a.im_store, b.cm_code, b.im_BatchNumber, b.im_ExpireDate, a.cm_supplierid,
				 b.im_RcvQuantity*b.im_unitqty AS Quantity, ROUND(b.im_costprice/b.im_unitqty,3) AS CostPrice, a.im_currency
	FROM im_grnheader a 
	INNER JOIN im_grndetail b ON a.im_grnnumber=b.im_grnnumber
	WHERE a.id=p_id AND a.im_status='Open'; -- Declaration close
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET NO_DATA=-2;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET NO_DATA=-1;
	
	OPEN CurGrn; /******Cursor open here**********/
	FETCH FROM CurGrn INTO vId, vGrnNumber, vStore, vProCode, vBatchNumber, vExpireDate, vSupplierId, vRcvQuantity, vRate, vCurrency;
	WHILE No_DATA=0 DO -- 1
		SELECT cm_stkunit INTO vUnit FROM cm_productmaster WHERE cm_code=vProCode;
		SELECT Fu_GetTrn('Im Transaction','PR--',6,1) INTO vImNumber;
		
		INSERT INTO im_transaction
		(im_number, cm_code, im_storeid, im_BatchNumber, im_date, im_ExpireDate, im_quantity, im_sign, im_unit, 
		 im_rate, im_totalprice, im_RefNumber, im_RefRow, im_note, im_status,cm_supplierid, im_currency, inserttime, insertuser)
		VALUES
		(vImNumber, vProCode, vStore, vBatchNumber, CURRENT_DATE, vExpireDate, vRcvQuantity, 1, vUnit, 
		 vRate, vRate*vRcvQuantity, vGrnNumber, vId, 'Goods Received From PO', 'Open', vSupplierId, vCurrency, CURRENT_TIMESTAMP, p_insertuser);
		 
	FETCH FROM CurGrn INTO vId, vGrnNumber, vStore, vProCode, vBatchNumber, vExpireDate, vSupplierId, vRcvQuantity, vRate, vCurrency;
	END WHILE; -- 1
	CLOSE CurGrn;
	
	UPDATE im_grnheader SET im_status='Confirmed' WHERE id=p_id;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_im_CreateGRN`(p_id INT,p_username VARCHAR(50))
BEGIN
		DECLARE vGrnNumber VARCHAR(50);
		
		SELECT Fu_GetTrn('GRN Number','GRN-',6,1) INTO vGrnNumber;
		
		INSERT INTO im_GrnHeader(im_grnnumber,im_purordnum,im_date,cm_supplierid,pp_requisitionno,im_payterms,im_store,
														 im_discrate,im_discamt,im_currency,im_amount,im_status,inserttime,insertuser)
		SELECT vGrnNumber,pp_purordnum,CURRENT_DATE,cm_supplierid,pp_requisitionno,pp_payterms,pp_store,pp_discrate,
					 pp_discamt,pp_currency,pp_amount,'Open',CURRENT_TIMESTAMP,p_username 
		FROM pp_purchaseordhd WHERE id=p_id AND pp_status IN('Approved','P-Received');
		
		UPDATE pp_purchaseordhd SET pp_status='GRN Created' WHERE id=p_id;
		
		SELECT pp_purordnum, vGrnNumber FROM pp_purchaseordhd WHERE id=p_id;
		
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_im_invoice`(
	p_id INT,
	p_User VARCHAR(50)
)
BEGIN
	DECLARE v_grnnumber VARCHAR(50);
	DECLARE v_branch VARCHAR(50);
	DECLARE v_itemgroup VARCHAR(50);
	DECLARE v_suppgorup VARCHAR(50);
	DECLARE v_debitamt DECIMAL(20,2);
	DECLARE v_voucher VARCHAR(50);
	DECLARE v_dbacc VARCHAR(50);
	DECLARE v_currency VARCHAR(20);
	DECLARE v_exchange DECIMAL(20,2);
	DECLARE v_acccode VARCHAR(20);
	DECLARE v_acctax VARCHAR(20);
	DECLARE v_taxamt DECIMAL(20,2);
	DECLARE v_netamt DECIMAL(20,2);
	DECLARE v_subacc VARCHAR(50);

	DECLARE NO_DATA INT DEFAULT 0;
	
	DECLARE cur_imgrn CURSOR FOR
	SELECT b.cm_group,d.cm_group,SUM(a.im_rowamount)-SUM(a.im_rowamount)*c.im_discrate/100 AS debitamount
	FROM im_grndetail a
	INNER JOIN im_grnheader c ON a.im_grnnumber=c.im_grnnumber AND c.id=p_id
	INNER JOIN cm_productmaster b ON a.cm_code=b.cm_code
	INNER JOIN cm_suppliermaster d ON c.cm_supplierid=d.cm_supplierid
	GROUP BY b.cm_group;

	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET NO_DATA=-2;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET NO_DATA=-1;
	
	SELECT im_grnnumber,im_store INTO v_grnnumber, v_branch FROM im_grnheader WHERE id=p_id;
	
	SELECT a.cm_currency,b.cm_exchangerate INTO v_currency, v_exchange FROM cm_branchmaster a 
	INNER JOIN cm_branchcurrency b 
	ON a.cm_branch=b.cm_branch AND a.cm_currency=b.cm_currency AND a.cm_branch=v_branch;
	
	SELECT Fu_GetTrn('GL Voucher No','INVC',6,1) INTO v_voucher;
	
	/*Create New Invoice Header */
	INSERT INTO am_voucherheader(am_vouchernumber,am_date,am_referance,am_year,am_period,am_branch,am_note,inserttime,insertuser)
	VALUES(v_voucher,CURRENT_DATE,CONCAT('Invoiced for GRN number ',v_grnnumber),Fu_Year(CURRENT_DATE),Fu_Period(CURRENT_DATE),v_branch,
				 'This invoice automatic create from GRN',CURRENT_TIMESTAMP,p_User);

  OPEN cur_imgrn;
  
  FETCH FROM cur_imgrn INTO v_itemgroup, v_suppgorup, v_debitamt;
  WHILE NO_DATA=0 DO -- 1 Insert in debit amount
		SELECT debit_account INTO v_dbacc FROM it_imtoap WHERE item_group=v_itemgroup AND sup_group=v_suppgorup;
		
		INSERT INTO am_voucherdetail(am_vouchernumber,am_accountcode,am_currency,am_exchagerate,am_primeamt,am_baseamt,am_branch,am_note,inserttime,insertuser)
		VALUES(v_voucher,v_dbacc,v_currency,v_exchange,v_debitamt,v_exchange*v_debitamt,p_Branch,'Inventory Debit automatic',CURRENT_TIMESTAMP,p_User);
		
	FETCH FROM cur_imgrn INTO v_itemgroup, v_suppgorup, v_debitamt;
  END WHILE; -- 1
	CLOSE cur_imgrn;
	
	/*Insert Credit Account*/
	SELECT IFNULL(a.im_taxamt,0),a.im_netamt,b.cm_group,a.cm_supplierid INTO v_taxamt,v_netamt,v_suppgorup,v_subacc FROM im_grnheader a 
	INNER JOIN cm_suppliermaster b ON a.cm_supplierid=b.cm_supplierid
	WHERE a.id=p_id;
	
	SELECT cm_acccode,cm_acctax INTO v_acccode,v_acctax 
	FROM cm_codesparam WHERE cm_type='Supplier Group' AND cm_code=v_suppgorup;
	
	INSERT INTO am_voucherdetail(am_vouchernumber,am_accountcode,am_subacccode,am_currency,am_exchagerate,am_primeamt,am_baseamt,am_branch,am_note,inserttime,insertuser)
	VALUES(v_voucher,v_acccode,v_subacc,v_currency,v_exchange,0-v_netamt,0-(v_exchange*v_netamt),p_Branch,'Inventory Credit automatic',CURRENT_TIMESTAMP,p_User);
	
	IF v_taxamt<>0 THEN -- 2 If tax amount is not zero then credit account will enter.
		INSERT INTO am_voucherdetail(am_vouchernumber,am_accountcode,am_currency,am_exchagerate,am_primeamt,am_baseamt,am_branch,am_note,inserttime,insertuser)
		VALUES(v_voucher,v_acctax,v_currency,v_exchange,0-v_taxamt,0-(v_exchange*v_taxamt),p_Branch,'Inventory Credit automatic',CURRENT_TIMESTAMP,p_User);
	END IF; -- 2
	
	UPDATE im_grnheader SET im_status='Invoiced' AND am_vouchernumber=v_voucher WHERE id=p_id;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_im_TransferConfirm`(p_id INT, p_username VARCHAR(50))
BEGIN
	DECLARE v_Id INT(20);
	DECLARE v_TransferNum VARCHAR(50);
	DECLARE v_FromStore VARCHAR(50);
	DECLARE v_ToStore VARCHAR(50);
	DECLARE v_ProCode VARCHAR(50);
	DECLARE v_Batch VARCHAR(50);
	DECLARE v_ExpDate DATE;
	DECLARE v_Rate DECIMAL(20,2);
	DECLARE v_Quantity INT;
	DECLARE v_Unit VARCHAR(50);
	
	DECLARE v_FromCur VARCHAR(50);
	DECLARE v_ToCur VARCHAR(50);
	DECLARE v_ExchangeRate DECIMAL(20,2);
	
	DECLARE v_ImTrnNumber VARCHAR(50);
	
	DECLARE NO_DATA INT DEFAULT 0;
	
	DECLARE CurTransfer CURSOR FOR
	SELECT a.id, a.im_transfernum, b.im_fromstore, b.im_ToStore, a.cm_code, a.im_BatchNumber, a.im_ExpDate, a.im_rate, a.im_quantity, 
				 a.im_unit
	FROM im_batchtransfer a 
	INNER JOIN im_transferhd b 
	ON a.im_transfernum=b.im_transfernum
	WHERE b.id=p_id AND b.im_status='Open';
	
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET NO_DATA=-2;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET NO_DATA=-1;
	
	SELECT cm_currency INTO v_FromCur 		-- Find from branch/warehouse currency
	FROM cm_branchmaster 								
	WHERE cm_branch=v_FromStore;
	
	SELECT cm_currency INTO v_ToCur				-- Find to branch/warehouse currency
	FROM cm_branchmaster 
	WHERE cm_branch=v_ToStore;
	SELECT IFNULL(cm_exchangerate,0) INTO v_ExchangeRate -- from warehouse exchange rate to warehouse exchange rate. 
	FROM cm_branchcurrency 
	WHERE cm_branch=v_ToStore AND cm_currency=vFromCur;
	
	OPEN CurTransfer;
	FETCH	FROM CurTransfer INTO v_Id, v_TransferNum, v_FromStore, v_ToStore, v_ProCode, v_Batch, v_ExpDate, v_Rate, v_Quantity, v_Unit;
	
	WHILE NO_DATA=0 DO -- 1
		SELECT Fu_GetTrn('Im Transaction','IT--',6,1) INTO v_ImTrnNumber;
		INSERT INTO im_transaction -- Issue Item.
		(im_number, cm_code, im_storeid, im_BatchNumber, im_date, im_ExpireDate, im_quantity, im_sign, im_unit, im_rate, im_totalprice, 
		 im_RefNumber, im_RefRow, im_note, im_status, im_currency, inserttime, insertuser)
		VALUES
		(v_ImTrnNumber, v_ProCode, v_FromStore, v_Batch, CURRENT_DATE, v_ExpDate, v_Quantity, -1, v_Unit, v_Rate, v_Quantity*v_Rate,
		 v_TransferNum, v_Id, CONCAT('Transfer to ',v_ToStore), 'Open', v_FromCur, CURRENT_TIMESTAMP, p_username);
		 
		SELECT Fu_GetTrn('Im Transaction','RE--',6,1) INTO v_ImTrnNumber; 
		INSERT INTO im_transaction -- Received Item
		(im_number, cm_code, im_storeid, im_BatchNumber, im_date, im_ExpireDate, im_quantity, im_sign, im_unit, im_rate, im_totalprice, 
		 im_RefNumber, im_RefRow, im_note, im_status, im_currency, inserttime, insertuser)
		VALUES
		(v_ImTrnNumber, v_ProCode, v_ToStore, v_Batch, CURRENT_DATE, v_ExpDate, v_Quantity, 1, v_Unit, v_Rate*v_ExchangeRate, v_Quantity*v_Rate,
		 v_TransferNum, v_Id, CONCAT('Received from ',v_FromStore), 'Open', v_FromCur, CURRENT_TIMESTAMP, p_username);
		 
	FETCH	FROM CurTransfer INTO v_Id, v_TransferNum, v_FromStore, v_ToStore, v_ProCode, v_Batch, v_ExpDate, v_Rate, v_Quantity, v_Unit;
	END WHILE;  -- 1
	CLOSE CurTransfer;
	
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `Fu_GetTrn`(`p_type` VARCHAR(50), `p_trncode` VARCHAR(4), `p_len` INT, `p_year` BOOLEAN) RETURNS varchar(50) CHARSET utf8
    DETERMINISTIC
BEGIN
	DECLARE vLastNum INT;
	DECLARE vIncri INT;
	DECLARE vTrnNumber VARCHAR(50);
	DECLARE vLength INT;
	DECLARE vCnt INT DEFAULT 1;
	SELECT cm_lastnumber,cm_increment INTO vLastNum,vIncri FROM cm_transaction WHERE cm_type=p_type AND cm_trncode=p_trncode AND cm_active=1;
	SET vTrnNumber = vLastNum+vIncri;
	
	SET vLength=(p_len-LENGTH(vTrnNumber));
	WHILE vCnt<=vLength DO
		SET vTrnNumber=CONCAT('0',vTrnNumber);-- This concat padding zero before transaction number.
		SET vCnt=vCnt+1;
	END WHILE;
	UPDATE cm_transaction 
		SET cm_lastnumber=vTrnNumber, updatetime=CURRENT_TIMESTAMP
	WHERE cm_type=p_type AND cm_trncode=p_trncode;
	
	IF p_year=FALSE THEN
		SET vTrnNumber=CONCAT(p_trncode,vTrnNumber);
	ELSE
		SET vTrnNumber=CONCAT(p_trncode,SUBSTRING(CURRENT_DATE,3,2),vTrnNumber);
	END IF;
	RETURN vTrnNumber;	
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `am_apalc`
--

CREATE TABLE IF NOT EXISTS `am_apalc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `am_vouchernumber` varchar(50) DEFAULT NULL,
  `am_invnumber` varchar(20) DEFAULT NULL,
  `am_currency` varchar(20) DEFAULT NULL,
  `am_exchagerate` decimal(20,2) DEFAULT NULL,
  `am_primeamt` decimal(20,2) DEFAULT NULL,
  `am_amount` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(20) DEFAULT NULL,
  `updateuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_vouchernumber` (`am_vouchernumber`,`am_invnumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `am_apalc`
--

INSERT INTO `am_apalc` (`id`, `am_vouchernumber`, `am_invnumber`, `am_currency`, `am_exchagerate`, `am_primeamt`, `am_amount`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(1, 'APV-14000035', 'INVC14000002', 'USD', 78.00, 50.00, 3900.00, '2014-03-22 12:54:00', NULL, 'admin', NULL),
(2, 'APV-14000037', 'INVC14000002', 'USD', 78.00, 100.00, 7800.00, '2014-03-22 12:55:00', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `am_chartofaccounts`
--

CREATE TABLE IF NOT EXISTS `am_chartofaccounts` (
  `am_accountcode` varchar(50) NOT NULL,
  `am_description` varchar(100) NOT NULL,
  `am_accounttype` varchar(50) DEFAULT NULL,
  `am_accountusage` varchar(50) DEFAULT NULL,
  `am_groupone` varchar(50) DEFAULT NULL,
  `am_grouptwo` varchar(50) DEFAULT NULL,
  `am_groupthree` varchar(50) DEFAULT NULL,
  `am_groupfour` varchar(50) DEFAULT NULL,
  `am_analyticalcode` varchar(10) DEFAULT NULL,
  `am_branch` varchar(50) DEFAULT NULL,
  `am_status` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`am_accountcode`),
  KEY `am_description` (`am_description`,`am_accounttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_chartofaccounts`
--

INSERT INTO `am_chartofaccounts` (`am_accountcode`, `am_description`, `am_accounttype`, `am_accountusage`, `am_groupone`, `am_grouptwo`, `am_groupthree`, `am_groupfour`, `am_analyticalcode`, `am_branch`, `am_status`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
('10001', 'Cash In Hand', 'Asset', 'Ledger', '10001', '0', '', NULL, 'Cash', '', 'Open', '2014-03-11 14:24:00', '2014-03-18 15:01:00', 'admin', 'admin'),
('10002', 'Cash at Bank', 'Asset', 'Ledger', '10001', '0', '', NULL, 'Cash', '', 'Open', '2014-03-11 14:32:00', '2014-03-18 15:01:00', 'admin', 'admin'),
('10003', 'Accounts Receivable', 'Asset', 'AR', '', '', '', NULL, 'Non-Cash', '', 'Open', '2014-03-11 14:32:00', '0000-00-00 00:00:00', 'admin', ''),
('10004', 'Stock', 'Asset', 'Ledger', '', '', '', NULL, 'Non-Cash', '', 'Open', '2014-03-11 14:35:00', '0000-00-00 00:00:00', 'admin', ''),
('20001', 'Invesment Capital', 'Liability', 'Ledger', '', '', '', NULL, 'Non-Cash', '', 'Open', '2014-03-11 14:26:00', '0000-00-00 00:00:00', 'admin', ''),
('20002', 'Accounts Payable Foreign Supplier', 'Liability', 'AP', '', '', '', NULL, 'Non-Cash', '', 'Open', '2014-03-11 14:27:00', '2014-03-15 14:41:00', 'admin', 'admin'),
('20003', 'Purchase Tax', 'Liability', 'Ledger', '', '', '', NULL, 'Non-Cash', '', 'Open', '2014-03-15 14:17:00', '0000-00-00 00:00:00', 'admin', ''),
('20004', 'Accounts Payable Local Supplier', 'Liability', 'AP', '', '', '', NULL, 'Non-Cash', '', 'Open', '2014-03-15 14:41:00', '0000-00-00 00:00:00', 'admin', ''),
('30001', 'Sales', 'Income', 'Ledger', '', '', '', NULL, 'Non-Cash', '', 'Open', '2014-03-11 14:34:00', '0000-00-00 00:00:00', 'admin', ''),
('40001', 'Inventory Issue', 'Expenses', 'Ledger', '40001', '0', '', NULL, 'Cash', '880', 'Open', '2014-03-18 14:59:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `am_default`
--

CREATE TABLE IF NOT EXISTS `am_default` (
  `id` int(11) NOT NULL,
  `am_offset` int(11) DEFAULT NULL,
  `am_pnlacount` varchar(50) DEFAULT NULL,
  `am_year` int(11) DEFAULT NULL,
  `am_period` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_offset` (`am_offset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_default`
--

INSERT INTO `am_default` (`id`, `am_offset`, `am_pnlacount`, `am_year`, `am_period`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(1, 6, '1', 2013, 9, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `am_group_four`
--

CREATE TABLE IF NOT EXISTS `am_group_four` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `am_groupone` varchar(50) DEFAULT NULL,
  `am_grouptwo` varchar(50) DEFAULT NULL,
  `am_groupthree` varchar(50) DEFAULT NULL,
  `am_groupfour` varchar(50) DEFAULT NULL,
  `am_description` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_groupone` (`am_groupone`,`am_grouptwo`,`am_groupthree`,`am_groupfour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `am_group_one`
--

CREATE TABLE IF NOT EXISTS `am_group_one` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `am_groupone` varchar(50) DEFAULT NULL,
  `am_description` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_groupone` (`am_groupone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `am_group_one`
--

INSERT INTO `am_group_one` (`id`, `am_groupone`, `am_description`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(13, '10001', 'Current Assets', '2014-03-18 13:01:00', '0000-00-00 00:00:00', 'admin', ''),
(14, '10002', 'Property, Plant, and Equipment', '2014-03-18 13:01:00', '0000-00-00 00:00:00', 'admin', ''),
(15, '20001', ' Current Liabilities', '2014-03-18 13:01:00', '0000-00-00 00:00:00', 'admin', ''),
(16, '20002', 'Long-term Liabilities', '2014-03-18 13:02:00', '0000-00-00 00:00:00', 'admin', ''),
(17, '20003', 'Stockholders'' Equity', '2014-03-18 13:04:00', '0000-00-00 00:00:00', 'admin', ''),
(18, '30001', 'Operating Revenues', '2014-03-18 13:05:00', '0000-00-00 00:00:00', 'admin', ''),
(19, '40001', ' Cost of Goods Sold', '2014-03-18 13:05:00', '0000-00-00 00:00:00', 'admin', ''),
(20, '40002', 'Marketing Expenses', '2014-03-18 13:06:00', '0000-00-00 00:00:00', 'admin', ''),
(21, '40003', 'Payroll Dept. Expenses', '2014-03-18 13:06:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `am_group_three`
--

CREATE TABLE IF NOT EXISTS `am_group_three` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `am_groupone` varchar(50) DEFAULT NULL,
  `am_grouptwo` varchar(50) DEFAULT NULL,
  `am_groupthree` varchar(50) DEFAULT NULL,
  `am_description` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_groupone` (`am_groupone`,`am_grouptwo`,`am_groupthree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `am_group_two`
--

CREATE TABLE IF NOT EXISTS `am_group_two` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `am_groupone` varchar(50) DEFAULT NULL,
  `am_grouptwo` varchar(50) DEFAULT NULL,
  `am_description` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_groupone` (`am_groupone`,`am_grouptwo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `am_voucherdetail`
--

CREATE TABLE IF NOT EXISTS `am_voucherdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `am_vouchernumber` varchar(50) NOT NULL,
  `am_accountcode` varchar(50) NOT NULL,
  `am_subacccode` varchar(50) NOT NULL,
  `am_currency` varchar(10) DEFAULT NULL,
  `am_exchagerate` decimal(20,2) DEFAULT NULL,
  `am_primeamt` decimal(20,2) DEFAULT NULL,
  `am_baseamt` decimal(20,2) DEFAULT NULL,
  `am_branch` varchar(50) DEFAULT NULL,
  `am_note` varchar(255) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_vouchernumber` (`am_vouchernumber`,`am_accountcode`),
  KEY `am_accountcode` (`am_accountcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `am_voucherdetail`
--

INSERT INTO `am_voucherdetail` (`id`, `am_vouchernumber`, `am_accountcode`, `am_subacccode`, `am_currency`, `am_exchagerate`, `am_primeamt`, `am_baseamt`, `am_branch`, `am_note`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(1, 'INVC14000002', '10004', '', 'USD', 78.00, 200.00, 15600.00, NULL, '', '2014-03-16 13:54:00', NULL, 'admin', NULL),
(2, 'INVC14000002', '20002', 'AKG', 'USD', 78.00, -200.00, -15600.00, NULL, '', '2014-03-16 13:54:00', NULL, 'admin', NULL),
(3, 'INVOICE123', '10001', '', 'BDT', 1.00, 0.00, 0.00, NULL, NULL, '2014-03-19 17:43:00', NULL, 'admin', NULL),
(4, 'INVOICE123', '20002', '', 'BDT', 1.00, 5600.00, 5600.00, NULL, NULL, '2014-03-19 17:43:00', NULL, 'admin', NULL),
(5, 'INVOICE125', '10002', '', 'USD', 78.00, 66.00, 5148.00, NULL, NULL, '2014-03-19 17:57:00', NULL, 'admin', NULL),
(6, 'INVOICE125', '20002', '', 'USD', 78.00, 66.00, 5148.00, NULL, NULL, '2014-03-19 17:57:00', NULL, 'admin', NULL),
(7, 'INVOICE126', '20002', '', 'BDT', 1.00, 5656.00, 5656.00, NULL, NULL, '2014-03-20 12:06:00', NULL, 'admin', NULL),
(16, 'APV-14000026', '10002', '', 'USD', 78.00, -50.00, -3900.00, NULL, NULL, '2014-03-22 12:26:00', NULL, 'admin', NULL),
(17, 'APV-14000026', '20002', 'AKG', 'USD', 78.00, 50.00, 3900.00, NULL, NULL, '2014-03-22 12:26:00', NULL, 'admin', NULL),
(18, 'APV-14000033', '10002', '', 'USD', 78.00, -55.00, -4290.00, NULL, NULL, '2014-03-22 12:51:00', NULL, 'admin', NULL),
(19, 'APV-14000033', '20002', 'AKG', 'USD', 78.00, 55.00, 4290.00, NULL, NULL, '2014-03-22 12:51:00', NULL, 'admin', NULL),
(20, 'APV-14000035', '10002', '', 'USD', 78.00, -50.00, -3900.00, NULL, NULL, '2014-03-22 12:54:00', NULL, 'admin', NULL),
(21, 'APV-14000035', '20002', 'AKG', 'USD', 78.00, 50.00, 3900.00, NULL, NULL, '2014-03-22 12:54:00', NULL, 'admin', NULL),
(22, 'APV-14000037', '10002', '', 'USD', 78.00, -150.00, -11700.00, NULL, NULL, '2014-03-22 12:55:00', NULL, 'admin', NULL),
(23, 'APV-14000037', '20002', 'AKG', 'USD', 78.00, 150.00, 11700.00, NULL, NULL, '2014-03-22 12:55:00', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `am_vouhcerheader`
--

CREATE TABLE IF NOT EXISTS `am_vouhcerheader` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `am_vouchernumber` varchar(50) NOT NULL,
  `am_date` date DEFAULT NULL,
  `am_referance` varchar(150) DEFAULT NULL,
  `am_year` int(11) DEFAULT NULL,
  `am_period` int(11) DEFAULT NULL,
  `am_branch` varchar(50) DEFAULT NULL,
  `am_note` varchar(255) DEFAULT NULL,
  `am_status` varchar(20) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `am_vouchernumber` (`am_vouchernumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `am_vouhcerheader`
--

INSERT INTO `am_vouhcerheader` (`id`, `am_vouchernumber`, `am_date`, `am_referance`, `am_year`, `am_period`, `am_branch`, `am_note`, `am_status`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(1, 'PAY-14000008', '2014-03-12', '330', 2014, 9, 'Kallanpur', 'new one ', 'Open', '2014-03-12 10:13:00', '0000-00-00 00:00:00', 'admin', ''),
(2, 'INVC14000002', '2014-03-16', '0', 2013, 9, 'Kallanpur', '', 'Open', '2014-03-16 13:54:00', '0000-00-00 00:00:00', 'admin', ''),
(3, 'INVOICE123', '2014-03-19', NULL, 2013, 9, '880', 'Thank you so much', 'Balanced', '2014-03-19 17:43:00', '0000-00-00 00:00:00', 'admin', ''),
(4, 'INVOICE124', '2014-03-19', NULL, 2013, 9, '880', 'thank you', 'Balanced', '2014-03-19 17:50:00', '0000-00-00 00:00:00', 'admin', ''),
(5, 'INVOICE125', '2014-03-19', NULL, 2013, 9, '880', 'thanks', 'Balanced', '2014-03-19 17:57:00', '0000-00-00 00:00:00', 'admin', ''),
(6, 'INVOICE126', '2014-03-20', NULL, 2013, 9, '880', 'th', 'Balanced', '2014-03-20 12:06:00', '0000-00-00 00:00:00', 'admin', ''),
(10, 'APV-14000013', '2014-03-22', NULL, 2013, 9, '880', 'Test', 'Balanced', '2014-03-22 11:35:00', '0000-00-00 00:00:00', 'admin', ''),
(11, 'APV-14000026', '2014-03-22', NULL, 2013, 9, '880', 'ok', 'Balanced', '2014-03-22 12:26:00', '0000-00-00 00:00:00', 'admin', ''),
(12, 'APV-14000033', '2014-03-22', NULL, 2013, 9, '880', 'ok', 'Balanced', '2014-03-22 12:51:00', '0000-00-00 00:00:00', 'admin', ''),
(13, 'APV-14000035', '2014-03-22', NULL, 2013, 9, '880', 'o', 'Balanced', '2014-03-22 12:54:00', '0000-00-00 00:00:00', 'admin', ''),
(14, 'APV-14000037', '2014-03-22', NULL, 2013, 9, '880', 'lp', 'Balanced', '2014-03-22 12:55:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `am_vw_apayable`
--
CREATE TABLE IF NOT EXISTS `am_vw_apayable` (
`suppliercode` varchar(50)
,`suppliername` varchar(100)
,`accoutcode` varchar(50)
,`conperson` varchar(100)
,`payableamt` decimal(42,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `am_vw_payinvc`
--
CREATE TABLE IF NOT EXISTS `am_vw_payinvc` (
`suppliercode` varchar(50)
,`invoicnumber` varchar(50)
,`currency` varchar(20)
,`exchange` decimal(20,2)
,`primaamt` decimal(20,2)
,`amount` decimal(20,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `am_vw_unpaidinv`
--
CREATE TABLE IF NOT EXISTS `am_vw_unpaidinv` (
`suppliercode` varchar(50)
,`invoicnumber` varchar(50)
,`currency` varchar(20)
,`exchange` decimal(20,2)
,`primaamt` decimal(42,2)
,`amount` decimal(42,2)
);
-- --------------------------------------------------------

--
-- Table structure for table `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', '1', NULL, NULL),
('Operator ', '2', NULL, 'N;'),
('Operator ', '3', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 1, NULL, NULL, NULL),
('Branchmaster.Admin', 0, NULL, NULL, 'N;'),
('Branchmaster.Create', 0, NULL, NULL, 'N;'),
('Branchmaster.View', 0, NULL, NULL, 'N;'),
('Codesparam.Admin', 0, NULL, NULL, 'N;'),
('Codesparam.Create', 0, NULL, NULL, 'N;'),
('Codesparam.View', 0, NULL, NULL, 'N;'),
('Codesparam.ViewCurrency', 0, NULL, NULL, 'N;'),
('Codesparam.ViewSm', 0, NULL, NULL, 'N;'),
('Companyprofile.Admin', 0, NULL, NULL, 'N;'),
('Companyprofile.Create', 0, NULL, NULL, 'N;'),
('Companyprofile.View', 0, NULL, NULL, 'N;'),
('Grndetail.Admin', 0, NULL, NULL, 'N;'),
('Grndetail.Create', 0, NULL, NULL, 'N;'),
('Grndetail.View', 0, NULL, NULL, 'N;'),
('Imtransaction.Admin', 0, NULL, NULL, 'N;'),
('Imtransaction.Create', 0, NULL, NULL, 'N;'),
('Imtransaction.View', 0, NULL, NULL, 'N;'),
('Operator ', 2, NULL, NULL, 'N;'),
('Productmaster.Admin', 0, NULL, NULL, 'N;'),
('Productmaster.Create', 0, NULL, NULL, 'N;'),
('Productmaster.View', 0, NULL, NULL, 'N;'),
('Purchaseorddt.Admin', 0, NULL, NULL, 'N;'),
('Purchaseorddt.Create', 0, NULL, NULL, 'N;'),
('Purchaseorddt.View', 0, NULL, NULL, 'N;'),
('Purchaseordhd.Admin', 0, NULL, NULL, 'N;'),
('Purchaseordhd.Create', 0, NULL, NULL, 'N;'),
('Purchaseordhd.CreateGRN', 0, NULL, NULL, 'N;'),
('Purchaseordhd.View', 0, NULL, NULL, 'N;'),
('Purchaseordhd.ViewGrn', 0, NULL, NULL, 'N;'),
('Requisitiondt.Admin', 0, NULL, NULL, 'N;'),
('Requisitiondt.Create', 0, NULL, NULL, 'N;'),
('Requisitiondt.View', 0, NULL, NULL, 'N;'),
('Requisitionhd.Admin', 0, NULL, NULL, 'N;'),
('Requisitionhd.Create', 0, NULL, NULL, 'N;'),
('Requisitionhd.View', 0, NULL, NULL, 'N;'),
('Site.Index', 0, NULL, NULL, 'N;'),
('Site.Login', 0, NULL, NULL, 'N;'),
('Site.Logout', 0, NULL, NULL, 'N;'),
('Suppliermaster.Admin', 0, NULL, NULL, 'N;'),
('Suppliermaster.Create', 0, NULL, NULL, 'N;'),
('Suppliermaster.View', 0, NULL, NULL, 'N;'),
('Transaction.Admin', 0, NULL, NULL, 'N;'),
('Transaction.Create', 0, NULL, NULL, 'N;'),
('Transaction.CreateGRNnumnber', 0, NULL, NULL, 'N;'),
('Transaction.ManageGRNnumnber', 0, NULL, NULL, 'N;'),
('Transaction.ManageImTranNum', 0, NULL, NULL, 'N;'),
('Transaction.ManageImTrn', 0, NULL, NULL, 'N;'),
('Transaction.View', 0, NULL, NULL, 'N;'),
('Transaction.ViewGRNNumber', 0, NULL, NULL, 'N;'),
('Transaction.ViewPurchaseOrderNumber', 0, NULL, NULL, 'N;'),
('Transaction.ViewRequisitionNumber', 0, NULL, NULL, 'N;'),
('Transferdt.Admin', 0, NULL, NULL, 'N;'),
('Transferdt.Create', 0, NULL, NULL, 'N;'),
('Transferdt.View', 0, NULL, NULL, 'N;'),
('Transferhd.Admin', 0, NULL, NULL, 'N;'),
('Transferhd.Create', 0, NULL, NULL, 'N;'),
('Transferhd.View', 0, NULL, NULL, 'N;'),
('User.Admin.Admin', 0, NULL, NULL, 'N;'),
('User.Admin.View', 0, NULL, NULL, 'N;'),
('User.Default.Index', 0, NULL, NULL, 'N;'),
('User.Profile.Profile', 0, NULL, NULL, 'N;'),
('VwStock.Admin', 0, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('admin', 'admin'),
('Operator ', 'Branchmaster.Admin'),
('Operator ', 'Branchmaster.Create'),
('Operator ', 'Branchmaster.View'),
('Operator ', 'Codesparam.Admin'),
('Operator ', 'Codesparam.Create'),
('Operator ', 'Codesparam.View'),
('Operator ', 'Codesparam.ViewCurrency'),
('Operator ', 'Codesparam.ViewSm'),
('Operator ', 'Companyprofile.Admin'),
('Operator ', 'Companyprofile.Create'),
('Operator ', 'Companyprofile.View'),
('Operator ', 'Grndetail.Admin'),
('Operator ', 'Grndetail.Create'),
('Operator ', 'Grndetail.View'),
('Operator ', 'Imtransaction.Admin'),
('Operator ', 'Imtransaction.Create'),
('Operator ', 'Imtransaction.View'),
('Operator ', 'Productmaster.Admin'),
('Operator ', 'Productmaster.Create'),
('Operator ', 'Productmaster.View'),
('Operator ', 'Purchaseorddt.Admin'),
('Operator ', 'Purchaseorddt.Create'),
('Operator ', 'Purchaseorddt.View'),
('Operator ', 'Purchaseordhd.Admin'),
('Operator ', 'Purchaseordhd.Create'),
('Operator ', 'Purchaseordhd.CreateGRN'),
('Operator ', 'Purchaseordhd.View'),
('Operator ', 'Purchaseordhd.ViewGrn'),
('Operator ', 'Requisitiondt.Admin'),
('Operator ', 'Requisitiondt.Create'),
('Operator ', 'Requisitiondt.View'),
('Operator ', 'Requisitionhd.Admin'),
('Operator ', 'Requisitionhd.Create'),
('Operator ', 'Requisitionhd.View'),
('Operator ', 'Site.Index'),
('Operator ', 'Site.Login'),
('Operator ', 'Site.Logout'),
('Operator ', 'Suppliermaster.Admin'),
('Operator ', 'Suppliermaster.Create'),
('Operator ', 'Suppliermaster.View'),
('Operator ', 'Transaction.Admin'),
('Operator ', 'Transaction.Create'),
('Operator ', 'Transaction.CreateGRNnumnber'),
('Operator ', 'Transaction.ManageGRNnumnber'),
('Operator ', 'Transaction.ManageImTranNum'),
('Operator ', 'Transaction.ManageImTrn'),
('Operator ', 'Transaction.View'),
('Operator ', 'Transaction.ViewGRNNumber'),
('Operator ', 'Transaction.ViewPurchaseOrderNumber'),
('Operator ', 'Transaction.ViewRequisitionNumber'),
('Operator ', 'Transferdt.Admin'),
('Operator ', 'Transferdt.Create'),
('Operator ', 'Transferdt.View'),
('Operator ', 'Transferhd.Admin'),
('Operator ', 'Transferhd.Create'),
('Operator ', 'Transferhd.View'),
('Operator ', 'User.Admin.Admin'),
('Operator ', 'User.Admin.View'),
('Operator ', 'User.Default.Index'),
('Operator ', 'User.Profile.Profile'),
('Operator ', 'VwStock.Admin');

-- --------------------------------------------------------

--
-- Table structure for table `cm_branchcurrency`
--

CREATE TABLE IF NOT EXISTS `cm_branchcurrency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cm_branch` varchar(50) DEFAULT NULL,
  `cm_currency` varchar(10) DEFAULT NULL,
  `cm_description` varchar(100) DEFAULT NULL,
  `cm_exchangerate` decimal(20,2) DEFAULT NULL,
  `cm_active` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cm_branch` (`cm_branch`,`cm_currency`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cm_branchcurrency`
--

INSERT INTO `cm_branchcurrency` (`id`, `cm_branch`, `cm_currency`, `cm_description`, `cm_exchangerate`, `cm_active`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(1, 'Kallanpur', 'TK', 'bd tk', 33.00, 1, '2014-01-27 07:40:00', '2014-03-11 11:29:00', 'admin', 'admin'),
(2, 'Holand', 'BDT', '', 80.00, 1, '2014-01-27 12:51:00', '0000-00-00 00:00:00', 'admin', ''),
(3, '880', 'BDT', 'Bangladeshi Taka', 1.00, 1, '2014-03-18 14:30:00', '0000-00-00 00:00:00', 'admin', ''),
(4, '880', 'EURO', '', 105.00, 1, '2014-03-18 14:30:00', '0000-00-00 00:00:00', 'admin', ''),
(5, '880', 'GBP', '', 150.00, 1, '2014-03-18 14:30:00', '0000-00-00 00:00:00', 'admin', ''),
(6, '880', 'USD', '', 78.00, 1, '2014-03-18 14:32:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `cm_branchmaster`
--

CREATE TABLE IF NOT EXISTS `cm_branchmaster` (
  `cm_branch` varchar(50) NOT NULL,
  `cm_description` varchar(100) DEFAULT NULL,
  `cm_currency` varchar(50) DEFAULT NULL,
  `cm_contacperson` varchar(50) DEFAULT NULL,
  `cm_designation` varchar(50) DEFAULT NULL,
  `cm_mailingaddress` varchar(250) DEFAULT NULL,
  `cm_phone` varchar(10) DEFAULT NULL,
  `cm_cell` varchar(10) DEFAULT NULL,
  `cm_fax` varchar(10) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cm_branch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cm_branchmaster`
--

INSERT INTO `cm_branchmaster` (`cm_branch`, `cm_description`, `cm_currency`, `cm_contacperson`, `cm_designation`, `cm_mailingaddress`, `cm_phone`, `cm_cell`, `cm_fax`, `active`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
('880', 'Bangladesh', 'BDT', 'Amit', '', '', '', '', '', 1, '2014-03-18 14:07:00', '0000-00-00 00:00:00', 'admin', ''),
('Gulshan', 'Gulshan Area', 'TAKA', 'Contact Person', 'GM', 'Gulshan', '8490850943', '987654321', '987654321', 1, '2014-01-20 08:15:00', '0000-00-00 00:00:00', 'admin', ''),
('Holand', 'Holand', 'USD', 'Selim', 'SR', 'Dhaka', '1234567', '1234567', '', 1, '2014-01-27 12:49:00', '0000-00-00 00:00:00', 'admin', ''),
('Kallanpur', 'Warehouse', 'TK', 'Selim Reza', 'Test', 'Test', '0123456', '0123456', '', 1, '2014-01-15 10:40:00', '2014-01-15 10:41:00', 'admin', 'admin'),
('Uttara', 'Main House', 'BDT', 'Amir', 'Supervisor', 'Uttara', '8490850943', '987654321', '', 1, '2014-01-15 10:39:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `cm_codesparam`
--

CREATE TABLE IF NOT EXISTS `cm_codesparam` (
  `cm_type` varchar(50) NOT NULL,
  `cm_code` varchar(50) NOT NULL,
  `cm_desc` varchar(150) DEFAULT NULL,
  `cm_purtax` decimal(20,2) DEFAULT NULL,
  `cm_acccode` varchar(50) DEFAULT NULL,
  `cm_props` varchar(50) DEFAULT NULL,
  `cm_long` varchar(200) DEFAULT NULL,
  `cm_percent` decimal(20,2) DEFAULT NULL,
  `cm_acctax` varchar(50) DEFAULT NULL,
  `cm_branch` varchar(50) DEFAULT NULL,
  `cm_active` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cm_type`,`cm_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cm_codesparam`
--

INSERT INTO `cm_codesparam` (`cm_type`, `cm_code`, `cm_desc`, `cm_purtax`, `cm_acccode`, `cm_props`, `cm_long`, `cm_percent`, `cm_acctax`, `cm_branch`, `cm_active`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
('BankCash', 'BANKCASH', 'BankCash', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-23 15:14:00', '0000-00-00 00:00:00', 'admin', ''),
('Currency', 'BDT', 'Bangladeshi Taka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-15 10:38:00', '2014-03-18 14:08:00', 'admin', 'admin'),
('Currency', 'EURO', 'Eurpo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-18 14:09:00', '0000-00-00 00:00:00', 'admin', ''),
('Currency', 'GBP', 'Great Britain Pound', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-18 14:09:00', '0000-00-00 00:00:00', 'admin', ''),
('Currency', 'USD', 'US Dollar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-27 12:48:00', '0000-00-00 00:00:00', 'admin', ''),
('Department', 'DEPARTMENT', 'Department', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-23 15:04:00', '0000-00-00 00:00:00', 'admin', ''),
('Designation', 'DESIGNATION', 'Designation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-23 15:09:00', '0000-00-00 00:00:00', 'admin', ''),
('Leave Plan', 'LEAVE PLAN', 'Leave Plan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-23 15:21:00', '0000-00-00 00:00:00', 'admin', ''),
('Position', 'A', 'A Grade', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-23 14:49:00', '0000-00-00 00:00:00', 'admin', ''),
('Position', 'POSITION', 'POSITION', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-03-23 14:39:00', '0000-00-00 00:00:00', 'admin', ''),
('Product Category', 'PCA01', 'product category', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-15 10:27:00', '0000-00-00 00:00:00', 'admin', ''),
('Product Class', 'DHAKA', 'Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-19 12:52:00', '0000-00-00 00:00:00', 'admin', ''),
('Product Class', 'PC01', 'product class name', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-15 10:25:00', '0000-00-00 00:00:00', 'admin', ''),
('Product Group', 'DHAKA', 'local', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-19 12:52:00', '0000-00-00 00:00:00', 'admin', ''),
('Product Group', 'PG01', 'product group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-15 10:26:00', '0000-00-00 00:00:00', 'admin', ''),
('Salary Type', 'SALARY TYPE', NULL, NULL, NULL, 'Salary Type', 'Salary Type', 5.00, NULL, NULL, 1, '2014-03-23 15:39:00', '0000-00-00 00:00:00', 'admin', ''),
('Supplier Group', 'FOREIGN', '', NULL, '20002', NULL, NULL, NULL, '20003', 'Gulshan', 1, '2014-03-15 14:40:00', '0000-00-00 00:00:00', 'admin', ''),
('Supplier Group', 'LOCAL', '', NULL, '20004', NULL, NULL, NULL, '20003', 'Gulshan', 1, '2014-03-15 14:42:00', '0000-00-00 00:00:00', 'admin', ''),
('Unit Of Measurement', 'UOM01', 'unit of measurement', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2014-01-15 10:27:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `cm_customermst`
--

CREATE TABLE IF NOT EXISTS `cm_customermst` (
  `cm_cuscode` varchar(20) NOT NULL,
  `cm_name` varchar(100) DEFAULT NULL,
  `cm_address` varchar(250) DEFAULT NULL,
  `cm_territory` varchar(50) DEFAULT NULL,
  `cm_group` varchar(50) NOT NULL,
  `cm_cellnumber` varchar(50) DEFAULT NULL,
  `cm_phone` varchar(50) DEFAULT NULL,
  `cm_fax` varchar(50) DEFAULT NULL,
  `cm_email` varchar(150) DEFAULT NULL,
  `cm_branch` varchar(50) NOT NULL,
  `cm_market` varchar(50) DEFAULT NULL,
  `cm_sp` varchar(50) DEFAULT NULL,
  `cm_creditlimit` decimal(20,2) DEFAULT NULL,
  `cm_hub` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cm_cuscode`),
  KEY `cm_branch` (`cm_branch`,`cm_hub`),
  KEY `cm_name` (`cm_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cm_customermst`
--

INSERT INTO `cm_customermst` (`cm_cuscode`, `cm_name`, `cm_address`, `cm_territory`, `cm_group`, `cm_cellnumber`, `cm_phone`, `cm_fax`, `cm_email`, `cm_branch`, `cm_market`, `cm_sp`, `cm_creditlimit`, `cm_hub`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
('11', 'Ali', '11', NULL, '', '11', '11', NULL, NULL, 'Dhaka', NULL, 'sp-1', NULL, NULL, NULL, NULL, NULL, NULL),
('123', 'Babu', '22', '', '', '', '', '', '', 'Dhaka', '', 'sp-2', 0.00, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
('S123', 'Selim', '33', '', '', '', '', '', '', 'Dhaka', '', 'sp-3', 0.00, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cm_productmaster`
--

CREATE TABLE IF NOT EXISTS `cm_productmaster` (
  `cm_code` varchar(50) NOT NULL,
  `cm_name` varchar(200) NOT NULL,
  `cm_description` varchar(200) DEFAULT NULL,
  `cm_class` varchar(50) DEFAULT NULL,
  `cm_group` varchar(50) DEFAULT NULL,
  `cm_category` varchar(50) DEFAULT NULL,
  `cm_sellrate` decimal(20,2) DEFAULT NULL,
  `cm_costprice` decimal(20,2) DEFAULT NULL,
  `cm_sellunit` varchar(50) DEFAULT NULL,
  `cm_sellconfact` decimal(20,2) DEFAULT NULL,
  `cm_purunit` varchar(50) DEFAULT NULL,
  `cm_purconfact` decimal(20,2) DEFAULT NULL,
  `cm_selltax` decimal(20,2) DEFAULT NULL,
  `cm_stkunit` varchar(50) DEFAULT NULL,
  `cm_stkconfac` decimal(20,2) DEFAULT NULL,
  `cm_packsize` varchar(50) DEFAULT NULL,
  `cm_stocktype` varchar(50) DEFAULT NULL,
  `cm_generic` varchar(100) DEFAULT NULL,
  `cm_supplierid` varchar(50) DEFAULT NULL,
  `cm_mfgcode` varchar(50) DEFAULT NULL,
  `cm_maxlevel` int(11) DEFAULT NULL,
  `cm_minlevel` int(11) DEFAULT NULL,
  `cm_reorder` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cm_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cm_productmaster`
--

INSERT INTO `cm_productmaster` (`cm_code`, `cm_name`, `cm_description`, `cm_class`, `cm_group`, `cm_category`, `cm_sellrate`, `cm_costprice`, `cm_sellunit`, `cm_sellconfact`, `cm_purunit`, `cm_purconfact`, `cm_selltax`, `cm_stkunit`, `cm_stkconfac`, `cm_packsize`, `cm_stocktype`, `cm_generic`, `cm_supplierid`, `cm_mfgcode`, `cm_maxlevel`, `cm_minlevel`, `cm_reorder`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
('HPCOM01', 'Hp Computer', 'Hp brand new computer', 'PC01', 'PG01', 'PCA01', 22000.00, 20000.00, 'UOM01', 5.00, 'UOM01', 5.00, 3.00, 'UOM01', 5.00, '1', 'Stock N Sell', '', 'SERE', 'MFG03', 11, 1, 1, '2014-01-15 10:33:00', '2014-01-15 10:47:00', 'admin', 'admin'),
('LAPTOP', 'Laptop - Sony Bravio', 'from Japan', 'PC01', 'PG01', 'PCA01', 30000.00, 28000.00, 'UOM01', 5.00, 'UOM01', 4.00, 4.00, 'UOM01', 4.00, '1', 'Stock N Sell', '1', 'SERE', 'MFG04', 1, 1, 1, '2014-01-15 10:34:00', '0000-00-00 00:00:00', 'admin', ''),
('MOUSE', 'A4 Mouse', 'A4 Tech', 'DHAKA', 'DHAKA', 'PCA01', 450.00, 440.00, 'UOM01', 1.00, 'UOM01', 50.00, 5.00, 'UOM01', 45.00, '1', 'Stock N Sell', '10', 'SERE', '123456789', 12, 1, 1, '2014-01-20 08:06:00', '0000-00-00 00:00:00', 'admin', ''),
('NOKIA01', 'Nokia Phone', 'Finland', 'PC01', 'PG01', 'PCA01', 1000.00, 900.00, 'UOM01', 12.00, 'UOM01', 10.00, 6.00, 'UOM01', 10.00, '12', 'Stock N Sell', '12', 'SERE', 'MFG01', 12, 1, 2, '2014-01-15 10:28:00', '0000-00-00 00:00:00', 'admin', ''),
('PEN01', 'Fountain Pen', 'from Japan', 'DHAKA', 'DHAKA', 'PCA01', 5.00, 4.50, 'UOM01', 30.00, 'UOM01', 12.00, 7.00, 'UOM01', 144.00, '12', 'Stock N Sell', '1', 'SERE', '123456789', 900, 12, 1, '2014-01-20 08:04:00', '0000-00-00 00:00:00', 'admin', ''),
('SAM01', 'Samsung Phone', 'from Korea', 'PC01', 'PG01', 'PCA01', 1200.00, 1100.00, 'UOM01', 12.00, 'UOM01', 12.00, 8.00, 'UOM01', 12.00, '12', 'Stock N Sell', '10', 'SERE', 'MFG02', 100, 10, 20, '2014-01-15 10:32:00', '0000-00-00 00:00:00', 'admin', ''),
('TAB', 'Samsung TAB', 'Samsung Brand', 'DHAKA', 'DHAKA', 'PCA01', 55000.00, 50000.00, 'UOM01', 1.00, 'UOM01', 5.00, 9.00, 'UOM01', 10.00, '1', 'Stock N Sell', '1', 'AMIT', '123456789', 15, 1, 1, '2014-01-20 08:07:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `cm_suppliermaster`
--

CREATE TABLE IF NOT EXISTS `cm_suppliermaster` (
  `cm_supplierid` varchar(50) NOT NULL,
  `cm_group` varchar(50) NOT NULL,
  `cm_orgname` varchar(100) NOT NULL,
  `cm_address` varchar(200) DEFAULT NULL,
  `cm_district` varchar(50) DEFAULT NULL,
  `cm_post` varchar(50) DEFAULT NULL,
  `cm_policest` varchar(50) DEFAULT NULL,
  `cm_postcode` varchar(10) DEFAULT NULL,
  `cm_contactperson` varchar(100) NOT NULL,
  `cm_phone` varchar(20) DEFAULT NULL,
  `cm_cellphone` varchar(50) DEFAULT NULL,
  `cm_fax` varchar(10) DEFAULT NULL,
  `cm_email` varchar(50) DEFAULT NULL,
  `cm_url` varchar(50) DEFAULT NULL,
  `cm_status` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cm_supplierid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cm_suppliermaster`
--

INSERT INTO `cm_suppliermaster` (`cm_supplierid`, `cm_group`, `cm_orgname`, `cm_address`, `cm_district`, `cm_post`, `cm_policest`, `cm_postcode`, `cm_contactperson`, `cm_phone`, `cm_cellphone`, `cm_fax`, `cm_email`, `cm_url`, `cm_status`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
('AKG', 'SG01', 'Supplier Name', 'Gulshan ', 'Dhaka', 'Dhaka', 'Gulshan', '', 'Contact Name', '1223345465', '1223345465', '123', 'shahriar@gmail.com', 'shahriar.com.bd', '1', '2014-01-20 08:10:00', '0000-00-00 00:00:00', 'admin', ''),
('AMIT', 'SG01', 'Ahmed Shahriar Nazmul	', 'Uttara', 'Dhaka', 'DHAKA', 'Uttara', '1209', 'Ahmed Shahriar Nazmul	', '1223345465', '1223345465', '', 'shahriar@gmail.com', 'shahriar.com.bd', '1', '2014-01-15 10:35:00', '2014-01-15 10:47:00', 'admin', 'admin'),
('SE1', 'SG01', 'SELIM ', 'Dhaka', 'Dhaka', 'Dhaka', 'Dhaka', '1206', '111', '8801925533362', '8801925533362', '', 'selimppc@gmail.com', '', '1', '2014-01-27 12:44:00', '0000-00-00 00:00:00', 'admin', ''),
('SERE', 'SG01', 'Selim Reza', 'Kallanpur', 'Dhaka', 'Dhaka', 'Mirpur', '1216', 'Selim Reza', '01831803255', '01925533362', '', 'me@selimreza.com', 'www.selimreza.com', '1', '2014-01-15 10:30:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `cm_transaction`
--

CREATE TABLE IF NOT EXISTS `cm_transaction` (
  `cm_type` varchar(50) NOT NULL,
  `cm_trncode` varchar(50) NOT NULL,
  `cm_branch` varchar(50) DEFAULT NULL,
  `cm_lastnumber` int(11) DEFAULT NULL,
  `cm_increment` int(11) DEFAULT NULL,
  `cm_active` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cm_type`,`cm_trncode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cm_transaction`
--

INSERT INTO `cm_transaction` (`cm_type`, `cm_trncode`, `cm_branch`, `cm_lastnumber`, `cm_increment`, `cm_active`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
('Account Payable', 'APV-', 'Dhaka', 71, 1, 1, '2014-03-22 00:00:00', '2014-03-22 18:22:26', 'admin', NULL),
('GRN Number', 'GRN-', '', 0, 1, 1, '2013-12-27 11:45:00', '2014-03-18 14:06:00', 'admin', 'admin'),
('IM Transaction', 'PR--', '', 5, 1, 1, '2014-01-13 13:20:00', '2014-01-27 18:38:55', 'admin', 'admin'),
('IM Transaction', 'RE--', '', 6, 1, 1, '2014-01-02 15:17:00', '2014-01-30 19:02:19', 'admin', 'admin'),
('IM Transfer Number', 'IMTN', 'HE', 146, 1, 1, '2014-01-02 08:15:00', '2014-02-01 16:58:54', 'admin', ''),
('Invoice No', 'IN--', 'Dhaka', 246, 1, 1, '2014-02-18 00:00:00', '2014-03-19 21:20:55', 'admin', 'admin'),
('Money Receipt', 'MR--', 'Dhaka', 42, 1, 1, '2014-03-01 00:00:00', '2014-03-19 20:53:10', 'admin', NULL),
('Purchase Order Number', 'PORD', '', 5, 1, 1, '2014-03-18 13:10:00', '2014-03-23 18:44:53', 'admin', ''),
('Purchase Order Number1', 'RED', 'Dhaka', 123, 1, 1, '2013-12-22 10:01:00', '0000-00-00 00:00:00', 'admin', ''),
('Requisition Number', 'PORD', '', 0, 1, 1, '2013-12-04 11:14:00', '2014-03-18 13:08:00', 'admin', 'admin'),
('Requisition Number', 'RE', 'RE', 4, 1, 1, '2014-01-04 17:58:00', '2014-03-11 11:50:23', 'admin', ''),
('Sales Return', 'SR--', 'SR', 176, 1, 1, '2014-02-22 00:00:00', '2014-03-18 17:05:28', 'admin', NULL),
('Voucher No', 'INVC', '', 2, 1, 1, '2014-03-16 13:53:00', '2014-03-16 18:54:39', 'admin', ''),
('Voucher No', 'OB--', '', 8, 1, 1, '2014-03-08 13:47:00', '2014-03-11 19:19:59', 'admin', ''),
('Voucher No', 'PAY-', '', 9, 1, 1, '2014-03-10 13:29:00', '2014-03-16 18:11:13', 'admin', ''),
('Voucher No', 'VN--', '', 58, 1, 1, '2014-03-08 08:48:00', '2014-03-11 19:13:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `companyprofile`
--

CREATE TABLE IF NOT EXISTS `companyprofile` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `shortdescription` text NOT NULL,
  `longdescription` text NOT NULL,
  `photo` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `companyprofile`
--

INSERT INTO `companyprofile` (`id`, `title`, `shortdescription`, `longdescription`, `photo`) VALUES
(1, 'Welcome to Healthy Entrepreneurs', 'FOR GLOBAL HEALTH', 'Healthy Enterpreneurs is a young, creative and innovative company with 100% focus on business development with social impact. We aim to solve social problems throughy developing sound commercial business models. Our focus is specifically on promotion, training and supply chain solutions for healthcare related projects.', 'logo_he.png'),
(12, 'New Image', 'New Image', 'New Image', '8594-user.gif'),
(13, 'New Image', 'New Image', 'New Image', 'user.gif');

-- --------------------------------------------------------

--
-- Table structure for table `hr_personalinfo`
--

CREATE TABLE IF NOT EXISTS `hr_personalinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empid` varchar(50) DEFAULT NULL,
  `empname` varchar(150) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `doc` date DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `deptname` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `acccode` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `exchangerate` decimal(20,2) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `leaveplan` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `present` varchar(300) DEFAULT NULL,
  `parmanent` varchar(300) DEFAULT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(20) DEFAULT NULL,
  `updateuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empid` (`empid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `hr_personalinfo`
--

INSERT INTO `hr_personalinfo` (`id`, `empid`, `empname`, `doj`, `doc`, `grade`, `deptname`, `designation`, `bank`, `acccode`, `currency`, `exchangerate`, `amount`, `leaveplan`, `dob`, `gender`, `present`, `parmanent`, `cellno`, `phone`, `email`, `branch`, `status`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(1, '123', 'Selim Reza', '2014-03-23', '2014-03-23', 'A', 'ERP', 'Software Developer', 'SCB', '01', 'BDT', 1.00, 32000.00, '22', '1986-01-13', 'Male', 'Dhaka', 'Kushtia', '01831803255', '01925533362', 'me@selimreza.com', 'Dhaka', 'Open', '0000-00-00 00:00:00', '2014-03-23 11:39:00', '', 'admin'),
(2, 'I124', 'Selim Reza', '2014-03-23', '2014-03-23', 'A', 'ERP', 'Software Developer', 'SCB', '01', 'BDT', 1.00, 32000.00, '22', '1986-01-13', 'Male', 'Dh', 'K', '01831803255', '01925533362', 'me@selimreza.com', 'Dhaka', 'Open', '2014-03-23 11:36:00', '2014-03-23 11:40:00', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `hr_salarydetail`
--

CREATE TABLE IF NOT EXISTS `hr_salarydetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empid` varchar(50) DEFAULT NULL,
  `salarytype` varchar(50) DEFAULT NULL,
  `primeamt` decimal(20,2) DEFAULT NULL,
  `baseamt` decimal(20,2) DEFAULT NULL,
  `SIGN` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `transactionnum` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(20) DEFAULT NULL,
  `updateuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empid` (`empid`,`salarytype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `im_batchtransfer`
--

CREATE TABLE IF NOT EXISTS `im_batchtransfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `im_transfernum` varchar(50) DEFAULT NULL,
  `cm_code` varchar(50) DEFAULT NULL,
  `im_BatchNumber` varchar(50) DEFAULT NULL,
  `im_ExpDate` date DEFAULT NULL,
  `im_quantity` int(11) DEFAULT NULL,
  `im_unit` varchar(50) DEFAULT NULL,
  `im_rate` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `im_transfernum` (`im_transfernum`,`cm_code`,`im_BatchNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `im_grndetail`
--

CREATE TABLE IF NOT EXISTS `im_grndetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `im_grnnumber` varchar(50) DEFAULT NULL,
  `cm_code` varchar(50) DEFAULT NULL,
  `im_BatchNumber` varchar(50) DEFAULT NULL,
  `im_ExpireDate` date DEFAULT NULL,
  `im_RcvQuantity` int(11) DEFAULT NULL,
  `im_costprice` decimal(20,2) DEFAULT NULL,
  `im_unit` varchar(50) DEFAULT NULL,
  `im_unitqty` int(11) DEFAULT NULL,
  `im_rowamount` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `im_grnnumber` (`im_grnnumber`),
  KEY `cm_code` (`cm_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `im_grndetail`
--

INSERT INTO `im_grndetail` (`id`, `im_grnnumber`, `cm_code`, `im_BatchNumber`, `im_ExpireDate`, `im_RcvQuantity`, `im_costprice`, `im_unit`, `im_unitqty`, `im_rowamount`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(55, 'GR14016271', 'NOKIA01', '1111', '2014-01-20', 11, 1100.00, 'UOM01', 12, 12100.00, '2014-01-19 18:20:00', '0000-00-00 00:00:00', 'admin', ''),
(56, 'GR14016271', 'NOKIA01', '1111', '2014-01-20', 11, 1100.00, 'UOM01', 12, 12100.00, '2014-01-19 18:20:00', '0000-00-00 00:00:00', 'admin', ''),
(57, 'GR14016271', 'NOKIA01', '222', '2014-01-20', 2, 1100.00, 'UOM01', 12, 2200.00, '2014-01-19 18:21:00', '0000-00-00 00:00:00', 'admin', ''),
(58, 'GR14016271', 'SAM01', 'HHHH', '2014-01-20', 2, 9.00, 'UOM01', 9, 18.00, '2014-01-19 18:21:00', '0000-00-00 00:00:00', 'admin', ''),
(60, 'GR14016271', 'NOKIA01', 'TR', '2014-01-21', 2, 1100.00, 'UOM01', 12, 2200.00, '2014-01-20 09:53:00', '0000-00-00 00:00:00', 'admin', ''),
(61, 'GR14016271', 'NOKIA01', 'RT', '2014-01-21', 2, 1100.00, 'UOM01', 12, 2200.00, '2014-01-20 09:53:00', '0000-00-00 00:00:00', 'admin', ''),
(65, 'GR14016270', 'HPCOM01', 'eee', '2014-01-21', 12, 25000.00, 'UOM01', 12, 300000.00, '2014-01-20 09:59:00', '0000-00-00 00:00:00', 'admin', ''),
(66, 'GR14016272', 'LAPTOP', 'BB001', '2014-01-28', 10, 123.00, 'UOM01', 1, 1230.00, '2014-01-27 13:30:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `im_grnheader`
--

CREATE TABLE IF NOT EXISTS `im_grnheader` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `im_grnnumber` varchar(50) NOT NULL,
  `im_purordnum` varchar(50) DEFAULT NULL,
  `am_vouchernumber` varchar(50) DEFAULT NULL,
  `im_date` date DEFAULT NULL,
  `cm_supplierid` varchar(50) DEFAULT NULL,
  `pp_requisitionno` varchar(50) DEFAULT NULL,
  `im_payterms` varchar(50) DEFAULT NULL,
  `im_store` varchar(50) DEFAULT NULL,
  `im_taxrate` decimal(20,2) DEFAULT NULL,
  `im_taxamt` decimal(20,2) DEFAULT NULL,
  `im_discrate` decimal(20,2) DEFAULT NULL,
  `im_discamt` decimal(20,2) DEFAULT NULL,
  `im_currency` varchar(50) DEFAULT NULL,
  `im_amount` decimal(20,2) DEFAULT NULL,
  `im_netamt` decimal(20,2) DEFAULT NULL,
  `im_status` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `im_grnnumber` (`im_grnnumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `im_grnheader`
--

INSERT INTO `im_grnheader` (`id`, `im_grnnumber`, `im_purordnum`, `am_vouchernumber`, `im_date`, `cm_supplierid`, `pp_requisitionno`, `im_payterms`, `im_store`, `im_taxrate`, `im_taxamt`, `im_discrate`, `im_discamt`, `im_currency`, `im_amount`, `im_netamt`, `im_status`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(40, 'GR14016270', 'PO14000349', NULL, '2014-01-15', 'SERE', 'REQI000002', 'Credit', 'Kallanpur', NULL, NULL, 3.00, 0.00, 'TK', 608000.00, NULL, 'Open', '2014-01-15 16:09:18', NULL, 'admin', NULL),
(41, 'GR14016271', 'PO14000351', NULL, '2014-01-16', 'AMIT', 'REQI000003', 'Cash', 'Uttara', NULL, NULL, 0.00, 0.00, 'BDT', 12181.00, NULL, 'Confirmed', '2014-01-16 11:56:51', NULL, 'admin', NULL),
(42, 'GR14016272', 'PO14000375', NULL, '2014-01-27', 'AKG', '', 'Cash', 'Gulshan', NULL, NULL, 0.00, 0.00, 'TAKA', 1476.00, NULL, 'Confirmed', '2014-01-27 18:30:05', NULL, 'admin', NULL),
(43, 'GR14016273', 'PO14000372', NULL, '2014-02-01', 'AMIT', 'REQI000002', 'Cash', 'Uttara', NULL, NULL, 0.00, 0.00, 'BDT', 1369.00, NULL, 'Open', '2014-02-01 12:09:27', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `im_transaction`
--

CREATE TABLE IF NOT EXISTS `im_transaction` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `im_number` varchar(50) DEFAULT NULL,
  `cm_code` varchar(50) DEFAULT NULL,
  `im_storeid` varchar(50) DEFAULT NULL,
  `im_BatchNumber` varchar(50) DEFAULT NULL,
  `im_date` date DEFAULT NULL,
  `im_ExpireDate` date DEFAULT NULL,
  `im_quantity` int(11) DEFAULT NULL,
  `im_sign` int(11) DEFAULT NULL,
  `im_unit` varchar(50) DEFAULT NULL,
  `im_rate` decimal(20,2) DEFAULT NULL,
  `im_totalprice` decimal(20,2) DEFAULT NULL,
  `im_RefNumber` varchar(50) DEFAULT NULL,
  `im_RefRow` int(11) DEFAULT NULL,
  `im_note` varchar(250) DEFAULT NULL,
  `im_status` varchar(50) DEFAULT NULL,
  `im_voucherno` varchar(50) DEFAULT NULL,
  `cm_supplierid` varchar(50) DEFAULT NULL,
  `im_currency` varchar(50) DEFAULT NULL,
  `im_ExchangeRate` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `im_number` (`im_number`),
  KEY `cm_code` (`cm_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `im_transaction`
--

INSERT INTO `im_transaction` (`id`, `im_number`, `cm_code`, `im_storeid`, `im_BatchNumber`, `im_date`, `im_ExpireDate`, `im_quantity`, `im_sign`, `im_unit`, `im_rate`, `im_totalprice`, `im_RefNumber`, `im_RefRow`, `im_note`, `im_status`, `im_voucherno`, `cm_supplierid`, `im_currency`, `im_ExchangeRate`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(6, 'RE14000079', 'SAM01', 'Kallanpur', 'K01', '2014-01-15', '2014-01-16', 12, 1, 'UOM01', 12.00, 144.00, '', NULL, '', 'Open', '', '', '', 0.00, '2014-01-15 11:04:00', '0000-00-00 00:00:00', 'admin', ''),
(7, 'RE14000081', 'LAPTOP', 'Kallanpur', 'K02', '2014-01-15', '2014-01-16', 2, 1, 'UOM01', 2.00, 4.00, '', NULL, '', 'Open', '', '', '', 0.00, '2014-01-15 11:05:00', '0000-00-00 00:00:00', 'admin', ''),
(8, 'PR14000002', 'LAPTOP', 'Gulshan', 'Batch01', '2014-01-16', '2014-01-16', 10, 1, 'UOM01', 28000.00, 280000.00, 'GR14016270', 7, 'Goods Received From PO', 'Open', NULL, 'SERE', 'TK', NULL, '2014-01-16 13:34:46', NULL, 'admin', NULL),
(9, 'PR14000003', 'SAM01', 'Uttara', 'Br', '2014-01-16', '2014-01-17', 81, 1, 'UOM01', 1.00, 81.00, 'GR14016271', 8, 'Goods Received From PO', 'Open', NULL, 'AMIT', 'BDT', NULL, '2014-01-16 13:34:50', NULL, 'admin', NULL),
(10, 'PR14000004', 'SAM01', 'Uttara', 'Br', '2014-01-19', '2014-01-17', 81, 1, 'UOM01', 1.00, 81.00, 'GR14016271', 8, 'Goods Received From PO', 'Open', NULL, 'AMIT', 'BDT', NULL, '2014-01-19 18:45:46', NULL, 'admin', NULL),
(11, 'PR14000005', 'LAPTOP', 'Gulshan', 'BB001', '2014-01-27', '2014-01-28', 10, 1, 'UOM01', 123.00, 1230.00, 'GR14016272', 66, 'Goods Received From PO', 'Open', NULL, 'AKG', 'TAKA', NULL, '2014-01-27 18:38:55', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `im_transferdt`
--

CREATE TABLE IF NOT EXISTS `im_transferdt` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `im_transfernum` varchar(50) DEFAULT NULL,
  `cm_code` varchar(50) DEFAULT NULL,
  `im_unit` varchar(50) DEFAULT NULL,
  `im_quantity` int(11) DEFAULT NULL,
  `im_rate` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `im_transfernum` (`im_transfernum`,`cm_code`),
  KEY `cm_code` (`cm_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `im_transferdt`
--

INSERT INTO `im_transferdt` (`id`, `im_transfernum`, `cm_code`, `im_unit`, `im_quantity`, `im_rate`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(11, 'IM14000044', 'SAM01', 'UOM01', 10, 0.00, '2014-01-15 11:07:00', '0000-00-00 00:00:00', 'admin', ''),
(12, 'IM14000044', 'LAPTOP', 'UOM01', 3, 0.00, '2014-01-15 11:08:00', '0000-00-00 00:00:00', 'admin', ''),
(13, 'IM14000046', 'HPCOM01', 'UOM01', 3, 0.00, '2014-01-15 11:08:00', '0000-00-00 00:00:00', 'admin', ''),
(14, 'IM14000049', 'NOKIA01', 'UOM01', 34, 0.00, '2014-01-16 11:05:00', '0000-00-00 00:00:00', 'admin', ''),
(15, 'IM14000052', 'LAPTOP', 'UOM01', 12, 0.00, '2014-01-16 11:53:00', '0000-00-00 00:00:00', 'admin', ''),
(16, 'IM14000132', 'SAM01', 'UOM01', 5, 0.00, '2014-01-27 13:45:00', '0000-00-00 00:00:00', 'admin', ''),
(17, 'IM14000140', 'LAPTOP', 'UOM01', NULL, 0.00, '2014-01-29 09:00:00', '0000-00-00 00:00:00', 'admin', '');

--
-- Triggers `im_transferdt`
--
DROP TRIGGER IF EXISTS `tr_im_batchtransfer_delete`;
DELIMITER //
CREATE TRIGGER `tr_im_batchtransfer_delete` AFTER DELETE ON `im_transferdt`
 FOR EACH ROW BEGIN
			DELETE FROM im_BatchTransfer WHERE im_transfernum=old.im_transfernum AND cm_code=old.cm_code;
    END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_im_batchtransfer_insert`;
DELIMITER //
CREATE TRIGGER `tr_im_batchtransfer_insert` AFTER INSERT ON `im_transferdt`
 FOR EACH ROW BEGIN
			DECLARE v_FromStore VARCHAR(50);
			DECLARE v_IssueQty INT;
			DECLARE v_Date DATE;
			DECLARE v_Unit VARCHAR(50);
			
			DECLARE v_Batch VARCHAR(50);
			DECLARE v_ExpDate DATE;
			DECLARE v_Rate DECIMAL(20,2);
			DECLARE v_AvlQty INT;
			
			DECLARE No_DATA INT DEFAULT 0;
			
			DECLARE CurBatch CURSOR FOR
			SELECT im_BatchNumber,im_ExpireDate,im_rate,Available
			FROM im_vw_Stock
			WHERE cm_code=new.cm_code AND im_storeid=v_FromStore AND im_ExpireDate>v_Date AND Available>0
			GROUP BY im_ExpireDate;
			
			DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET NO_DATA=-2;
			DECLARE CONTINUE HANDLER FOR NOT FOUND SET NO_DATA=-1;
			
			SET v_IssueQty=new.im_quantity;
			SET v_Unit=new.im_unit;
			SELECT im_fromstore, im_date INTO v_FromStore, v_Date FROM im_transferhd WHERE im_transfernum=new.im_transfernum;
			
			OPEN CurBatch;
			FETCH FROM CurBatch INTO v_Batch, v_ExpDate, v_Rate, v_AvlQty;
			a: WHILE NO_DATA=0 DO -- 1
			
				IF v_AvlQty>=v_IssueQty THEN
					INSERT INTO im_BatchTransfer
					(im_transfernum, cm_code, im_BatchNumber, im_ExpDate, im_quantity, im_unit, im_rate, inserttime, insertuser)
					VALUES
					(new.im_transfernum, new.cm_code, v_Batch, v_ExpDate, v_IssueQty, v_Unit, v_Rate, CURRENT_TIMESTAMP,new.insertuser);
					LEAVE a;
				ELSEIF v_IssueQty>v_AvlQty THEN
					INSERT INTO im_BatchTransfer
					(im_transfernum, cm_code, im_BatchNumber, im_ExpDate, im_quantity, im_unit, im_rate, inserttime, insertuser)
					VALUES
					(new.im_transfernum, new.cm_code, v_Batch, v_ExpDate, v_AvlQty, v_Unit, v_Rate, CURRENT_TIMESTAMP,new.insertuser);
					SET v_IssueQty=v_IssueQty-v_AvlQty;
				END IF;
				
			FETCH FROM CurBatch INTO v_Batch, v_ExpDate, v_Rate, v_AvlQty;
			END WHILE; -- 1
			CLOSE CurBatch;
    END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_im_batchtransfer_update`;
DELIMITER //
CREATE TRIGGER `tr_im_batchtransfer_update` AFTER UPDATE ON `im_transferdt`
 FOR EACH ROW BEGIN
			DECLARE v_FromStore VARCHAR(50);
			DECLARE v_IssueQty INT;
			DECLARE v_Date DATE;
			DECLARE v_Unit VARCHAR(50);
			
			DECLARE v_Batch VARCHAR(50);
			DECLARE v_ExpDate DATE;
			DECLARE v_Rate DECIMAL(20,2);
			DECLARE v_AvlQty INT;
			
			DECLARE No_DATA INT DEFAULT 0;
			
			DECLARE CurBatch CURSOR FOR
			SELECT im_BatchNumber,im_ExpireDate,im_rate,Available
			FROM im_vw_Stock
			WHERE cm_code=new.cm_code AND im_storeid=v_FromStore AND im_ExpireDate>v_Date AND Available>0
			GROUP BY im_ExpireDate;
			
			DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET NO_DATA=-2;
			DECLARE CONTINUE HANDLER FOR NOT FOUND SET NO_DATA=-1;
			DELETE FROM im_BatchTransfer WHERE im_transfernum=old.im_transfernum AND cm_code=old.cm_code;
						
			SET v_IssueQty=new.im_quantity;
			SET v_Unit=new.im_unit;
			SELECT im_fromstore, im_date INTO v_FromStore, v_Date FROM im_transferhd WHERE im_transfernum=new.im_transfernum;
			
			OPEN CurBatch;
			FETCH FROM CurBatch INTO v_Batch, v_ExpDate, v_Rate, v_AvlQty;
			a: WHILE NO_DATA=0 DO -- 1
			
				IF v_AvlQty>=v_IssueQty THEN
					INSERT INTO im_BatchTransfer
					(im_transfernum, cm_code, im_BatchNumber, im_ExpDate, im_quantity, im_unit, im_rate, inserttime, insertuser)
					VALUES
					(new.im_transfernum, new.cm_code, v_Batch, v_ExpDate, v_IssueQty, v_Unit, v_Rate, CURRENT_TIMESTAMP,new.insertuser);
					LEAVE a;
				ELSEIF v_IssueQty>v_AvlQty THEN
					INSERT INTO im_BatchTransfer
					(im_transfernum, cm_code, im_BatchNumber, im_ExpDate, im_quantity, im_unit, im_rate, inserttime, insertuser)
					VALUES
					(new.im_transfernum, new.cm_code, v_Batch, v_ExpDate, v_AvlQty, v_Unit, v_Rate, CURRENT_TIMESTAMP,new.insertuser);
					SET v_IssueQty=v_IssueQty-v_AvlQty;
				END IF;
				
			FETCH FROM CurBatch INTO v_Batch, v_ExpDate, v_Rate, v_AvlQty;
			END WHILE; -- 1
			CLOSE CurBatch;
    END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `im_transferhd`
--

CREATE TABLE IF NOT EXISTS `im_transferhd` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `im_transfernum` varchar(50) DEFAULT NULL,
  `im_date` date DEFAULT NULL,
  `im_condate` date DEFAULT NULL,
  `im_note` varchar(250) DEFAULT NULL,
  `im_fromstore` varchar(50) DEFAULT NULL,
  `im_tostore` varchar(50) DEFAULT NULL,
  `im_status` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `im_transfernum` (`im_transfernum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `im_transferhd`
--

INSERT INTO `im_transferhd` (`id`, `im_transfernum`, `im_date`, `im_condate`, `im_note`, `im_fromstore`, `im_tostore`, `im_status`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(7, 'IM14000044', '2014-01-15', '2014-01-30', '', 'Uttara', 'Kallanpur', 'Confirmed', '2014-01-15 11:07:00', '0000-00-00 00:00:00', 'admin', ''),
(8, 'IM14000046', '2014-01-15', '2014-01-29', '', 'Uttara', 'Kallanpur', 'Confirmed', '2014-01-15 11:08:00', '0000-00-00 00:00:00', 'admin', ''),
(9, 'IM14000049', '2014-01-16', '2014-01-17', 'h', 'Uttara', 'Kallanpur', 'Confirmed', '2014-01-16 06:29:00', '0000-00-00 00:00:00', 'admin', ''),
(10, 'IM14000052', '2014-01-16', '2014-01-30', 'Confirmed', 'Uttara', 'Kallanpur', 'Open', '2014-01-16 11:53:00', '0000-00-00 00:00:00', 'admin', ''),
(11, 'IM14000126', '2014-01-19', '2014-01-31', 'Simple note', 'Main', 'Uttara', 'Open', '2014-01-19 11:35:00', '2014-01-19 11:40:00', 'admin', 'admin'),
(12, 'IM14000132', '2014-01-27', '2014-01-28', '', 'Main', 'Uttara', 'Confirmed', '2014-01-27 13:42:00', '0000-00-00 00:00:00', 'admin', ''),
(13, 'IM14000140', '2014-01-29', '2014-01-31', '', 'Gulshan', 'Gulshan', 'Open', '2014-01-29 09:00:00', '2014-01-29 09:01:00', 'admin', 'admin'),
(14, 'IM14000142', '2014-01-29', '2014-01-30', 'et', 'Gulshan', 'Uttara', 'Open', '2014-01-29 11:25:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `im_vw_grndetail`
--
CREATE TABLE IF NOT EXISTS `im_vw_grndetail` (
`id` int(20)
,`im_grnnumber` varchar(50)
,`im_purordnum` varchar(50)
,`cm_code` varchar(50)
,`cm_name` varchar(200)
,`im_BatchNumber` varchar(50)
,`im_ExpireDate` date
,`im_RcvQuantity` int(11)
,`im_costprice` decimal(20,2)
,`im_unit` varchar(50)
,`im_unitqty` int(11)
,`im_rowamount` decimal(20,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `im_vw_purchasedt`
--
CREATE TABLE IF NOT EXISTS `im_vw_purchasedt` (
`pp_purordnum` varchar(50)
,`cm_code` varchar(50)
,`cm_name` varchar(200)
,`pp_unit` varchar(50)
,`pp_unitqty` int(11)
,`pp_quantity` bigint(12)
,`pp_purchasrate` decimal(20,2)
,`pp_totalamount` decimal(29,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `im_vw_purchaseordhd`
--
CREATE TABLE IF NOT EXISTS `im_vw_purchaseordhd` (
`id` int(20)
,`pp_purordnum` varchar(50)
,`cm_supplierid` varchar(50)
,`cm_orgname` varchar(100)
,`Order_Date` date
,`Delivery_Date` date
,`pp_status` varchar(20)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `im_vw_stock`
--
CREATE TABLE IF NOT EXISTS `im_vw_stock` (
`cm_code` varchar(50)
,`cm_name` varchar(200)
,`im_BatchNumber` varchar(50)
,`im_ExpireDate` date
,`im_storeid` varchar(50)
,`im_rate` decimal(20,2)
,`im_unit` varchar(50)
,`issueqty` decimal(32,0)
,`saleqty` decimal(43,0)
,`inhandqty` decimal(42,0)
,`available` decimal(44,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `im_vw_transferissue`
--
CREATE TABLE IF NOT EXISTS `im_vw_transferissue` (
`ProCode` varchar(50)
,`Batch` varchar(50)
,`FromStore` varchar(50)
,`IssueQty` decimal(32,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `im_vw_transferre`
--
CREATE TABLE IF NOT EXISTS `im_vw_transferre` (
`ProCode` varchar(50)
,`Batch` varchar(50)
,`ToStore` varchar(50)
,`ReQty` decimal(32,0)
);
-- --------------------------------------------------------

--
-- Table structure for table `it_imtoap`
--

CREATE TABLE IF NOT EXISTS `it_imtoap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_group` varchar(50) NOT NULL,
  `sup_group` varchar(50) NOT NULL,
  `debit_account` varchar(50) NOT NULL,
  `active` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_group` (`item_group`),
  KEY `debit_account` (`debit_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pp_purchaseorddt`
--

CREATE TABLE IF NOT EXISTS `pp_purchaseorddt` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `pp_purordnum` varchar(50) NOT NULL,
  `cm_code` varchar(50) NOT NULL,
  `pp_quantity` int(11) DEFAULT NULL,
  `pp_grnqty` int(11) DEFAULT NULL,
  `pp_unit` varchar(50) DEFAULT NULL,
  `pp_unitqty` int(11) DEFAULT NULL,
  `pp_purchasrate` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_code` (`cm_code`),
  KEY `pp_purordnum` (`pp_purordnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Triggers `pp_purchaseorddt`
--
DROP TRIGGER IF EXISTS `tr_pp_PurchaseOrdDt_delete`;
DELIMITER //
CREATE TRIGGER `tr_pp_PurchaseOrdDt_delete` AFTER DELETE ON `pp_purchaseorddt`
 FOR EACH ROW BEGIN
			DECLARE vTotalAmount DECIMAL(20,2);
			
			SELECT IFNULL(SUM(pp_quantity*pp_purchasrate),0) INTO vTotalAmount FROM pp_purchaseorddt WHERE pp_purordnum=old.pp_purordnum;
			UPDATE pp_purchaseordhd SET pp_amount=vTotalAmount WHERE pp_purordnum=old.pp_purordnum;
    END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_pp_PurchaseOrdDt_insert`;
DELIMITER //
CREATE TRIGGER `tr_pp_PurchaseOrdDt_insert` AFTER INSERT ON `pp_purchaseorddt`
 FOR EACH ROW BEGIN
			DECLARE vTotalAmount DECIMAL(20,2);
			
			SELECT IFNULL(SUM(pp_quantity*pp_purchasrate),0) INTO vTotalAmount FROM pp_purchaseorddt WHERE pp_purordnum=new.pp_purordnum;
			UPDATE pp_purchaseordhd SET pp_amount=vTotalAmount WHERE pp_purordnum=new.pp_purordnum;
    END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_pp_PurchaseOrdDt_update`;
DELIMITER //
CREATE TRIGGER `tr_pp_PurchaseOrdDt_update` AFTER UPDATE ON `pp_purchaseorddt`
 FOR EACH ROW BEGIN
			DECLARE vTotalAmount DECIMAL(20,2);
			
			SELECT IFNULL(SUM(pp_quantity*pp_purchasrate),0) INTO vTotalAmount FROM pp_purchaseorddt WHERE pp_purordnum=new.pp_purordnum;
			UPDATE pp_purchaseordhd SET pp_amount=vTotalAmount WHERE pp_purordnum=new.pp_purordnum;
    END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pp_purchaseordhd`
--

CREATE TABLE IF NOT EXISTS `pp_purchaseordhd` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `pp_purordnum` varchar(50) NOT NULL,
  `pp_date` date DEFAULT NULL,
  `cm_supplierid` varchar(50) NOT NULL,
  `pp_requisitionno` varchar(50) DEFAULT NULL,
  `pp_payterms` varchar(500) DEFAULT NULL,
  `pp_deliverydate` date DEFAULT NULL,
  `pp_store` varchar(50) DEFAULT NULL,
  `pp_taxrate` decimal(20,2) DEFAULT NULL,
  `pp_taxamt` decimal(20,2) DEFAULT NULL,
  `pp_discrate` decimal(20,2) DEFAULT NULL,
  `pp_discamt` decimal(20,2) DEFAULT NULL,
  `pp_amount` decimal(20,2) DEFAULT NULL,
  `pp_netamt` decimal(20,2) DEFAULT NULL,
  `pp_status` varchar(20) DEFAULT NULL,
  `pp_currency` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pp_purordnum` (`pp_purordnum`),
  KEY `cm_supplierid` (`cm_supplierid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pp_requisitiondt`
--

CREATE TABLE IF NOT EXISTS `pp_requisitiondt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_requisitionno` varchar(50) NOT NULL,
  `cm_code` varchar(50) NOT NULL,
  `pp_unit` varchar(50) DEFAULT NULL,
  `pp_quantity` int(11) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_code` (`cm_code`),
  KEY `pp_requisitionno` (`pp_requisitionno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `pp_requisitiondt`
--

INSERT INTO `pp_requisitiondt` (`id`, `pp_requisitionno`, `cm_code`, `pp_unit`, `pp_quantity`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(101, 'REQI000002', 'SAM01', 'UOM01', 12, '2014-01-15 10:51:00', '0000-00-00 00:00:00', 'admin', ''),
(102, 'REQI000002', 'NOKIA01', 'UOM01', 23, '2014-01-15 10:51:00', '0000-00-00 00:00:00', 'admin', ''),
(103, 'REQI000003', 'LAPTOP', 'UOM01', 10, '2014-01-15 10:52:00', '0000-00-00 00:00:00', 'admin', ''),
(104, 'REQI000003', 'HPCOM01', 'UOM01', 12, '2014-01-15 10:52:00', '0000-00-00 00:00:00', 'admin', ''),
(105, 'REQI000003', 'LAPTOP', 'UOM01', 1, '2014-01-27 13:02:00', '0000-00-00 00:00:00', 'admin', ''),
(106, 'REQI000002', 'SAM01', 'UOM01', 23, '2014-01-29 11:18:00', '0000-00-00 00:00:00', 'admin', ''),
(107, 'REQI000003', 'TAB', 'UOM01', 12, '2014-01-29 11:53:00', '0000-00-00 00:00:00', 'admin', ''),
(108, 'REQI000002', 'LAPTOP', 'UOM01', 23, '2014-02-01 14:31:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `pp_requisitionhd`
--

CREATE TABLE IF NOT EXISTS `pp_requisitionhd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_requisitionno` varchar(50) NOT NULL,
  `cm_supplierid` varchar(50) DEFAULT NULL,
  `pp_date` date DEFAULT NULL,
  `pp_branch` varchar(50) DEFAULT NULL,
  `pp_note` varchar(250) DEFAULT NULL,
  `pp_status` varchar(50) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pp_requisitionno` (`pp_requisitionno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `pp_requisitionhd`
--

INSERT INTO `pp_requisitionhd` (`id`, `pp_requisitionno`, `cm_supplierid`, `pp_date`, `pp_branch`, `pp_note`, `pp_status`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(8, 'REQI000002', 'SERE', '2014-01-15', 'Kallanpur', 'note', 'Open', '2014-01-15 10:50:00', '2014-01-15 10:54:00', 'admin', 'admin'),
(9, 'REQI000003', 'SE1', '2014-01-27', 'Uttara', 'note+', 'Open', '2014-01-15 10:52:00', '2014-01-27 13:01:00', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`user_id`, `lastname`, `firstname`) VALUES
(1, 'Admin', 'Administrator'),
(2, 'Demo', 'Demo'),
(3, 'Reza', 'Selim'),
(4, 'sales', 'sales');

-- --------------------------------------------------------

--
-- Table structure for table `profiles_fields`
--

CREATE TABLE IF NOT EXISTS `profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `profiles_fields`
--

INSERT INTO `profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rights`
--

INSERT INTO `rights` (`itemname`, `type`, `weight`) VALUES
('admin', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sm_batchsale`
--

CREATE TABLE IF NOT EXISTS `sm_batchsale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sm_number` varchar(20) NOT NULL,
  `cm_code` varchar(50) NOT NULL,
  `sm_batchnumber` varchar(50) NOT NULL,
  `sm_expdate` date DEFAULT NULL,
  `sm_unit` varchar(20) DEFAULT NULL,
  `sm_quantity` int(11) DEFAULT NULL,
  `sm_bonusqty` int(11) DEFAULT NULL,
  `sm_rate` decimal(20,2) DEFAULT NULL,
  `sm_tax_rate` decimal(20,2) DEFAULT NULL,
  `sm_tax_amt` decimal(20,2) DEFAULT NULL,
  `sm_line_amt` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(20) DEFAULT NULL,
  `updateuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sm_number` (`sm_number`,`cm_code`,`sm_batchnumber`),
  KEY `cm_code` (`cm_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sm_batchsale`
--

INSERT INTO `sm_batchsale` (`id`, `sm_number`, `cm_code`, `sm_batchnumber`, `sm_expdate`, `sm_unit`, `sm_quantity`, `sm_bonusqty`, `sm_rate`, `sm_tax_rate`, `sm_tax_amt`, `sm_line_amt`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(1, 'SR14000164', 'SAM01', '44', '2014-11-11', 'UOM01', 11, NULL, 1200.00, 8.00, NULL, 13200.00, '2014-03-01 14:29:00', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sm_detail`
--

CREATE TABLE IF NOT EXISTS `sm_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sm_number` varchar(20) NOT NULL,
  `cm_code` varchar(50) DEFAULT NULL,
  `sm_unit` varchar(50) DEFAULT NULL,
  `sm_rate` decimal(20,2) DEFAULT NULL,
  `sm_bonusqty` int(11) DEFAULT NULL,
  `sm_quantity` int(11) DEFAULT NULL,
  `sm_tax_rate` decimal(20,2) DEFAULT NULL,
  `sm_tax_amt` decimal(20,2) DEFAULT NULL,
  `sm_lineamt` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(50) DEFAULT NULL,
  `updateuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sm_number` (`sm_number`,`cm_code`),
  KEY `cm_code` (`cm_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sm_detail`
--

INSERT INTO `sm_detail` (`id`, `sm_number`, `cm_code`, `sm_unit`, `sm_rate`, `sm_bonusqty`, `sm_quantity`, `sm_tax_rate`, `sm_tax_amt`, `sm_lineamt`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(3, 'IN14000222', 'SAM01', 'UOM01', 1200.00, NULL, 11, 8.00, 0.00, 13200.00, '2014-02-25 06:29:00', NULL, 'admin', NULL),
(4, 'IN14000222', 'LAPTOP', 'UOM01', 30000.00, NULL, 11, 4.00, 0.00, 330000.00, '2014-02-25 06:29:00', NULL, 'admin', NULL),
(5, 'SR14000020', 'SAM01', 'UOM01', 1200.00, NULL, 11, 8.00, 0.00, 13200.00, '2014-02-25 07:55:00', NULL, 'admin', NULL),
(6, 'SR14000152', 'LAPTOP', 'UOM01', 30000.00, NULL, 11, 4.00, 0.00, 330000.00, '2014-03-01 13:58:00', NULL, 'admin', NULL);

--
-- Triggers `sm_detail`
--
DROP TRIGGER IF EXISTS `tr_sm_batchsale_insert`;
DELIMITER //
CREATE TRIGGER `tr_sm_batchsale_insert` AFTER INSERT ON `sm_detail`
 FOR EACH ROW BEGIN
			DECLARE v_FromStore VARCHAR(50);
			DECLARE v_IssueQty INT;
			DECLARE v_BonusQty INT;
			DECLARE v_Date DATE;
			DECLARE v_Unit VARCHAR(50);
			
			DECLARE v_Batch VARCHAR(50);
			DECLARE v_ExpDate DATE;
			DECLARE v_Rate DECIMAL(20,2);
			DECLARE v_AvlQty INT;
			
			DECLARE No_DATA INT DEFAULT 0;
			
			DECLARE CurBatch CURSOR FOR
			SELECT im_BatchNumber,im_ExpireDate,im_rate,Available
			FROM im_vw_Stock
			WHERE cm_code=new.cm_code AND im_storeid=v_FromStore AND im_ExpireDate>v_Date AND Available>0
			GROUP BY im_ExpireDate;
			
			DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET NO_DATA=-2;
			DECLARE CONTINUE HANDLER FOR NOT FOUND SET NO_DATA=-1;
			
			SET v_BonusQty=new.sm_bonusqty;
			SET v_IssueQty=new.sm_quantity+new.sm_bonusqty;
			SET v_Unit=new.sm_unit;
			SELECT sm_storeid, sm_date INTO v_FromStore, v_Date FROM sm_header WHERE sm_number=new.sm_number;
			
			OPEN CurBatch;
			FETCH FROM CurBatch INTO v_Batch, v_ExpDate, v_Rate, v_AvlQty;
			a: WHILE NO_DATA=0 DO -- 1
			
				IF v_AvlQty>=v_IssueQty THEN -- 2
					INSERT INTO sm_batchsale(sm_number,cm_code,sm_batchnumber,sm_expdate,sm_unit,sm_quantity,
																	 sm_bonusqty,sm_rate,inserttime,insertuser)
					VALUES(new.sm_number,new.cm_code,v_Batch, v_ExpDate, v_Unit, (v_IssueQty-v_BonusQty),
									v_BonusQty, v_Rate,CURRENT_TIMESTAMP,new.insertuser);
					LEAVE a;
				ELSEIF v_IssueQty>v_AvlQty THEN
					INSERT INTO sm_batchsale(sm_number,cm_code,sm_batchnumber,sm_expdate,sm_unit,sm_quantity,
																	 sm_bonusqty,sm_rate,inserttime,insertuser)
					VALUES(new.sm_number,new.cm_code,v_Batch, v_ExpDate, v_Unit,
								 CASE WHEN v_AvlQty>v_BonusQty THEN (v_AvlQty-v_BonusQty) ELSE v_AvlQty END,
								 CASE WHEN v_AvlQty>v_BonusQty THEN v_BonusQty ELSE 0 END, 
								 v_Rate,CURRENT_TIMESTAMP,new.insertuser);
									
					IF v_AvlQty>v_BonusQty THEN -- 3
						SET v_IssueQty=v_IssueQty-v_AvlQty;
						SET v_BonusQty=0;
					ELSE
						SET v_IssueQty=v_IssueQty-v_AvlQty;
					END IF; -- 3
					
				END IF; -- 2
				
			FETCH FROM CurBatch INTO v_Batch, v_ExpDate, v_Rate, v_AvlQty;
			END WHILE; -- 1
			CLOSE CurBatch;
    END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sm_header`
--

CREATE TABLE IF NOT EXISTS `sm_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sm_number` varchar(20) DEFAULT NULL,
  `sm_date` date DEFAULT NULL,
  `cm_cuscode` varchar(20) DEFAULT NULL,
  `sm_sp` varchar(20) DEFAULT NULL,
  `sm_doc_type` varchar(20) DEFAULT NULL,
  `sm_storeid` varchar(20) DEFAULT NULL,
  `sm_territory` varchar(20) DEFAULT NULL,
  `sm_rsm` varchar(20) DEFAULT NULL,
  `sm_area` varchar(20) DEFAULT NULL,
  `sm_payterms` varchar(20) DEFAULT NULL,
  `am_accountcode` varchar(50) DEFAULT NULL,
  `sm_chequeno` varchar(50) DEFAULT NULL,
  `sm_totalamt` decimal(20,2) DEFAULT NULL,
  `sm_total_tax_amt` decimal(20,2) DEFAULT NULL,
  `sm_disc_rate` decimal(20,2) DEFAULT NULL,
  `sm_disc_amt` decimal(20,2) DEFAULT NULL,
  `sm_netamt` decimal(20,2) DEFAULT NULL,
  `sm_sign` int(11) DEFAULT NULL,
  `sm_stataus` varchar(20) DEFAULT NULL,
  `sm_refe_code` varchar(20) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(20) DEFAULT NULL,
  `updateuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sm_number` (`sm_number`),
  KEY `sm_date` (`sm_date`),
  KEY `cm_cuscode` (`cm_cuscode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `sm_header`
--

INSERT INTO `sm_header` (`id`, `sm_number`, `sm_date`, `cm_cuscode`, `sm_sp`, `sm_doc_type`, `sm_storeid`, `sm_territory`, `sm_rsm`, `sm_area`, `sm_payterms`, `am_accountcode`, `sm_chequeno`, `sm_totalamt`, `sm_total_tax_amt`, `sm_disc_rate`, `sm_disc_amt`, `sm_netamt`, `sm_sign`, `sm_stataus`, `sm_refe_code`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(2, 'IN14000222', '2014-02-25', 'S123', 'sp-3', 'Sales', 'Gulshan', NULL, NULL, NULL, 'Cash', NULL, NULL, 343200.00, 14256.00, 5.00, 17872.80, 339584.00, 1, 'Open', 'IN14000222', '2014-02-25 06:29:00', '0000-00-00 00:00:00', 'admin', ''),
(3, 'SR14000020', '2014-02-25', 'S123', 'sp-3', 'Return', 'Gulshan', NULL, NULL, NULL, NULL, NULL, NULL, 13200.00, 1056.00, NULL, 660.00, 13596.00, -1, 'Open', 'IN14000222', '2014-02-25 07:55:00', '0000-00-00 00:00:00', 'admin', ''),
(26, 'MR14000022', '2014-03-01', 'S123', 'Selim', 'Receipt', 'Gulshan', NULL, NULL, NULL, NULL, '', '', 320000.00, NULL, NULL, NULL, 320000.00, -1, 'Open', NULL, '2014-03-01 13:44:00', '0000-00-00 00:00:00', 'admin', ''),
(27, 'MR14000026', '2014-03-01', 'S123', 'Selim', 'Receipt', 'Gulshan', NULL, NULL, NULL, NULL, '', '', 5000.00, NULL, NULL, NULL, 5000.00, -1, 'Open', NULL, '2014-03-01 13:48:00', '0000-00-00 00:00:00', 'admin', ''),
(28, 'SR14000152', '2014-03-01', 'S123', 'sp-3', 'Return', 'Gulshan', NULL, NULL, NULL, NULL, NULL, NULL, 330000.00, 13200.00, NULL, 16500.00, 326700.00, -1, 'Open', 'IN14000222', '2014-03-01 13:58:00', '0000-00-00 00:00:00', 'admin', ''),
(29, 'SR14000161', '2014-03-01', 'S123', 'sp-3', 'Return', 'Gulshan', NULL, NULL, NULL, NULL, NULL, NULL, 13200.00, 1056.00, NULL, 660.00, 13596.00, -1, 'Open', 'IN14000222', '2014-03-01 14:27:00', '0000-00-00 00:00:00', 'admin', ''),
(31, 'SR14000164', '2014-03-01', 'S123', 'sp-3', 'Return', 'Gulshan', NULL, NULL, NULL, NULL, NULL, NULL, 13200.00, 1056.00, NULL, 660.00, 13596.00, -1, 'Open', 'IN14000222', '2014-03-01 14:29:00', '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `sm_invalc`
--

CREATE TABLE IF NOT EXISTS `sm_invalc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sm_number` varchar(20) DEFAULT NULL,
  `sm_invnumber` varchar(20) DEFAULT NULL,
  `sm_amount` decimal(20,2) DEFAULT NULL,
  `sm_balanceamt` decimal(20,2) DEFAULT NULL,
  `inserttime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `insertuser` varchar(20) DEFAULT NULL,
  `updateuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sm_number` (`sm_number`,`sm_invnumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `sm_invalc`
--

INSERT INTO `sm_invalc` (`id`, `sm_number`, `sm_invnumber`, `sm_amount`, `sm_balanceamt`, `inserttime`, `updatetime`, `insertuser`, `updateuser`) VALUES
(13, 'MR14000022', 'IN14000222', 320000.00, 3.00, '2014-03-01 13:44:00', NULL, 'admin', NULL),
(14, 'MR14000026', 'IN14000222', 5000.00, 5.00, '2014-03-01 13:48:00', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sm_vw_cusreceivable`
--
CREATE TABLE IF NOT EXISTS `sm_vw_cusreceivable` (
`cm_code` varchar(20)
,`cm_name` varchar(100)
,`cm_group` varchar(50)
,`cm_address` varchar(250)
,`cm_cellnumber` varchar(50)
,`sm_receivable` decimal(52,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `sm_vw_mralc`
--
CREATE TABLE IF NOT EXISTS `sm_vw_mralc` (
`sm_invnumber` varchar(20)
,`cm_cuscode` varchar(20)
,`sm_sign` int(11)
,`sm_rcvamt` decimal(20,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `sm_vw_mrrcv`
--
CREATE TABLE IF NOT EXISTS `sm_vw_mrrcv` (
`sm_invnumber` varchar(20)
,`cm_cuscode` varchar(20)
,`sm_amount` decimal(52,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `sm_vw_salealc`
--
CREATE TABLE IF NOT EXISTS `sm_vw_salealc` (
`sm_store` varchar(20)
,`sm_code` varchar(50)
,`sm_batchnumber` varchar(50)
,`sm_quantity` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE IF NOT EXISTS `tbl_reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `host` varchar(100) DEFAULT 'localhost',
  `bd` varchar(20) DEFAULT NULL,
  `ppal_table` varchar(40) NOT NULL,
  `field_key` varchar(40) NOT NULL,
  `sql_query` text,
  `toolbarfilter` int(1) DEFAULT '1',
  `show_title` int(1) DEFAULT '1',
  `manual` int(1) DEFAULT '0',
  `toppager` int(1) DEFAULT '1',
  `width` int(11) DEFAULT '99' COMMENT 'Porcentaje',
  `edit_inline` int(1) DEFAULT '1',
  `edit` int(1) DEFAULT '0',
  `insert_` int(1) DEFAULT '0',
  `delete_` int(1) DEFAULT '0',
  `status` int(1) DEFAULT '1' COMMENT '1 Activo, 0 Inactivo',
  `create_by` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_reports`
--

INSERT INTO `tbl_reports` (`report_id`, `report`, `description`, `host`, `bd`, `ppal_table`, `field_key`, `sql_query`, `toolbarfilter`, `show_title`, `manual`, `toppager`, `width`, `edit_inline`, `edit`, `insert_`, `delete_`, `status`, `create_by`, `create_date`, `modified_by`, `modified_date`) VALUES
(1, 'Informes', 'Informess', 'localhost', '', 'tbl_reports', 'report_id', '', 1, 1, 1, 1, 99, 1, 0, 0, 1, 1, NULL, NULL, NULL, NULL),
(2, 'Campos Informe', 'Campos Informe', 'localhost', '', 'tbl_reports_fields', 'field_id', NULL, 1, 0, 1, 1, 99, 1, 0, 0, 1, 1, NULL, NULL, NULL, NULL),
(4, 'ui', 'ui', 'localhost', 'ur', 'cm_productmaster', 'cm_code', '', 1, 1, 0, 1, 99, 1, 0, 0, 0, 1, 'admin', '2013-12-19 12:06:38', NULL, NULL);

--
-- Triggers `tbl_reports`
--
DROP TRIGGER IF EXISTS `tr_create_permission_reports`;
DELIMITER //
CREATE TRIGGER `tr_create_permission_reports` AFTER INSERT ON `tbl_reports`
 FOR EACH ROW CALL pr_create_permission_reports(NEW.report_id)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_reports_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL COMMENT 'Id del informe relacionado con la tabla tbl_informes',
  `table_field` varchar(100) NOT NULL COMMENT 'Nombre de la tabla del campo por lo general es la misma tabla principal ',
  `field` varchar(1000) NOT NULL COMMENT 'Campo tal cual se tomaría del select, puede incluir una sentencia compleja, IF, CASE ect., en ese se marca la casilla select_complejo como true',
  `alias` varchar(30) NOT NULL COMMENT 'alias único de la consulta',
  `label` varchar(500) NOT NULL COMMENT 'Titulo de la columna que se mostrará en la Grid',
  `field_find` varchar(100) NOT NULL COMMENT 'Columna con la tabla por la cual se hará la consulta aplica para cuando se quiere buscar por texto en tablas cruzadas',
  `align` varchar(10) DEFAULT 'left' COMMENT 'Alineación del campo left,rigth,center',
  `field_type_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Id del Tipo de campo que se encuentra en la tabla tbl_p_tipo_campo_form',
  `option_list` varchar(500) DEFAULT NULL COMMENT 'Opcione de las listas estáctica separadas por pipe |',
  `select_sql` varchar(500) DEFAULT NULL COMMENT 'SQL de la consulta a la tabla de opciones',
  `field_id_list` varchar(100) DEFAULT NULL COMMENT 'nombre del campo id del cual se toman los valores dela lista para los campos tipo lista_tabla',
  `field_desc_list` varchar(1000) DEFAULT NULL COMMENT 'nombre del campo descripción del cual se toman las descripción de la lista para los campos tipo lista_tabla',
  `select_complex` int(1) DEFAULT '0' COMMENT 'Si el campo "campo" contiene IF, CASE u otro tipo de sentencia que no sea el campo solo, se debe marcar como verdadero para que funcione la consulta',
  `function_aggregate` varchar(400) DEFAULT NULL COMMENT 'Si ejecuta alguna función agregada tipo MAX, COUNT etc',
  `foreign_table` varchar(40) DEFAULT NULL COMMENT 'Nombre de la tabla a la cual se realizará la relación con la tabla ingresada en el campo ''Tabla'' (LEFT JOIN)',
  `foreign_table_field_id` varchar(100) DEFAULT NULL COMMENT 'Nombre del campo por medio del cual se realiza la relación la relación con el campo ingresada en la opción ''Campo'' (Tabla.Campo = Tabla Foranea.Campo ID Tabla Foranea)',
  `foreign_table_desc` varchar(1000) DEFAULT NULL COMMENT 'Nombre del campo que se mostrará en la consulta',
  `select_filter` varchar(500) DEFAULT '' COMMENT 'En este campo se envia el select completo de la lista, , el primer campo se toma con el ID y el segundo como la Descripción',
  `comparison` varchar(2) DEFAULT 'eq' COMMENT '"eq" => "=","ne" => "<>", "lt" => "<", "le" => "<=","gt" => ">","ge" => ">="',
  `order_by` varchar(4) DEFAULT NULL COMMENT 'Solo se debe colocar el tipo ASC, DESC',
  `group_by` int(1) DEFAULT NULL COMMENT 'Determina si un campo se devuelve para hacer group by',
  `field_where` int(1) DEFAULT NULL COMMENT 'Indica si a una consulta se le aplica where a traves de éste campo',
  `find_form` int(1) DEFAULT NULL COMMENT 'Indica si es un filtro del formulario de busqueda',
  `show_in_grid` int(1) DEFAULT '1' COMMENT '1 Si, 0 No',
  `show_in_form` int(1) DEFAULT '0',
  `group_header` varchar(400) DEFAULT NULL COMMENT 'Nombre de la columna agrupadas a partir de esta',
  `group_header_columns` int(11) DEFAULT NULL COMMENT 'Número de columnas a agrupar a partir de esta',
  `frozen_column` int(1) DEFAULT NULL COMMENT 'Si la columna se inmoviliza cuando se desplazan a la derecha',
  `order_field` int(11) DEFAULT NULL COMMENT 'Orden en que se toman las variables',
  `width` int(5) DEFAULT NULL,
  `width_column` int(11) DEFAULT '10' COMMENT 'Ancho de la columna en la grid',
  `editable` int(1) DEFAULT '1' COMMENT 'Si el campo es editable o no 0 ó 1',
  `required` int(1) DEFAULT NULL COMMENT 'Si el campo es requerido al momento de la edición',
  `max_length` int(3) DEFAULT NULL COMMENT 'Longitud máxima del campo para cuando es edición',
  `val_min` int(11) DEFAULT NULL,
  `val_max` int(11) DEFAULT NULL,
  `expreg` varchar(100) DEFAULT NULL,
  `search` int(1) DEFAULT '1',
  `searchrules` varchar(300) DEFAULT NULL,
  `field_rel_id` int(11) DEFAULT NULL,
  `text_help` varchar(1500) DEFAULT NULL,
  `js` text,
  `readonly` int(11) DEFAULT '0',
  `defaultvalue` varchar(100) DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`field_id`),
  KEY `report_id` (`report_id`) USING BTREE,
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `tbl_reports_fields`
--

INSERT INTO `tbl_reports_fields` (`field_id`, `report_id`, `table_field`, `field`, `alias`, `label`, `field_find`, `align`, `field_type_id`, `option_list`, `select_sql`, `field_id_list`, `field_desc_list`, `select_complex`, `function_aggregate`, `foreign_table`, `foreign_table_field_id`, `foreign_table_desc`, `select_filter`, `comparison`, `order_by`, `group_by`, `field_where`, `find_form`, `show_in_grid`, `show_in_form`, `group_header`, `group_header_columns`, `frozen_column`, `order_field`, `width`, `width_column`, `editable`, `required`, `max_length`, `val_min`, `val_max`, `expreg`, `search`, `searchrules`, `field_rel_id`, `text_help`, `js`, `readonly`, `defaultvalue`, `create_by`, `create_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 'tbl_reports', 'report', 'report', 'Informe', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 1, NULL, NULL, NULL, 1, 40, 13, 1, 1, NULL, NULL, NULL, '[a-zA-Z0-9_.áéíóúÁÉÍÓÚ]', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'tbl_reports', 'description', 'description', 'Descripción', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 2, 40, 15, 1, 1, NULL, NULL, NULL, '[a-zA-Z0-9_.áéíóúÁÉÍÓÚ]', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(3, 1, 'tbl_reports', 'ppal_table', 'ppal_table', 'Tabla Ppal', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 3, 20, 15, 1, 1, NULL, NULL, NULL, '[a-zA-ZÑñ0-9 _]', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(4, 1, 'tbl_reports', 'field_key', 'field_key', 'Campo Clave', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 4, 15, 11, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(5, 1, 'tbl_reports', 'bd', 'bd', 'Base de Datos', '', 'left', 9, 'testdrive|TestDrive', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'eq', NULL, 0, 0, 0, 1, 1, NULL, NULL, NULL, 22, 30, 11, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(6, 1, 'tbl_reports', 'toppager', 'toppager', 'Paginación Top', '', 'left', 3, '', '', '', '', 0, '', '', '', '', '', 'eq', '', NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, 37, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(7, 1, 'tbl_reports', 'edit', 'editar', 'Editar', '', 'left', 3, '', '', '', '', 0, '', '', '', '', '', 'eq', '', NULL, NULL, NULL, 0, 1, '', NULL, NULL, 37, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'tbl_reports', 'insert_', 'insertar', 'Insertar', '', 'left', 3, '', '', '', '', 0, '', '', '', '', '', 'eq', '', NULL, NULL, NULL, 0, 1, '', NULL, NULL, 37, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(9, 1, 'tbl_reports', 'delete_', 'eliminar', 'Eliminar', '', 'left', 3, '', '', '', '', 0, '', '', '', '', '', 'eq', '', NULL, NULL, NULL, 0, 1, '', NULL, NULL, 37, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(10, 2, 'tbl_reports_fields', 'report_id', 'report_id', 'Informe', '', 'left', 10, NULL, 'SELECT report_id, report FROM tbl_reports', 'report_id', 'report', 0, NULL, 'tbl_reports', 'report_id', 'report', 'SELECT report_id, report FROM tbl_reports', NULL, NULL, NULL, 1, NULL, 1, 1, NULL, NULL, NULL, 1, NULL, 13, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(11, 2, 'tbl_reports_fields', 'table_field', 'table_field', 'Tabla', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, NULL, 1, 1, NULL, NULL, NULL, 2, NULL, 24, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(12, 2, 'tbl_reports_fields', 'field', 'field', 'Campo', '', 'left', 16, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, 'ASC', 0, 0, 0, 1, 1, NULL, NULL, NULL, 3, 50, 8, 1, 1, NULL, NULL, NULL, '[a-zA-Z0-9_.''(),-=]', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(13, 2, 'tbl_reports_fields', 'alias', 'alias', 'Alias', '', 'left', 12, '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 1, 1, NULL, NULL, NULL, 4, NULL, 10, 1, 1, NULL, NULL, NULL, '[a-zA-Z0-9_.]', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(14, 2, 'tbl_reports_fields', 'label', 'label', 'Label', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 0, 1, 1, NULL, NULL, NULL, 5, NULL, 8, 1, 1, NULL, NULL, NULL, '[a-zA-Z0-9_.áéíóúÁÉÍÓÚ]', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(15, 2, 'tbl_reports_fields', 'field_type_id', 'field_type_id', 'Tipo de Campo', '', 'left', 10, NULL, 'SELECT field_type_id, field_type  FROM tbl_reports_field_type', 'field_type_id', 'field_type', 0, '', 'tbl_reports_field_type', 'field_type_id', 'field_type', '', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 6, NULL, 10, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '//10 = lista_estatica\r\n//11 = lista_tabla\r\n$(''#tbl_informes_campo-opciones_lista'').attr(''disabled'',''disabled''); \r\n$(''#tbl_informes_campo-campo_id_lista'').val(''''); \r\n$(''#tbl_informes_campo-campo_id_lista'').attr(''disabled'',''disabled''); \r\n$(''#tbl_informes_campo-campo_desc_lista'').val(''''); \r\n$(''#tbl_informes_campo-campo_desc_lista'').attr(''disabled'',''disabled''); \r\n$(''#tbl_informes_campo-select_sql'').val(''''); \r\n$(''#tbl_informes_campo-select_sql'').attr(''disabled'',''disabled'');\r\n\r\nif($(''#tbl_informes_campo-tipo_campo_id'').val() == ''10''){\r\n  $(''#tbl_informes_campo-opciones_lista'').removeAttr(''disabled'');\r\n}else if($(''#tbl_informes_campo-tipo_campo_id'').val() == ''11''){ \r\n    $(''#tbl_informes_campo-opciones_lista'').val(''''); \r\n  $(''#tbl_informes_campo-campo_id_lista'').removeAttr(''disabled'');\r\n  $(''#tbl_informes_campo-campo_desc_lista'').removeAttr(''disabled'');\r\n  $(''#tbl_informes_campo-select_sql'').removeAttr(''disabled'');\r\n}', 0, NULL, NULL, NULL, NULL, NULL),
(16, 2, 'tbl_reports_fields', 'foreign_table', 'foreign_table', 'Tabla Foranea', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 24, NULL, 10, 1, NULL, NULL, NULL, NULL, '[a-zA-Z0-9_.]', 1, NULL, NULL, 'Nombre de la tabla a la cual se realizará la relación con la tabla ingresada en el campo ''Tabla'' (LEFT JOIN)', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(17, 2, 'tbl_reports_fields', 'foreign_table_field_id', 'foreign_table_field_id', 'Campo ID Tabla Foranea', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 25, NULL, 10, 1, NULL, NULL, NULL, NULL, '[a-zA-Z0-9_.]', 1, NULL, NULL, 'Nombre del campo por medio del cual se realiza la relación la relación con el campo ingresada en la opción ''Campo'' (Tabla.Campo = Tabla Foranea.Campo ID Tabla Foranea)', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(18, 2, 'tbl_reports_fields', 'foreign_table_desc', 'foreign_table_desc', 'Campo Desc. Tabla Foranea', '', 'left', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 26, NULL, 10, 1, NULL, NULL, NULL, NULL, '[a-zA-Z0-9_.]', 1, NULL, NULL, 'Nombre del campo que se mostrará en la consulta', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(19, 2, 'tbl_reports_fields', 'order_field', 'order_field', 'Orden', '', 'left', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 1, 1, NULL, NULL, NULL, 7, 4, 5, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(86, 4, 'cm_productmaster', 'cm_name', 'cm_name', 'Cm name', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(87, 4, 'cm_productmaster', 'cm_description', 'cm_description', 'Cm description', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 1, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(88, 4, 'cm_productmaster', 'cm_class', 'cm_class', 'Cm class', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 2, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(89, 4, 'cm_productmaster', 'cm_group', 'cm_group', 'Cm group', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 3, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(90, 4, 'cm_productmaster', 'cm_category', 'cm_category', 'Cm category', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 4, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(91, 4, 'cm_productmaster', 'cm_sellrate', 'cm_sellrate', 'Cm sellrate', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 5, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(92, 4, 'cm_productmaster', 'cm_costprice', 'cm_costprice', 'Cm costprice', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 6, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(93, 4, 'cm_productmaster', 'cm_sellunit', 'cm_sellunit', 'Cm sellunit', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 7, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(94, 4, 'cm_productmaster', 'cm_sellconfact', 'cm_sellconfact', 'Cm sellconfact', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 8, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(95, 4, 'cm_productmaster', 'cm_purunit', 'cm_purunit', 'Cm purunit', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 9, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(96, 4, 'cm_productmaster', 'cm_purconfact', 'cm_purconfact', 'Cm purconfact', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 10, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(97, 4, 'cm_productmaster', 'cm_stkunit', 'cm_stkunit', 'Cm stkunit', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 11, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(98, 4, 'cm_productmaster', 'cm_stkconfac', 'cm_stkconfac', 'Cm stkconfac', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 12, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(99, 4, 'cm_productmaster', 'cm_packsize', 'cm_packsize', 'Cm packsize', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 13, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(100, 4, 'cm_productmaster', 'cm_stocktype', 'cm_stocktype', 'Cm stocktype', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 14, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(101, 4, 'cm_productmaster', 'cm_generic', 'cm_generic', 'Cm generic', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 15, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(102, 4, 'cm_productmaster', 'cm_supplierid', 'cm_supplierid', 'Cm supplierid', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 16, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(103, 4, 'cm_productmaster', 'cm_mfgcode', 'cm_mfgcode', 'Cm mfgcode', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 17, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(104, 4, 'cm_productmaster', 'cm_maxlevel', 'cm_maxlevel', 'Cm maxlevel', '', 'left', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 18, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(105, 4, 'cm_productmaster', 'cm_minlevel', 'cm_minlevel', 'Cm minlevel', '', 'left', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 19, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(106, 4, 'cm_productmaster', 'cm_reorder', 'cm_reorder', 'Cm reorder', '', 'left', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 20, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(107, 4, 'cm_productmaster', 'inserttime', 'inserttime', 'Inserttime', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 21, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(108, 4, 'cm_productmaster', 'updatetime', 'updatetime', 'Updatetime', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 22, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(109, 4, 'cm_productmaster', 'insertuser', 'insertuser', 'Insertuser', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 23, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL),
(110, 4, 'cm_productmaster', 'updateuser', 'updateuser', 'Updateuser', '', 'left', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', 'eq', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 24, NULL, 10, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 'admin', '2013-12-19 12:06:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports_field_type`
--

CREATE TABLE IF NOT EXISTS `tbl_reports_field_type` (
  `field_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_type` varchar(255) DEFAULT NULL,
  `searchtype` varchar(100) DEFAULT NULL,
  `expreg` varchar(50) DEFAULT NULL,
  `msg_expreg` varchar(255) DEFAULT NULL,
  `comparisons` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`field_type_id`),
  UNIQUE KEY `tipo_campo_id` (`field_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_reports_field_type`
--

INSERT INTO `tbl_reports_field_type` (`field_type_id`, `field_type`, `searchtype`, `expreg`, `msg_expreg`, `comparisons`) VALUES
(1, 'alfabetico', 'text', '[a-zA-ZÑñ]', 'Debe ingresar solo letras', 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(2, 'alfanumerico', 'text', '[a-zA-ZÑñ0-9]', 'Debe ingresar solo letras o números ', 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(3, 'checkbox', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(4, 'email', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(5, 'date', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(6, 'float', 'number', NULL, NULL, 'eq,ne,lt,le,gt,ge,in,ni'),
(7, 'hidden', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(8, 'html', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(9, 'combox_array', 'text', NULL, NULL, 'eq'),
(10, 'combox_table', 'text', NULL, NULL, 'eq'),
(11, 'numeric', 'number', '[0-9]', 'Debe ingresar solo números', 'eq,ne,lt,le,gt,ge,in,ni'),
(12, 'text', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(13, 'currency', 'number', NULL, NULL, 'eq,ne,lt,le,gt,ge,in,ni'),
(14, 'password', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(15, 'radio', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(16, 'textarea', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(17, 'observations', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(18, 'checkboxMultiple', 'text', NULL, NULL, 'cn,nc,eq,bw,bn,ni,ew,en,in,ni'),
(19, 'percentaje', 'number', NULL, NULL, 'eq,ne,lt,le,gt,ge,in,ni'),
(20, 'combox_autocomple', 'text', NULL, NULL, 'eq'),
(21, 'currency_no_decimals', 'number', NULL, NULL, 'eq,ne,lt,le,gt,ge,in,ni');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports_permissions`
--

CREATE TABLE IF NOT EXISTS `tbl_reports_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `view_` int(1) DEFAULT '1',
  `insert_` int(1) DEFAULT '1',
  `edit` int(1) DEFAULT '1',
  `delete_` int(1) DEFAULT '1',
  `excel` int(1) DEFAULT '1',
  `pdf` int(1) DEFAULT '1',
  `word` int(1) DEFAULT '1',
  `txt` int(1) DEFAULT '1',
  `edit_label` int(1) DEFAULT '0',
  `edit_help` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_id` (`report_id`,`username`) USING BTREE,
  KEY `usuario_id` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_reports_permissions`
--

INSERT INTO `tbl_reports_permissions` (`id`, `report_id`, `username`, `view_`, `insert_`, `edit`, `delete_`, `excel`, `pdf`, `word`, `txt`, `edit_label`, `edit_help`) VALUES
(1, 1, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0),
(2, 2, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0),
(3, 4, 'admin', 1, 0, 0, 0, 1, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports_permissions_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_reports_permissions_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `view_` int(1) DEFAULT '1',
  `insert_` int(1) DEFAULT '1',
  `edit` int(1) DEFAULT '1',
  `delete_` int(1) DEFAULT '1',
  `excel` int(1) DEFAULT '1',
  `pdf` int(1) DEFAULT '1',
  `word` int(1) DEFAULT '1',
  `txt` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_id` (`report_id`,`rol_id`) USING BTREE,
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_reports_permissions_roles`
--

INSERT INTO `tbl_reports_permissions_roles` (`id`, `report_id`, `rol_id`, `view_`, `insert_`, `edit`, `delete_`, `excel`, `pdf`, `word`, `txt`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 4, 1, 1, 0, 0, 0, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`rol_id`, `rol`) VALUES
(1, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `username` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username` (`username`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`username`, `name`, `rol_id`) VALUES
('admin', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `employeeid` varchar(10) NOT NULL,
  `employeebranch` varchar(20) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `employeeid`, `employeebranch`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', 'admin', 'Gulshan', '9a24eff8c15a6a141ece27eb6947da0f', '2013-11-24 13:01:06', '2013-11-26 00:39:29', 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', 'demo', 'Uttara', '099f825543f7850cc038b90aaff39fac', '2013-11-24 13:01:06', '2014-03-12 06:11:19', 0, 1),
(3, 'selim', 'f48ac822376a54dbe8667a5b3a649058', 'me@selimreza.com', 'selim', 'Kallanpur', '4384f6ea25ed45e12be752b639e69328', '2013-11-24 08:38:23', '2014-01-19 05:29:29', 0, 1),
(4, 'sales', '9ed083b1436e5f40ef984b28255eef18', 'sales@sales.com', '', 'Mirpur', '756eba6e22ac730b4e2aa8dc2263b2c9', '2014-01-29 01:12:02', '0000-00-00 00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Structure for view `am_vw_apayable`
--
DROP TABLE IF EXISTS `am_vw_apayable`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `am_vw_apayable` AS select `a`.`am_subacccode` AS `suppliercode`,`b`.`cm_orgname` AS `suppliername`,`a`.`am_accountcode` AS `accoutcode`,`b`.`cm_contactperson` AS `conperson`,sum(abs(`a`.`am_baseamt`)) AS `payableamt` from (`am_voucherdetail` `a` join `cm_suppliermaster` `b` on((`a`.`am_subacccode` = `b`.`cm_supplierid`))) group by `a`.`am_subacccode`;

-- --------------------------------------------------------

--
-- Structure for view `am_vw_payinvc`
--
DROP TABLE IF EXISTS `am_vw_payinvc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `am_vw_payinvc` AS select `a`.`am_subacccode` AS `suppliercode`,`a`.`am_vouchernumber` AS `invoicnumber`,`a`.`am_currency` AS `currency`,`a`.`am_exchagerate` AS `exchange`,`a`.`am_primeamt` AS `primaamt`,`a`.`am_baseamt` AS `amount` from (`am_voucherdetail` `a` join `cm_suppliermaster` `b` on(((`a`.`am_subacccode` = `b`.`cm_supplierid`) and (left(`a`.`am_vouchernumber`,4) = 'INVC')))) union all select `d`.`am_subacccode` AS `am_subacccode`,`c`.`am_invnumber` AS `am_invnumber`,`c`.`am_currency` AS `am_currency`,`c`.`am_exchagerate` AS `am_exchagerate`,`c`.`am_primeamt` AS `am_primeamt`,`c`.`am_amount` AS `am_amount` from ((`am_apalc` `c` join `am_voucherdetail` `d` on((`c`.`am_vouchernumber` = `d`.`am_vouchernumber`))) join `cm_suppliermaster` `e` on((`d`.`am_subacccode` = `e`.`cm_supplierid`)));

-- --------------------------------------------------------

--
-- Structure for view `am_vw_unpaidinv`
--
DROP TABLE IF EXISTS `am_vw_unpaidinv`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `am_vw_unpaidinv` AS select `am_vw_payinvc`.`suppliercode` AS `suppliercode`,`am_vw_payinvc`.`invoicnumber` AS `invoicnumber`,`am_vw_payinvc`.`currency` AS `currency`,`am_vw_payinvc`.`exchange` AS `exchange`,abs(sum(`am_vw_payinvc`.`primaamt`)) AS `primaamt`,abs(sum(`am_vw_payinvc`.`amount`)) AS `amount` from `am_vw_payinvc` group by `am_vw_payinvc`.`suppliercode`,`am_vw_payinvc`.`invoicnumber` having (abs(sum(`am_vw_payinvc`.`amount`)) > 0);

-- --------------------------------------------------------

--
-- Structure for view `im_vw_grndetail`
--
DROP TABLE IF EXISTS `im_vw_grndetail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `im_vw_grndetail` AS select `a`.`id` AS `id`,`a`.`im_grnnumber` AS `im_grnnumber`,`c`.`im_purordnum` AS `im_purordnum`,`a`.`cm_code` AS `cm_code`,`b`.`cm_name` AS `cm_name`,`a`.`im_BatchNumber` AS `im_BatchNumber`,`a`.`im_ExpireDate` AS `im_ExpireDate`,`a`.`im_RcvQuantity` AS `im_RcvQuantity`,`a`.`im_costprice` AS `im_costprice`,`a`.`im_unit` AS `im_unit`,`a`.`im_unitqty` AS `im_unitqty`,`a`.`im_rowamount` AS `im_rowamount` from ((`im_grndetail` `a` join `cm_productmaster` `b` on((`a`.`cm_code` = `b`.`cm_code`))) join `im_grnheader` `c` on((`a`.`im_grnnumber` = `c`.`im_grnnumber`)));

-- --------------------------------------------------------

--
-- Structure for view `im_vw_purchasedt`
--
DROP TABLE IF EXISTS `im_vw_purchasedt`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `im_vw_purchasedt` AS select `a`.`pp_purordnum` AS `pp_purordnum`,`a`.`cm_code` AS `cm_code`,`b`.`cm_name` AS `cm_name`,`a`.`pp_unit` AS `pp_unit`,`a`.`pp_unitqty` AS `pp_unitqty`,(`a`.`pp_quantity` - ifnull(`a`.`pp_grnqty`,0)) AS `pp_quantity`,`a`.`pp_purchasrate` AS `pp_purchasrate`,round((`a`.`pp_purchasrate` * `a`.`pp_quantity`),0) AS `pp_totalamount` from (`pp_purchaseorddt` `a` join `cm_productmaster` `b`) group by `a`.`pp_purordnum`,`a`.`cm_code` having (sum((`a`.`pp_quantity` - ifnull(`a`.`pp_grnqty`,0))) > 0);

-- --------------------------------------------------------

--
-- Structure for view `im_vw_purchaseordhd`
--
DROP TABLE IF EXISTS `im_vw_purchaseordhd`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `im_vw_purchaseordhd` AS select `a`.`id` AS `id`,`a`.`pp_purordnum` AS `pp_purordnum`,`a`.`cm_supplierid` AS `cm_supplierid`,`b`.`cm_orgname` AS `cm_orgname`,`a`.`pp_date` AS `Order_Date`,`a`.`pp_deliverydate` AS `Delivery_Date`,`a`.`pp_status` AS `pp_status` from (`pp_purchaseordhd` `a` join `cm_suppliermaster` `b` on((`a`.`cm_supplierid` = `b`.`cm_supplierid`))) where (`a`.`pp_status` in ('Approved','P-Received'));

-- --------------------------------------------------------

--
-- Structure for view `im_vw_stock`
--
DROP TABLE IF EXISTS `im_vw_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `im_vw_stock` AS select `a`.`cm_code` AS `cm_code`,`c`.`cm_name` AS `cm_name`,`a`.`im_BatchNumber` AS `im_BatchNumber`,`a`.`im_ExpireDate` AS `im_ExpireDate`,`a`.`im_storeid` AS `im_storeid`,`a`.`im_rate` AS `im_rate`,`a`.`im_unit` AS `im_unit`,ifnull(`b`.`IssueQty`,0) AS `issueqty`,ifnull(`d`.`sm_quantity`,0) AS `saleqty`,ifnull(sum(ifnull((`a`.`im_quantity` * `a`.`im_sign`),0)),0) AS `inhandqty`,ifnull(((sum(ifnull((`a`.`im_quantity` * `a`.`im_sign`),0)) - ifnull(`b`.`IssueQty`,0)) - ifnull(`d`.`sm_quantity`,0)),0) AS `available` from (((`im_transaction` `a` left join `im_vw_transferissue` `b` on(((`a`.`im_BatchNumber` = `b`.`Batch`) and (`a`.`im_storeid` = `b`.`FromStore`) and (`a`.`cm_code` = `b`.`ProCode`)))) left join `sm_vw_salealc` `d` on(((`a`.`im_BatchNumber` = `d`.`sm_batchnumber`) and (`a`.`im_storeid` = `d`.`sm_store`) and (`a`.`cm_code` = `d`.`sm_code`)))) left join `cm_productmaster` `c` on((`a`.`cm_code` = `c`.`cm_code`))) group by `a`.`im_ExpireDate`,`a`.`im_BatchNumber`,`a`.`im_storeid`;

-- --------------------------------------------------------

--
-- Structure for view `im_vw_transferissue`
--
DROP TABLE IF EXISTS `im_vw_transferissue`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `im_vw_transferissue` AS select `a`.`cm_code` AS `ProCode`,`a`.`im_BatchNumber` AS `Batch`,`b`.`im_fromstore` AS `FromStore`,sum(`a`.`im_quantity`) AS `IssueQty` from (`im_batchtransfer` `a` join `im_transferhd` `b` on((`a`.`im_transfernum` = `b`.`im_transfernum`))) where (`b`.`im_status` = 'Open') group by `a`.`cm_code`,`a`.`im_BatchNumber`,`b`.`im_tostore`;

-- --------------------------------------------------------

--
-- Structure for view `im_vw_transferre`
--
DROP TABLE IF EXISTS `im_vw_transferre`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `im_vw_transferre` AS select `a`.`cm_code` AS `ProCode`,`a`.`im_BatchNumber` AS `Batch`,`b`.`im_tostore` AS `ToStore`,sum(`a`.`im_quantity`) AS `ReQty` from (`im_batchtransfer` `a` join `im_transferhd` `b` on((`a`.`im_transfernum` = `b`.`im_transfernum`))) where (`b`.`im_status` = 'Open') group by `a`.`cm_code`,`a`.`im_BatchNumber`,`b`.`im_tostore`;

-- --------------------------------------------------------

--
-- Structure for view `sm_vw_cusreceivable`
--
DROP TABLE IF EXISTS `sm_vw_cusreceivable`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sm_vw_cusreceivable` AS select `a`.`cm_cuscode` AS `cm_code`,`b`.`cm_name` AS `cm_name`,`b`.`cm_group` AS `cm_group`,`b`.`cm_address` AS `cm_address`,`b`.`cm_cellnumber` AS `cm_cellnumber`,sum((`a`.`sm_netamt` * `a`.`sm_sign`)) AS `sm_receivable` from (`sm_header` `a` join `cm_customermst` `b` on((`a`.`cm_cuscode` = `b`.`cm_cuscode`))) group by `a`.`cm_cuscode`;

-- --------------------------------------------------------

--
-- Structure for view `sm_vw_mralc`
--
DROP TABLE IF EXISTS `sm_vw_mralc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sm_vw_mralc` AS select `sm_header`.`sm_refe_code` AS `sm_invnumber`,`sm_header`.`cm_cuscode` AS `cm_cuscode`,`sm_header`.`sm_sign` AS `sm_sign`,`sm_header`.`sm_netamt` AS `sm_rcvamt` from `sm_header` where (`sm_header`.`sm_doc_type` in ('Sales','Return')) union all select `b`.`sm_invnumber` AS `sm_invnumber`,`a`.`cm_cuscode` AS `cm_cuscode`,`a`.`sm_sign` AS `sm_sign`,`b`.`sm_amount` AS `sm_amount` from (`sm_header` `a` join `sm_invalc` `b` on(((`a`.`sm_number` = `b`.`sm_number`) and (`a`.`sm_doc_type` = 'Receipt'))));

-- --------------------------------------------------------

--
-- Structure for view `sm_vw_mrrcv`
--
DROP TABLE IF EXISTS `sm_vw_mrrcv`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sm_vw_mrrcv` AS select `sm_vw_mralc`.`sm_invnumber` AS `sm_invnumber`,`sm_vw_mralc`.`cm_cuscode` AS `cm_cuscode`,sum((`sm_vw_mralc`.`sm_sign` * `sm_vw_mralc`.`sm_rcvamt`)) AS `sm_amount` from `sm_vw_mralc` group by `sm_vw_mralc`.`sm_invnumber` having (sum((`sm_vw_mralc`.`sm_sign` * `sm_vw_mralc`.`sm_rcvamt`)) > 0);

-- --------------------------------------------------------

--
-- Structure for view `sm_vw_salealc`
--
DROP TABLE IF EXISTS `sm_vw_salealc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sm_vw_salealc` AS select `a`.`sm_storeid` AS `sm_store`,`b`.`cm_code` AS `sm_code`,`b`.`sm_batchnumber` AS `sm_batchnumber`,sum(((`b`.`sm_quantity` + ifnull(`b`.`sm_bonusqty`,0)) * `a`.`sm_sign`)) AS `sm_quantity` from (`sm_header` `a` join `sm_batchsale` `b` on(((`a`.`sm_number` = `b`.`sm_number`) and (`a`.`sm_doc_type` in ('Sales','Return'))))) group by `b`.`cm_code`,`b`.`sm_batchnumber`,`a`.`sm_storeid`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `am_apalc`
--
ALTER TABLE `am_apalc`
  ADD CONSTRAINT `am_apalc_ibfk_1` FOREIGN KEY (`am_vouchernumber`) REFERENCES `am_vouhcerheader` (`am_vouchernumber`);

--
-- Constraints for table `am_group_four`
--
ALTER TABLE `am_group_four`
  ADD CONSTRAINT `am_group_four_ibfk_1` FOREIGN KEY (`am_groupone`, `am_grouptwo`, `am_groupthree`) REFERENCES `am_group_three` (`am_groupone`, `am_grouptwo`, `am_groupthree`);

--
-- Constraints for table `am_group_three`
--
ALTER TABLE `am_group_three`
  ADD CONSTRAINT `am_group_three_ibfk_1` FOREIGN KEY (`am_groupone`, `am_grouptwo`) REFERENCES `am_group_two` (`am_groupone`, `am_grouptwo`);

--
-- Constraints for table `am_group_two`
--
ALTER TABLE `am_group_two`
  ADD CONSTRAINT `am_group_two_ibfk_1` FOREIGN KEY (`am_groupone`) REFERENCES `am_group_one` (`am_groupone`);

--
-- Constraints for table `am_voucherdetail`
--
ALTER TABLE `am_voucherdetail`
  ADD CONSTRAINT `am_voucherdetail_ibfk_1` FOREIGN KEY (`am_vouchernumber`) REFERENCES `am_vouhcerheader` (`am_vouchernumber`),
  ADD CONSTRAINT `am_voucherdetail_ibfk_2` FOREIGN KEY (`am_accountcode`) REFERENCES `am_chartofaccounts` (`am_accountcode`);

--
-- Constraints for table `authassignment`
--
ALTER TABLE `authassignment`
  ADD CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cm_branchcurrency`
--
ALTER TABLE `cm_branchcurrency`
  ADD CONSTRAINT `cm_branchcurrency_ibfk_1` FOREIGN KEY (`cm_branch`) REFERENCES `cm_branchmaster` (`cm_branch`);

--
-- Constraints for table `hr_salarydetail`
--
ALTER TABLE `hr_salarydetail`
  ADD CONSTRAINT `hr_salarydetail_ibfk_1` FOREIGN KEY (`empid`) REFERENCES `hr_personalinfo` (`empid`);

--
-- Constraints for table `im_batchtransfer`
--
ALTER TABLE `im_batchtransfer`
  ADD CONSTRAINT `im_batchtransfer_ibfk_1` FOREIGN KEY (`im_transfernum`) REFERENCES `im_transferhd` (`im_transfernum`);

--
-- Constraints for table `im_grndetail`
--
ALTER TABLE `im_grndetail`
  ADD CONSTRAINT `im_grndetail_ibfk_1` FOREIGN KEY (`im_grnnumber`) REFERENCES `im_grnheader` (`im_grnnumber`),
  ADD CONSTRAINT `im_grndetail_ibfk_2` FOREIGN KEY (`cm_code`) REFERENCES `cm_productmaster` (`cm_code`);

--
-- Constraints for table `im_transaction`
--
ALTER TABLE `im_transaction`
  ADD CONSTRAINT `im_transaction_ibfk_1` FOREIGN KEY (`cm_code`) REFERENCES `cm_productmaster` (`cm_code`);

--
-- Constraints for table `im_transferdt`
--
ALTER TABLE `im_transferdt`
  ADD CONSTRAINT `im_transferdt_ibfk_1` FOREIGN KEY (`im_transfernum`) REFERENCES `im_transferhd` (`im_transfernum`),
  ADD CONSTRAINT `im_transferdt_ibfk_2` FOREIGN KEY (`cm_code`) REFERENCES `cm_productmaster` (`cm_code`);

--
-- Constraints for table `pp_purchaseorddt`
--
ALTER TABLE `pp_purchaseorddt`
  ADD CONSTRAINT `pp_purchaseorddt_ibfk_1` FOREIGN KEY (`cm_code`) REFERENCES `cm_productmaster` (`cm_code`),
  ADD CONSTRAINT `pp_purchaseorddt_ibfk_2` FOREIGN KEY (`pp_purordnum`) REFERENCES `pp_purchaseordhd` (`pp_purordnum`);

--
-- Constraints for table `pp_purchaseordhd`
--
ALTER TABLE `pp_purchaseordhd`
  ADD CONSTRAINT `pp_purchaseordhd_ibfk_1` FOREIGN KEY (`cm_supplierid`) REFERENCES `cm_suppliermaster` (`cm_supplierid`);

--
-- Constraints for table `pp_requisitiondt`
--
ALTER TABLE `pp_requisitiondt`
  ADD CONSTRAINT `pp_requisitiondt_ibfk_1` FOREIGN KEY (`cm_code`) REFERENCES `cm_productmaster` (`cm_code`),
  ADD CONSTRAINT `pp_requisitiondt_ibfk_2` FOREIGN KEY (`pp_requisitionno`) REFERENCES `pp_requisitionhd` (`pp_requisitionno`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rights`
--
ALTER TABLE `rights`
  ADD CONSTRAINT `rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sm_batchsale`
--
ALTER TABLE `sm_batchsale`
  ADD CONSTRAINT `sm_batchsale_ibfk_1` FOREIGN KEY (`sm_number`) REFERENCES `sm_header` (`sm_number`),
  ADD CONSTRAINT `sm_batchsale_ibfk_2` FOREIGN KEY (`cm_code`) REFERENCES `cm_productmaster` (`cm_code`);

--
-- Constraints for table `sm_detail`
--
ALTER TABLE `sm_detail`
  ADD CONSTRAINT `sm_detail_ibfk_1` FOREIGN KEY (`cm_code`) REFERENCES `cm_productmaster` (`cm_code`),
  ADD CONSTRAINT `sm_detail_ibfk_2` FOREIGN KEY (`sm_number`) REFERENCES `sm_header` (`sm_number`);

--
-- Constraints for table `sm_header`
--
ALTER TABLE `sm_header`
  ADD CONSTRAINT `sm_header_ibfk_1` FOREIGN KEY (`cm_cuscode`) REFERENCES `cm_customermst` (`cm_cuscode`);

--
-- Constraints for table `sm_invalc`
--
ALTER TABLE `sm_invalc`
  ADD CONSTRAINT `sm_invalc_ibfk_1` FOREIGN KEY (`sm_number`) REFERENCES `sm_header` (`sm_number`);

--
-- Constraints for table `tbl_reports_fields`
--
ALTER TABLE `tbl_reports_fields`
  ADD CONSTRAINT `tbl_reports_fields_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `tbl_reports` (`report_id`),
  ADD CONSTRAINT `tbl_reports_fields_ibfk_2` FOREIGN KEY (`field_type_id`) REFERENCES `tbl_reports_field_type` (`field_type_id`);

--
-- Constraints for table `tbl_reports_permissions`
--
ALTER TABLE `tbl_reports_permissions`
  ADD CONSTRAINT `tbl_reports_permissions_ibfk_4` FOREIGN KEY (`report_id`) REFERENCES `tbl_reports` (`report_id`);

--
-- Constraints for table `tbl_reports_permissions_roles`
--
ALTER TABLE `tbl_reports_permissions_roles`
  ADD CONSTRAINT `tbl_reports_permissions_roles_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `tbl_roles` (`rol_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_reports_permissions_roles_ibfk_5` FOREIGN KEY (`report_id`) REFERENCES `tbl_reports` (`report_id`);

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `tbl_roles` (`rol_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
