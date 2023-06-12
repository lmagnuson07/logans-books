USE logans_books;

-- ---------------------- Drop constraints -----------------------------------------------
-- Drop Foreign keys
ALTER TABLE authorphoto DROP CONSTRAINT fk_authorphoto_author_author_id;
ALTER TABLE bookcontributiondetail DROP CONSTRAINT fk_contribution_book_contribution_id;
ALTER TABLE bookcontributiondetail DROP CONSTRAINT fk_contribution_book_book_id;
ALTER TABLE bookcategorydetail DROP CONSTRAINT fk_category_book_category_id;
ALTER TABLE bookcategorydetail DROP CONSTRAINT fk_category_book_book_id;
ALTER TABLE authorcategorydetail DROP CONSTRAINT fk_category_author_category_id;
ALTER TABLE authorcategorydetail DROP CONSTRAINT fk_category_author_author_id;
ALTER TABLE bookauthordetail DROP CONSTRAINT fk_author_book_author_id;
ALTER TABLE bookauthordetail DROP CONSTRAINT fk_author_book_book_id;
ALTER TABLE bookseriesdetail DROP CONSTRAINT fk_series_book_series_id;
ALTER TABLE bookseriesdetail DROP CONSTRAINT fk_series_book_book_id;
ALTER TABLE publisherlocationdetail DROP CONSTRAINT fk_location_book_location_id;
ALTER TABLE publisherlocationdetail DROP CONSTRAINT fk_location_book_book_id;
ALTER TABLE booklanguagedetail DROP CONSTRAINT fk_language_book_language_id;
ALTER TABLE booklanguagedetail DROP CONSTRAINT fk_language_book_book_id;
ALTER TABLE bookpublisherdetail DROP CONSTRAINT fk_publisher_book_publisher_id;
ALTER TABLE bookpublisherdetail DROP CONSTRAINT fk_publisher_book_book_id;

ALTER TABLE region DROP CONSTRAINT fk_country_region_country_id;
ALTER TABLE city DROP CONSTRAINT fk_region_city_region_id;
ALTER TABLE city DROP CONSTRAINT fk_country_city_country_id;
ALTER TABLE Residence DROP CONSTRAINT fk_country_residence_country_id;
ALTER TABLE Residence DROP CONSTRAINT fk_state_residence_region_id;
ALTER TABLE Residence DROP CONSTRAINT fk_city_residence_city_id;

ALTER TABLE admin DROP CONSTRAINT fk_residence_admin_residence_id;
ALTER TABLE admin DROP CONSTRAINT fk_access_level_admin_access_level_id;

ALTER TABLE user DROP CONSTRAINT fk_residence_user_residence_id;
ALTER TABLE bookshelf DROP CONSTRAINT fk_user_bookshelf_user_id;
ALTER TABLE bookshelfbookdetail DROP CONSTRAINT fk_bookshelf_book_bookshelf_id;
ALTER TABLE bookshelfbookdetail DROP CONSTRAINT fk_bookshelf_book_book_id;

-- Drop Indexes
ALTER TABLE book DROP INDEX i_book_title;

ALTER TABLE country DROP INDEX i_country_alpha_2_code;
ALTER TABLE region DROP INDEX i_region_region_abbr;

ALTER TABLE admin DROP INDEX i_admin_username;

ALTER TABLE user DROP INDEX i_user_username;
ALTER TABLE contribution DROP INDEX i_contribution_title;
ALTER TABLE category DROP INDEX i_category_title;
ALTER TABLE author DROP INDEX i_author_name;
ALTER TABLE series DROP INDEX i_series_title;
ALTER TABLE publisherlocation DROP INDEX i_publisher_location_title;
ALTER TABLE language DROP INDEX i_language_title;
ALTER TABLE publisher DROP INDEX i_publisher_name;

-- Drop Unique
ALTER TABLE contribution DROP CONSTRAINT uc_contribution_title;
ALTER TABLE category DROP CONSTRAINT uc_category_title;
ALTER TABLE author DROP CONSTRAINT uc_author_name;
ALTER TABLE series DROP CONSTRAINT uc_series_title;
ALTER TABLE publisherlocation DROP CONSTRAINT uc_publisher_location_title;
ALTER TABLE language DROP CONSTRAINT uc_language_title;
ALTER TABLE publisher DROP CONSTRAINT uc_publisher_name;
ALTER TABLE bookauthordetail DROP CONSTRAINT uc_book_id_author_id;

ALTER TABLE country DROP CONSTRAINT uc_country_alpha_2_code;
ALTER TABLE region DROP CONSTRAINT uc_region_region_abbr;

ALTER TABLE admin DROP CONSTRAINT uc_admin_username;
ALTER TABLE user DROP CONSTRAINT uc_user_username;
