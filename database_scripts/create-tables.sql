USE logans_books;

-- --------- Books -----------------------------------------------------------------------------------
-- ---------------------------------------------------------------------------------------------------
-- ---------------------------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS book (
	id 											INT 			NOT NULL 			AUTO_INCREMENT 	PRIMARY KEY
	,google_id									VARCHAR(255)	DEFAULT NULL
	,etag										VARCHAR(255)	DEFAULT NULL
  	,kind										VARCHAR(50)		DEFAULT NULL
	,country									VARCHAR(50)		DEFAULT NULL
    ,sale_country								VARCHAR(50)		DEFAULT NULL
	,title 										VARCHAR(255) 	DEFAULT NULL
	,subtitle									VARCHAR(255)	DEFAULT NULL
	,search_info_text							VARCHAR(1000)	DEFAULT NULL
	,by_statement								VARCHAR(1000)	DEFAULT NULL
	,published_date								DATETIME		DEFAULT NULL
	,created_date								DATETIME		DEFAULT NULL
	,last_modified_date							DATETIME		DEFAULT NULL
 	,revision									DOUBLE			DEFAULT NULL
	,latest_revision							DOUBLE 			DEFAULT NULL
	,works_last_modified_date					DATETIME		DEFAULT NULL
  	,works_revision								DOUBLE			DEFAULT NULL
  	,works_latest_revision						DOUBLE 			DEFAULT NULL
	,last_fetch_time							DATETIME		DEFAULT NULL
  	,description								VARCHAR(1000)	DEFAULT NULL
  	,oplib_description							VARCHAR(1000)	DEFAULT NULL
	,has_text 									BOOL			DEFAULT NULL
	,has_images									BOOL			DEFAULT NULL
	,page_count									INT				NOT NULL 			DEFAULT 0
	,print_type									VARCHAR(50)		DEFAULT NULL
	,content_version							VARCHAR(255)	DEFAULT NULL
	,average_rating								DOUBLE			DEFAULT NULL
	,rating_count								INT				DEFAULT NULL
	,maturity_rating							DOUBLE 			DEFAULT NULL
    ,industry_id1_type							VARCHAR(50)		DEFAULT NULL
	,industry_id1_key							VARCHAR(100)	DEFAULT NULL
	,industry_id2_type							VARCHAR(50)		DEFAULT NULL
	,industry_id2_key							VARCHAR(100)	DEFAULT NULL
    ,small_thumbnail_link						VARCHAR(500)	DEFAULT NULL
    ,thumbnail_link								VARCHAR(500) 	DEFAULT NULL
	,cover_ids									JSON			DEFAULT NULL
    ,google_preview_link                		VARCHAR(500) 	DEFAULT NULL
	,google_checkout_link             			VARCHAR(500) 	DEFAULT NULL
    ,google_payment_link			    		VARCHAR(500) 	DEFAULT NULL
	,backup_link								VARCHAR(500) 	DEFAULT NULL
	,is_ebook									BOOL			DEFAULT NULL
	,saleability								VARCHAR(255)	DEFAULT NULL
	,list_price_amount							DECIMAL(10,4)	DEFAULT NULL
    ,list_price_currency_mode					VARCHAR(50)		DEFAULT NULL
    ,list_price_amount_in_micros				INT				DEFAULT NULL
    ,retail_price_amount						DECIMAL(10,4)	DEFAULT NULL
    ,retail_price_currency_mode					VARCHAR(50) 	DEFAULT NULL
    ,retail_price_amount_in_micros				INT				DEFAULT NULL
    ,access_info_public_domain					BOOL			DEFAULT NULL
    ,access_info_viewability					VARCHAR(50)		DEFAULT NULL
	,access_info_embeddable						BOOL			DEFAULT NULL
    ,access_info_text_to_speech_permission		VARCHAR(50)		DEFAULT NULL
    ,access_info_quote_sharing_allowed			BOOL			DEFAULT NULL
    ,epub_available								BOOL			DEFAULT NULL
    ,epub_acs_token_link						VARCHAR(500) 	DEFAULT NULL
    ,pdf_available								BOOL			DEFAULT NULL
    ,pdf_acs_token_link							VARCHAR(500) 	DEFAULT NULL
    ,web_reader_link							VARCHAR(500) 	DEFAULT NULL
	,access_view_status							VARCHAR(50)		DEFAULT NULL
    ,quote_sharing_allowed						BOOL			DEFAULT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS category (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,title										VARCHAR(255)	NOT NULL
    ,last_fetch_time							DATETIME		NOT NULL			DEFAULT (CURRENT_DATE)
);
-- 3
CREATE TABLE IF NOT EXISTS contribution (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,title										VARCHAR(255)	NOT NULL
	,last_fetch_time							DATETIME		NOT NULL			DEFAULT (CURRENT_DATE)
);
-- 4
CREATE TABLE IF NOT EXISTS author (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,name										VARCHAR(255)	NOT NULL
    ,alternative_names							JSON			DEFAULT NULL
	,bio										VARCHAR(1000)	DEFAULT NULL
    ,birth_date									DATETIME		DEFAULT NULL
	,death_date									DATETIME		DEFAULT NULL
    ,top_work									VARCHAR(255)	DEFAULT NULL
	,work_count									INT				DEFAULT NULL
	,last_fetch_time							DATETIME		NOT NULL			DEFAULT (CURRENT_DATE)
);
-- 5
CREATE TABLE IF NOT EXISTS authorphoto (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,image_path									VARCHAR(500) 	NOT NULL
    ,author_id									INT				NOT NULL
);
-- 6
CREATE TABLE IF NOT EXISTS series (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,title										VARCHAR(255)	NOT NULL
	,last_fetch_time							DATETIME		NOT NULL			DEFAULT (CURRENT_DATE)
);
-- 7 
CREATE TABLE IF NOT EXISTS publisherlocation (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,title										VARCHAR(255)	NOT NULL
);
-- 8
CREATE TABLE IF NOT EXISTS language (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,title										VARCHAR(255) 	NOT NULL
	,last_fetch_time							DATETIME		NOT NULL			DEFAULT (CURRENT_DATE)
);
-- 9
CREATE TABLE IF NOT EXISTS publisher (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,name										VARCHAR(255) 	NOT NULL
	,last_fetch_time							DATETIME		NOT NULL			DEFAULT (CURRENT_DATE)
);
-- bridging tables
-- 10
CREATE TABLE IF NOT EXISTS bookcategorydetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,book_id									INT 			NOT NULL
    ,category_id								INT 			NOT NULL
);
-- 11
CREATE TABLE IF NOT EXISTS bookcontributiondetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,book_id									INT 			NOT NULL
    ,contribution_id							INT 			NOT NULL
);
-- 12
CREATE TABLE IF NOT EXISTS authorcategorydetail (
    id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,author_id									INT 			NOT NULL
    ,category_id								INT 			NOT NULL
);
-- 13
CREATE TABLE IF NOT EXISTS bookauthordetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,book_id									INT 			NOT NULL
    ,author_id									INT 			NOT NULL
);
-- 14
CREATE TABLE IF NOT EXISTS bookseriesdetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,book_id									INT 			NOT NULL
	,series_id									INT 			NOT NULL
);
-- 15
CREATE TABLE IF NOT EXISTS publisherlocationdetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,book_id									INT 			NOT NULL
	,publisher_location_id						INT 			NOT NULL
);
-- 16
CREATE TABLE IF NOT EXISTS booklanguagedetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,book_id									INT 			NOT NULL
	,language_id								INT 			NOT NULL
);
-- 17
CREATE TABLE IF NOT EXISTS bookpublisherdetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,book_id									INT 			NOT NULL
	,publisher_id								INT 			NOT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- Residence ------------------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS country (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,country_name								VARCHAR(255)	NOT NULL
    ,country_code								CHAR(2)			NOT NULL
   	,iso_code									CHAR(3)			DEFAULT NULL
   	,has_tir									BOOL			DEFAULT FALSE
   	,association_code							VARCHAR(50)		DEFAULT NULL
   	,national_association						VARCHAR(50)		DEFAULT NULL
    ,priority									INT				DEFAULT NULL
	,version									INT				NOT NULL			DEFAULT 0
    ,created_time								DATETIME		NOT NULL			DEFAULT (CURRENT_TIME)
	,updated_time								DATETIME		DEFAULT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS region (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,region_name								VARCHAR(255) 	NOT NULL
    ,region_code								VARCHAR(50)		DEFAULT NULL
    ,region_type								VARCHAR(255)	DEFAULT NULL
    ,country_id									INT				NOT NULL
	,priority									INT				DEFAULT NULL
);
-- 3
CREATE TABLE IF NOT EXISTS city (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,settlement_name							VARCHAR(255)	NOT NULL
    ,settlement_no_diacritics					VARCHAR(255)	DEFAULT NULL
	,settlement_local_name						VARCHAR(255)	DEFAULT NULL
	,settlement_local_no_diacritics				VARCHAR(255)	DEFAULT NULL
    ,settlement_code							VARCHAR(50)		NOT NULL
	,function_code								VARCHAR(50)		DEFAULT NULL
	,status_code								VARCHAR(50)		DEFAULT NULL
	,date										DATE			DEFAULT NULL
	,iata										VARCHAR(50)		DEFAULT NULL
	,coordinates								VARCHAR(50)		DEFAULT NULL
    ,division_code								VARCHAR(50)		DEFAULT NULL
	,major_city									BOOL			DEFAULT FALSE
    ,region_id									INT 			DEFAULT NULL
    ,country_id									INT 			NOT NULL
);
-- 4
CREATE TABLE IF NOT EXISTS residence (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,country_id									INT				NOT NULL
    ,region_id									INT				NOT NULL
    ,city_id									INT 			NOT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- Employee/Admin --------------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS admin (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,first_name									VARCHAR(255)	NOT NULL
    ,last_name									VARCHAR(255)	NOT NULL
    ,residence_id								INT				NOT NULL
    ,street_address								VARCHAR(255)	NOT NULL
    ,postal_code								VARCHAR(50)		NOT NULL
	,home_phone									VARCHAR(50)		DEFAULT NULL
	,cell_phone									VARCHAR(50)		DEFAULT NULL
	,security_question_one						VARCHAR(500) 	NOT NULL
    ,security_answer_one						VARCHAR(500)	NOT NULL
    ,security_question_two						VARCHAR(500)	NOT NULL
    ,security_answer_two						VARCHAR(500)	NOT NULL
    ,email										VARCHAR(255)	NOT NULL
    ,username									VARCHAR(255)	NOT NULL
    ,hashed_password							VARCHAR(255)	NOT NULL
    ,date_hired									DATETIME		NOT NULL			DEFAULT (CURRENT_DATE)
    ,date_released								DATETIME		DEFAULT NULL
    ,emergency_contact_fn						VARCHAR(255)	DEFAULT NULL
    ,emergency_contact_ln						VARCHAR(255)	DEFAULT NULL
    ,emergency_contact_phone					VARCHAR(255)	DEFAULT NULL
    ,emergency_contact_relation					VARCHAR(255)	DEFAULT NULL
	,access_level_id							INT				NOT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS accesslevel (
	id											INT 			NOT NULL 			AUTO_INCREMENT	PRIMARY KEY
    ,title										VARCHAR(255)	NOT NULL
    ,access_level								TINYINT 		NOT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- Customer - Sale -------------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS user (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
    ,first_name									VARCHAR(255)	NOT NULL
    ,last_name									VARCHAR(255)	NOT NULL
    ,residence_id								INT				NOT NULL
    ,street_address								VARCHAR(255)	NOT NULL
    ,postal_code								VARCHAR(50)		NOT NULL
    ,email										VARCHAR(255)	NOT NULL
    ,username									VARCHAR(255)	NOT NULL
    ,hashed_password							VARCHAR(255)	NOT NULL
    ,home_phone									VARCHAR(50)		DEFAULT NULL
    ,cell_phone									VARCHAR(50)		DEFAULT NULL
    ,preferred_contact_method					VARCHAR(50)		DEFAULT NULL
    ,security_question_one						VARCHAR(255)	NOT NULL
    ,security_answer_one						VARCHAR(255)	NOT NULL
    ,security_question_two						VARCHAR(255)	NOT NULL
    ,security_answer_two						VARCHAR(255) 	NOT NULL
);
-- 2
CREATE TABLE IF NOT EXISTS bookshelf (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,title										VARCHAR(255)	NOT NULL
    ,description								VARCHAR(1000)	NOT NULL
    ,tags										JSON			NOT NULL
    ,user_id									INT				DEFAULT NULL
);
-- Bridging tables
-- 3
CREATE TABLE IF NOT EXISTS bookshelfbookdetail (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,bookshelf_id								INT				NOT NULL
	,book_id									INT				NOT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- API links and endpoints -----------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS openlibbookendpoints (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,title										VARCHAR(255)	NOT NULL
	,base_url									VARCHAR(255)	NOT NULL
	,api_version								VARCHAR(50)		DEFAULT NULL
    ,api_endpoint								VARCHAR(255)	DEFAULT NULL
);
CREATE TABLE IF NOT EXISTS googlebookendpoints (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,title										VARCHAR(255)	NOT NULL
	,base_url									VARCHAR(255)	NOT NULL
	,api_version								VARCHAR(50)		DEFAULT NULL
	,api_endpoint								VARCHAR(255)	DEFAULT NULL
);
-- -----------------------------------------------------------------------------------------------------
-- Pagination ------------------------------------------------------------------------------------------
-- 1
CREATE TABLE IF NOT EXISTS pagination (
	id											INT				NOT NULL			AUTO_INCREMENT	PRIMARY KEY
	,google_api_start_index						INT				NOT NULL
	,google_api_max_results						INT				NOT NULL
	,oplib_offset								INT				DEFAULT NULL
	,oplib_limit								INT				DEFAULT NULL
);