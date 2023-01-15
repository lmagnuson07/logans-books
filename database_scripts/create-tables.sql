USE logans_books;

-- Drop Tables
DROP TABLE IF EXISTS book;
DROP TABLE IF EXISTS bookGenre;
DROP TABLE IF EXISTS bookCategory;
DROP TABLE IF EXISTS bookEdition;
DROP TABLE IF EXISTS bookAuthor;
DROP TABLE IF EXISTS bookPublisher;
DROP TABLE IF EXISTS bookPrice;

DROP TABLE IF EXISTS bookGenreDetail;
DROP TABLE IF EXISTS bookCategoryDetail;
DROP TABLE IF EXISTS bookEditionDetail;
DROP TABLE IF EXISTS bookAuthorDetail;
DROP TABLE IF EXISTS bookPublisherDetail;
DROP TABLE IF EXISTS bookPriceDetail;

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
CREATE TABLE IF NOT EXISTS bookGenre (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,name					VARCHAR(255)	NOT NULL
    ,description			TEXT			DEFAULT NULL	
);
-- 3
CREATE TABLE IF NOT EXISTS bookCategory (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,name					VARCHAR(255)	NOT NULL
    ,description			TEXT			DEFAULT NULL
);
-- 4
CREATE TABLE IF NOT EXISTS bookEdition (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,name					VARCHAR(255)	NOT NULL
    ,description			TEXT			DEFAULT NULL
);
-- 5
CREATE TABLE IF NOT EXISTS bookAuthor (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,first_name				VARCHAR(255)	NOT NULL	
    ,last_name				VARCHAR(255)	NOT NULL
    ,image_url				VARCHAR(255)	DEFAULT NULL
    ,email					VARCHAR(255)	DEFAULT NULL
);
-- 6
CREATE TABLE IF NOT EXISTS bookPublisher (
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
CREATE TABLE IF NOT EXISTS bookPrice (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY		
    ,historical_price		DECIMAL(10,4)	NOT NULL
    ,historical_price_date	DATETIME		NOT NULL
);
-- bridging tables
-- 1
CREATE TABLE IF NOT EXISTS bookGenreDetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,genre_id				INT 			NOT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS bookCategoryDetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,category_id			INT 			NOT NULL
);
-- 3
CREATE TABLE IF NOT EXISTS bookEditionDetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,edition_id				INT 			NOT NULL
);
-- 4
CREATE TABLE IF NOT EXISTS bookAuthorDetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,author_id				INT 			NOT NULL
);
-- 5
CREATE TABLE IF NOT EXISTS bookPublisherDetail (
    book_id				INT 			NOT NULL
    ,publisher_id		INT 			NOT NULL
    ,published_date		DATETIME		NOT NULL
    ,PRIMARY KEY(book_id, publisher_id)
);
-- 6
CREATE TABLE IF NOT EXISTS bookPriceDetail (
	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
    ,book_id				INT 			NOT NULL
    ,price_id				INT 			NOT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- Employee/Admin --------------------------------------------------------------------------------------
-- CREATE TABLE IF NOT EXISTS employee (
-- 	id						INT				NOT NULL	AUTO_INCREMENT	PRIMARY KEY
--     ,first_name				VARCHAR(255)	NOT NULL
--     ,last_name				VARCHAR(255)	NOT NULL
--     ,
-- );
























