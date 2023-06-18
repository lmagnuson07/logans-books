USE logans_books;

-- ---------------------------------------------------------------------------------------
-- ---------------------------------------------------------------------------------------
-- ------ books --------------------------------------------------------------------------
-- 1
ALTER TABLE authorphoto ADD CONSTRAINT fk_authorphoto_author_author_id
FOREIGN KEY (author_id) REFERENCES author(id);
-- bridging tables
-- 2
ALTER TABLE bookcontributiondetail ADD CONSTRAINT fk_contribution_book_contribution_id
FOREIGN KEY (contribution_id) REFERENCES contribution(id);
-- 3
ALTER TABLE bookcontributiondetail ADD CONSTRAINT fk_contribution_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 4 
ALTER TABLE bookcategorydetail ADD CONSTRAINT fk_category_book_category_id
FOREIGN KEY (category_id) REFERENCES category(id);
-- 5
ALTER TABLE bookcategorydetail ADD CONSTRAINT fk_category_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 6
ALTER TABLE authorcategorydetail ADD CONSTRAINT fk_category_author_category_id
FOREIGN KEY (category_id) REFERENCES category(id);
-- 7
ALTER TABLE authorcategorydetail ADD CONSTRAINT fk_category_author_author_id
FOREIGN KEY (author_id) REFERENCES author(id);
-- 8
ALTER TABLE bookauthordetail ADD CONSTRAINT fk_author_book_author_id
FOREIGN KEY (author_id) REFERENCES author(id);
-- 9
ALTER TABLE bookauthordetail ADD CONSTRAINT fk_author_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 10
ALTER TABLE bookseriesdetail ADD CONSTRAINT fk_series_book_series_id
FOREIGN KEY (series_id) REFERENCES series(id);
-- 11
ALTER TABLE bookseriesdetail ADD CONSTRAINT fk_series_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 12
ALTER TABLE publisherlocationdetail ADD CONSTRAINT fk_location_book_location_id
FOREIGN KEY (publisher_location_id) REFERENCES publisherlocation(id);
-- 13
ALTER TABLE publisherlocationdetail ADD CONSTRAINT fk_location_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 14
ALTER TABLE booklanguagedetail ADD CONSTRAINT fk_language_book_language_id
FOREIGN KEY (language_id) REFERENCES language(id);
-- 15
ALTER TABLE booklanguagedetail ADD CONSTRAINT fk_language_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 16
ALTER TABLE bookpublisherdetail ADD CONSTRAINT fk_publisher_book_publisher_id
FOREIGN KEY (publisher_id) REFERENCES publisher(id);
-- 17
ALTER TABLE bookpublisherdetail ADD CONSTRAINT fk_publisher_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- -----------------------------------------------------------------------------------------------------
-- residence ---------------------------------------------------------------------------------------
-- 1
ALTER TABLE region ADD CONSTRAINT fk_country_region_country_id
FOREIGN KEY (country_id) REFERENCES country(id);
-- 2
ALTER TABLE city ADD CONSTRAINT fk_region_city_region_id
FOREIGN KEY (region_id) REFERENCES region(id);
-- 3
ALTER TABLE city ADD CONSTRAINT fk_country_city_country_id
FOREIGN KEY (country_id) REFERENCES country(id);
-- 3
ALTER TABLE residence ADD CONSTRAINT fk_country_residence_country_id
FOREIGN KEY (country_id) REFERENCES country(id);
-- 3
ALTER TABLE residence ADD CONSTRAINT fk_state_residence_region_id
FOREIGN KEY (region_id) REFERENCES region(id);
-- 3
ALTER TABLE residence ADD CONSTRAINT fk_city_residence_city_id
FOREIGN KEY (city_id) REFERENCES city(id);
-- -----------------------------------------------------------------------------------------------------
-- admin -----------------------------------------------------------------------------------------------
-- 1
ALTER TABLE admin ADD CONSTRAINT fk_residence_admin_residence_id
FOREIGN KEY (residence_id) REFERENCES residence(id);
-- 2
ALTER TABLE admin ADD CONSTRAINT fk_access_level_admin_access_level_id
FOREIGN KEY (access_level_id) REFERENCES accesslevel(id);
-- -----------------------------------------------------------------------------------------------------
-- user ------------------------------------------------------------------------------------------------
-- 1
ALTER TABLE user ADD CONSTRAINT fk_residence_user_residence_id
FOREIGN KEY (residence_id) REFERENCES residence(id);
-- 2 	
ALTER TABLE bookshelf ADD CONSTRAINT fk_user_bookshelf_user_id
FOREIGN KEY (user_id) REFERENCES user(id);
-- 3 
ALTER TABLE bookshelfbookdetail ADD CONSTRAINT fk_bookshelf_book_bookshelf_id
FOREIGN KEY (bookshelf_id) REFERENCES bookshelf(id);
-- 4 
ALTER TABLE bookshelfbookdetail ADD CONSTRAINT fk_bookshelf_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- ----- Indexes ---------------------------------------------------------------------------------------
-- books
ALTER TABLE book ADD INDEX i_book_title (title);
-- residence
-- 1
ALTER TABLE country ADD INDEX i_country_country_code (country_code);
-- 2
ALTER TABLE region ADD INDEX i_region_region_code (region_code);
-- admin
ALTER TABLE admin ADD INDEX i_admin_username (username);
-- Customer/sale
ALTER TABLE user ADD INDEX i_user_username (username);
-- contribution
ALTER TABLE contribution ADD INDEX i_contribution_title (title);
-- category
ALTER TABLE category ADD INDEX i_category_title (title);
-- author
ALTER TABLE author ADD INDEX i_author_name (name);
-- series
ALTER TABLE series ADD INDEX i_series_title (title);
-- publisher location
ALTER TABLE publisherlocation ADD INDEX i_publisher_location_title (title);
-- language
ALTER TABLE language ADD INDEX i_language_title (title);
-- publisher
ALTER TABLE publisher ADD INDEX i_publisher_name (name);
-- ----- Unique ----------------------------------------------------------------------------------------
-- book
ALTER TABLE contribution ADD CONSTRAINT UNIQUE uc_contribution_title (title);
ALTER TABLE category ADD CONSTRAINT UNIQUE uc_category_title (title);
ALTER TABLE author ADD CONSTRAINT UNIQUE uc_author_name (name);
ALTER TABLE series ADD CONSTRAINT UNIQUE uc_series_title (title);
ALTER TABLE publisherlocation ADD CONSTRAINT UNIQUE uc_publisher_location_title (title);
ALTER TABLE language ADD CONSTRAINT UNIQUE uc_language_title (title);
ALTER TABLE publisher ADD CONSTRAINT UNIQUE uc_publisher_name (name);
ALTER TABLE bookauthordetail ADD CONSTRAINT UNIQUE uc_book_id_author_id (book_id, author_id);
-- residence
ALTER TABLE country ADD CONSTRAINT UNIQUE uc_country_country_code (country_code);
ALTER TABLE region ADD CONSTRAINT UNIQUE uc_region_region_code (region_code);
-- admin
ALTER TABLE admin ADD CONSTRAINT uc_admin_username UNIQUE (username);
-- Customer/sale
ALTER TABLE user ADD CONSTRAINT uc_user_username UNIQUE (username);
