USE logans_books;

-- Drop Tables
DROP TABLE IF EXISTS book;
DROP TABLE IF EXISTS bookgenre;
DROP TABLE IF EXISTS bookcategory;
DROP TABLE IF EXISTS bookedition;
DROP TABLE IF EXISTS bookauthor;
DROP TABLE IF EXISTS bookpublisher;
DROP TABLE IF EXISTS bookprice;

DROP TABLE IF EXISTS bookgenredetail;
DROP TABLE IF EXISTS bookcategorydetail;
DROP TABLE IF EXISTS bookeditiondetail;
DROP TABLE IF EXISTS bookauthordetail;
DROP TABLE IF EXISTS bookpublisherdetail;
DROP TABLE IF EXISTS bookpricedetail;

DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS position;
DROP TABLE IF EXISTS employeepositiondetail;
DROP TABLE IF EXISTS employeemanagerdetail;

DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS coupon;
DROP TABLE IF EXISTS sale;
DROP TABLE IF EXISTS paymentcard;
DROP TABLE IF EXISTS salepaymentcarddetail;
DROP TABLE IF EXISTS salecoupondetail;
DROP TABLE IF EXISTS saleitemdetail;

-- --------- Books -----------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS book (
	id 						INT 			NOT NULL 		AUTO_INCREMENT 	PRIMARY KEY
    ,title 					VARCHAR(255) 	NOT NULL
    ,tageline				VARCHAR(255)	NOT NULL
	,synopsis				TEXT			NOT NULL
	,number_of_pages		int				NOT NULL
    ,language				VARCHAR(255)	NOT NULL
    ,format					VARCHAR(255)	NOT NULL
    ,cover_image_url		VARCHAR(255)	NOT NULL
    ,qty_in_stock			INT				DEFAULT NULL
    ,qty_on_order			INT				DEFAULT NULL
    ,current_price			DECIMAL(10,4)	DEFAULT NULL
    ,is_available			TINYINT			DEFAULT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS bookgenre (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,name					VARCHAR(255)	NOT NULL
    ,description			TEXT			DEFAULT NULL	
);
-- 3
CREATE TABLE IF NOT EXISTS bookcategory (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,name					VARCHAR(255)	NOT NULL
    ,description			TEXT			DEFAULT NULL
);
-- 4
CREATE TABLE IF NOT EXISTS bookedition (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,name					VARCHAR(255)	NOT NULL
    ,description			TEXT			DEFAULT NULL
);
-- 5
CREATE TABLE IF NOT EXISTS bookauthor (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,first_name				VARCHAR(255)	NOT NULL	
    ,last_name				VARCHAR(255)	NOT NULL
    ,image_url				VARCHAR(255)	DEFAULT NULL
    ,email					VARCHAR(255)	DEFAULT NULL
);
-- 6
CREATE TABLE IF NOT EXISTS bookpublisher (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY		
    ,name					VARCHAR(255)	NOT NULL	
    ,residence_id			INT				NOT NULL
    ,street_address			VARCHAR(255)	NOT NULL
    ,postal_code			VARCHAR(50)		NOT NULL
    ,website_url			VARCHAR(255)	DEFAULT NULL
    ,email					VARCHAR(255)	NOT NULL
	,phone					VARCHAR(50)		DEFAULT NULL
);
-- 7 
CREATE TABLE IF NOT EXISTS bookprice (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY		
    ,historical_price		DECIMAL(10,4)	NOT NULL
    ,historical_price_date	DATETIME		NOT NULL
);
-- bridging tables
-- 1
CREATE TABLE IF NOT EXISTS bookgenredetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,genre_id				INT 			NOT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS bookcategorydetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,category_id			INT 			NOT NULL
);
-- 3
CREATE TABLE IF NOT EXISTS bookeditiondetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,edition_id				INT 			NOT NULL
);
-- 4
CREATE TABLE IF NOT EXISTS bookauthordetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,author_id				INT 			NOT NULL
);
-- 5
CREATE TABLE IF NOT EXISTS bookpublisherdetail (
    book_id				INT 			NOT NULL
    ,publisher_id		INT 			NOT NULL
    ,published_date		DATETIME		NOT NULL
    ,PRIMARY KEY(book_id, publisher_id)
);
-- 6
CREATE TABLE IF NOT EXISTS bookpricedetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,price_id				INT 			NOT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- Employee/Admin --------------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS employee (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,first_name				VARCHAR(255)	NOT NULL
    ,last_name				VARCHAR(255)	NOT NULL
    ,resident_id			INT				NOT NULL
    ,street_address			VARCHAR(255)	NOT NULL	
    ,postal_code			VARCHAR(50)		NOT NULL
    ,email					VARCHAR(255)	NOT NULL	
    ,username				VARCHAR(255)	NOT NULL
    ,hashed_password		VARCHAR(255)	NOT NULL
    ,home_phone				VARCHAR(50)		DEFAULT NULL
    ,cell_phone				VARCHAR(50)		DEFAULT NULL
    ,date_hired				DATETIME		NOT NULL	DEFAULT (CURRENT_DATE)
    ,date_released			DATETIME		DEFAULT NULL
    ,emergency_contact_fn	VARCHAR(255)	DEFAULT NULL
    ,emergency_contact_ln	VARCHAR(255)	DEFAULT NULL
    ,emergency_contact_phone	VARCHAR(255)	DEFAULT NULL
    ,emergency_contact_relation	VARCHAR(255)	DEFAULT NULL
    ,is_admin				TINYINT			NOT NULL 	DEFAULT 0
);
-- 2
CREATE TABLE IF NOT EXISTS position (
	id						INT 			NOT NULL 	AUTO_INCREMENT	PRIMARY KEY
    ,description			VARCHAR(255)	NOT NULL
    ,privilege_level		TINYINT 		NOT NULL
);
-- Bridging tables
-- 1
CREATE TABLE IF NOT EXISTS employeepositiondetail (
	id						INT 			NOT NULL 	AUTO_INCREMENT	PRIMARY KEY
    ,employee_id			INT				NOT NULL
    ,position_id			INT				NOT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS employeemanagerdetail (
	id						INT 			NOT NULL 	AUTO_INCREMENT	PRIMARY KEY
    ,employee_id			INT				NOT NULL
    ,manager_id				INT 			NOT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- Customer - Sale --------------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS customer (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,first_name				VARCHAR(255)	NOT NULL
    ,last_name				VARCHAR(255)	NOT NULL
    ,resident_id			INT				NOT NULL
    ,street_address			VARCHAR(255)	NOT NULL	
    ,postal_code			VARCHAR(50)		NOT NULL
    ,email					VARCHAR(255)	NOT NULL	
    ,username				VARCHAR(255)	NOT NULL
    ,hashed_password		VARCHAR(255)	NOT NULL
    ,home_phone				VARCHAR(50)		DEFAULT NULL
    ,cell_phone				VARCHAR(50)		DEFAULT NULL
    ,prefered_contact_method	VARCHAR(50)	DEFAULT NULL
    ,security_question_one	VARCHAR(255)	NOT NULL
    ,security_answer_one	VARCHAR(255)	NOT NULL
    ,security_question_two	VARCHAR(255)	NOT NULL
    ,security_answer_two	VARCHAR(255) 	NOT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS coupon (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
	,code					VARCHAR(255)	NOT NULL
    ,description			TEXT			NOT NULL	
    ,type					VARCHAR(50)		NOT NULL
    ,discount_percentage	DECIMAL(4,4)	DEFAULT NULL
    ,discount_dollar_value	DECIMAL(10,4) 	DEFAULT NULL
    ,start_date				DATETIME		NOT NULL
    ,end_date				DATETIME		NOT NULL
);
-- 3
CREATE TABLE IF NOT EXISTS sale (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,date					DATETIME		NOT NULL 	DEFAULT (CURRENT_DATE)
    ,payment_type			VARCHAR(50)		NOT NULL	
    ,tax_amount				DECIMAL(10,4)	NOT NULL
    ,subtotal				DECIMAL(10,4)	NOT NULL
    ,employee_id			INT				DEFAULT NULL
    ,customer_id			INT				NOT NULL
);
-- 4
CREATE TABLE IF NOT EXISTS paymentcard (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,primary_account_number	VARCHAR(20)		NOT NULL
    ,service_code			VARCHAR(10)		NOT NULL
    ,expiration_date		DATE			NOT NULL
    ,cardholder_name		VARCHAR(255)	NOT NULL
	,payment_card_type		VARCHAR(50) 	NOT NULL
    ,customer_id			INT 			NOT NULL
);
-- Bridging tabes
-- 1
CREATE TABLE IF NOT EXISTS salepaymentcarddetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,sale_id				INT				NOT NULL
    ,payment_card_id		INT 			NOT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS salecoupondetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,sale_id				INT				NOT NULL
    ,coupon_id				INT 			NOT NULL
);
-- 3
CREATE TABLE IF NOT EXISTS saleitemdetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
	,selling_price			DECIMAL(10,4)	NOT NULL
    ,qty					INT 			NOT NULL
    ,sale_id				INT				NOT NULL
    ,book_id				INT 			NOT NULL
);












