USE logans_books;

-- ---------------------------------------------------------------------------------------
-- ---------------------------------------------------------------------------------------
-- ------ Books --------------------------------------------------------------------------
-- 1
ALTER TABLE AuthorPhoto ADD CONSTRAINT fk_authorphoto_author_author_id
FOREIGN KEY (author_id) REFERENCES Author(id);
-- bridging tables
-- 2
ALTER TABLE BookContributionDetail ADD CONSTRAINT fk_contribution_book_contribution_id
FOREIGN KEY (contribution_id) REFERENCES Contribution(id);
-- 3
ALTER TABLE BookContributionDetail ADD CONSTRAINT fk_contribution_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- 4 
ALTER TABLE BookCategoryDetail ADD CONSTRAINT fk_category_book_category_id
FOREIGN KEY (category_id) REFERENCES Category(id);
-- 5
ALTER TABLE BookCategoryDetail ADD CONSTRAINT fk_category_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- 6
ALTER TABLE AuthorCategoryDetail ADD CONSTRAINT fk_category_author_category_id
FOREIGN KEY (category_id) REFERENCES Category(id);
-- 7
ALTER TABLE AuthorCategoryDetail ADD CONSTRAINT fk_category_author_author_id
FOREIGN KEY (author_id) REFERENCES Author(id);
-- 8
ALTER TABLE BookAuthorDetail ADD CONSTRAINT fk_author_book_author_id
FOREIGN KEY (author_id) REFERENCES Author(id);
-- 9
ALTER TABLE BookAuthorDetail ADD CONSTRAINT fk_author_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- 10
ALTER TABLE BookSeriesDetail ADD CONSTRAINT fk_series_book_series_id
FOREIGN KEY (series_id) REFERENCES Series(id);
-- 11
ALTER TABLE BookSeriesDetail ADD CONSTRAINT fk_series_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- 12
ALTER TABLE PublisherLocationDetail ADD CONSTRAINT fk_location_book_location_id
FOREIGN KEY (publisher_location_id) REFERENCES PublisherLocation(id);
-- 13
ALTER TABLE PublisherLocationDetail ADD CONSTRAINT fk_location_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- 14
ALTER TABLE BookLanguageDetail ADD CONSTRAINT fk_language_book_language_id
FOREIGN KEY (language_id) REFERENCES Language(id);
-- 15
ALTER TABLE BookLanguageDetail ADD CONSTRAINT fk_language_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- 16
ALTER TABLE BookPublisherDetail ADD CONSTRAINT fk_publisher_book_publisher_id
FOREIGN KEY (publisher_id) REFERENCES publisher(id);
-- 17
ALTER TABLE BookPublisherDetail ADD CONSTRAINT fk_publisher_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- -----------------------------------------------------------------------------------------------------
-- Residence ---------------------------------------------------------------------------------------
-- 1
ALTER TABLE State ADD CONSTRAINT fk_country_state_country_id
FOREIGN KEY (country_id) REFERENCES Country(id);
-- 2
ALTER TABLE City ADD CONSTRAINT fk_state_city_state_id
FOREIGN KEY (state_id) REFERENCES State(id);
-- 3
ALTER TABLE City ADD CONSTRAINT fk_country_city_country_id
FOREIGN KEY (country_id) REFERENCES Country(id);
-- 3
ALTER TABLE Residence ADD CONSTRAINT fk_country_residence_country_id
FOREIGN KEY (country_id) REFERENCES Country(id);
-- 3
ALTER TABLE Residence ADD CONSTRAINT fk_state_residence_state_id
FOREIGN KEY (state_id) REFERENCES State(id);
-- 3
ALTER TABLE Residence ADD CONSTRAINT fk_city_residence_city_id
FOREIGN KEY (city_id) REFERENCES City(id);
-- -----------------------------------------------------------------------------------------------------
-- Admin -----------------------------------------------------------------------------------------------
-- 1
ALTER TABLE Admin ADD CONSTRAINT fk_residence_admin_residence_id
FOREIGN KEY (residence_id) REFERENCES Residence(id);
-- 2
ALTER TABLE Admin ADD CONSTRAINT fk_access_level_admin_access_level_id
FOREIGN KEY (access_level_id) REFERENCES AccessLevel(id);
-- -----------------------------------------------------------------------------------------------------
-- User ------------------------------------------------------------------------------------------------
-- 1
ALTER TABLE User ADD CONSTRAINT fk_residence_user_residence_id
FOREIGN KEY (residence_id) REFERENCES Residence(id);
-- 2 	
ALTER TABLE Bookshelf ADD CONSTRAINT fk_user_bookshelf_user_id
FOREIGN KEY (user_id) REFERENCES User(id);
-- 3 
ALTER TABLE BookshelfBookDetail ADD CONSTRAINT fk_bookshelf_book_bookshelf_id
FOREIGN KEY (bookshelf_id) REFERENCES Bookshelf(id);
-- 4 
ALTER TABLE BookshelfBookDetail ADD CONSTRAINT fk_bookshelf_book_book_id
FOREIGN KEY (book_id) REFERENCES Book(id);
-- ----- Indexes ---------------------------------------------------------------------------------------
-- Books
ALTER TABLE Book ADD INDEX i_book_title (title);
-- Residence
-- 1
ALTER TABLE Country ADD INDEX i_country_alpha_2_code (alpha_2_code);
-- 2
ALTER TABLE Country ADD INDEX i_country_alpha_3_code (alpha_3_code);
-- 3
ALTER TABLE State ADD INDEX i_state_state_code (code);
-- Employee
ALTER TABLE Admin ADD INDEX i_admin_username (username);
-- Customer/sale
ALTER TABLE User ADD INDEX i_user_username (username);
-- Contribution
ALTER TABLE Contribution ADD INDEX i_contribution_title (title);
-- Category
ALTER TABLE Category ADD INDEX i_category_title (title);
-- Author
ALTER TABLE Author ADD INDEX i_author_name (name);
-- Series
ALTER TABLE Series ADD INDEX i_series_title (title);
-- Publisher Location
ALTER TABLE PublisherLocation ADD INDEX i_publisher_location_title (title);
-- Language
ALTER TABLE Language ADD INDEX i_language_title (title);
-- Publisher
ALTER TABLE Publisher ADD INDEX i_publisher_name (name);
-- ----- Unique ----------------------------------------------------------------------------------------
-- book
ALTER TABLE Contribution ADD CONSTRAINT UNIQUE uc_contribution_title (title);
ALTER TABLE Category ADD CONSTRAINT UNIQUE uc_category_title (title);
ALTER TABLE Author ADD CONSTRAINT UNIQUE uc_author_name (name);
ALTER TABLE Series ADD CONSTRAINT UNIQUE uc_series_title (title);
ALTER TABLE PublisherLocation ADD CONSTRAINT UNIQUE uc_publisher_location_title (title);
ALTER TABLE Language ADD CONSTRAINT UNIQUE uc_language_title (title);
ALTER TABLE Publisher ADD CONSTRAINT UNIQUE uc_publisher_name (name);
ALTER TABLE BookAuthorDetail ADD CONSTRAINT UNIQUE uc_book_id_author_id (book_id, author_id);
-- residence
ALTER TABLE Country ADD CONSTRAINT UNIQUE uc_country_alpha_2_code (alpha_2_code);
ALTER TABLE Country ADD CONSTRAINT UNIQUE uc_country_alpha_3_code (alpha_3_code);
ALTER TABLE State ADD CONSTRAINT UNIQUE uc_state_state_code (code);
-- Employee
ALTER TABLE Admin ADD CONSTRAINT uc_admin_username UNIQUE (username);
-- Customer/sale
ALTER TABLE User ADD CONSTRAINT uc_user_username UNIQUE (username);
