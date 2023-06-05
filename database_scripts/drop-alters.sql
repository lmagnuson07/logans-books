USE logans_books;

-- ---------------------- Drop constraints -----------------------------------------------
-- Drop Foreign keys
ALTER TABLE AuthorPhoto DROP CONSTRAINT fk_authorphoto_author_author_id;
ALTER TABLE BookContributionDetail DROP CONSTRAINT fk_contribution_book_contribution_id;
ALTER TABLE BookContributionDetail DROP CONSTRAINT fk_contribution_book_book_id;
ALTER TABLE BookCategoryDetail DROP CONSTRAINT fk_category_book_category_id;
ALTER TABLE BookCategoryDetail DROP CONSTRAINT fk_category_book_book_id;
ALTER TABLE AuthorCategoryDetail DROP CONSTRAINT fk_category_author_category_id;
ALTER TABLE AuthorCategoryDetail DROP CONSTRAINT fk_category_author_author_id;
ALTER TABLE BookAuthorDetail DROP CONSTRAINT fk_author_book_author_id;
ALTER TABLE BookAuthorDetail DROP CONSTRAINT fk_author_book_book_id;
ALTER TABLE BookSeriesDetail DROP CONSTRAINT fk_series_book_series_id;
ALTER TABLE BookSeriesDetail DROP CONSTRAINT fk_series_book_book_id;
ALTER TABLE PublisherLocationDetail DROP CONSTRAINT fk_location_book_location_id;
ALTER TABLE PublisherLocationDetail DROP CONSTRAINT fk_location_book_book_id;
ALTER TABLE BookLanguageDetail DROP CONSTRAINT fk_language_book_language_id;
ALTER TABLE BookLanguageDetail DROP CONSTRAINT fk_language_book_book_id;
ALTER TABLE BookPublisherDetail DROP CONSTRAINT fk_publisher_book_publisher_id;
ALTER TABLE BookPublisherDetail DROP CONSTRAINT fk_publisher_book_book_id;

ALTER TABLE Region DROP CONSTRAINT fk_country_region_country_id;
ALTER TABLE City DROP CONSTRAINT fk_region_city_region_id;
ALTER TABLE City DROP CONSTRAINT fk_country_city_country_id;
ALTER TABLE Residence DROP CONSTRAINT fk_country_residence_country_id;
ALTER TABLE Residence DROP CONSTRAINT fk_state_residence_region_id;
ALTER TABLE Residence DROP CONSTRAINT fk_city_residence_city_id;

ALTER TABLE Admin DROP CONSTRAINT fk_residence_admin_residence_id;
ALTER TABLE Admin DROP CONSTRAINT fk_access_level_admin_access_level_id;

ALTER TABLE User DROP CONSTRAINT fk_residence_user_residence_id;
ALTER TABLE Bookshelf DROP CONSTRAINT fk_user_bookshelf_user_id;
ALTER TABLE BookshelfBookDetail DROP CONSTRAINT fk_bookshelf_book_bookshelf_id;
ALTER TABLE BookshelfBookDetail DROP CONSTRAINT fk_bookshelf_book_book_id;

-- Drop Indexes
ALTER TABLE Book DROP INDEX i_book_title;

ALTER TABLE Country DROP INDEX i_country_alpha_2_code;
ALTER TABLE Region DROP INDEX i_region_region_abbr;

ALTER TABLE Admin DROP INDEX i_admin_username;

ALTER TABLE User DROP INDEX i_user_username;
ALTER TABLE Contribution DROP INDEX i_contribution_title;
ALTER TABLE Category DROP INDEX i_category_title;
ALTER TABLE Author DROP INDEX i_author_name;
ALTER TABLE Series DROP INDEX i_series_title;
ALTER TABLE PublisherLocation DROP INDEX i_publisher_location_title;
ALTER TABLE Language DROP INDEX i_language_title;
ALTER TABLE Publisher DROP INDEX i_publisher_name;

-- Drop Unique
ALTER TABLE Contribution DROP CONSTRAINT uc_contribution_title;
ALTER TABLE Category DROP CONSTRAINT uc_category_title;
ALTER TABLE Author DROP CONSTRAINT uc_author_name;
ALTER TABLE Series DROP CONSTRAINT uc_series_title;
ALTER TABLE PublisherLocation DROP CONSTRAINT uc_publisher_location_title;
ALTER TABLE Language DROP CONSTRAINT uc_language_title;
ALTER TABLE Publisher DROP CONSTRAINT uc_publisher_name;
ALTER TABLE BookAuthorDetail DROP CONSTRAINT uc_book_id_author_id;

ALTER TABLE Country DROP CONSTRAINT uc_country_alpha_2_code;
ALTER TABLE Region DROP CONSTRAINT uc_region_region_abbr;

ALTER TABLE Admin DROP CONSTRAINT uc_admin_username;
ALTER TABLE User DROP CONSTRAINT uc_user_username;
