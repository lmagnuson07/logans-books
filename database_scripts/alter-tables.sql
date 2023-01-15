USE logans_books;

-- ---------------------- Drop constraints -----------------------------------------------
-- Drop Foreign keys
ALTER TABLE bookpublisher DROP CONSTRAINT fk_publisher_residence_residence_id;
ALTER TABLE bookgenredetail DROP CONSTRAINT fk_genre_book_genre_id;
ALTER TABLE bookgenredetail DROP CONSTRAINT fk_genre_book_book_id;
ALTER TABLE bookcategorydetail DROP CONSTRAINT fk_category_book_category_id;
ALTER TABLE bookcategorydetail DROP CONSTRAINT fk_category_book_book_id;
ALTER TABLE bookeditiondetail DROP CONSTRAINT fk_edition_book_edition_id;
ALTER TABLE bookeditiondetail DROP CONSTRAINT fk_edition_book_book_id;
ALTER TABLE bookauthordetail DROP CONSTRAINT fk_author_book_author_id;
ALTER TABLE bookauthordetail DROP CONSTRAINT fk_author_book_book_id;
ALTER TABLE bookpublisherdetail DROP CONSTRAINT fk_publisher_book_publisher_id;
ALTER TABLE bookpublisherdetail DROP CONSTRAINT fk_publisher_book_book_id;
ALTER TABLE bookpricedetail DROP CONSTRAINT fk_price_book_price_id;
ALTER TABLE bookpricedetail DROP CONSTRAINT fk_price_book_book_id;

ALTER TABLE state DROP CONSTRAINT fk_country_state_country_id;
ALTER TABLE city DROP CONSTRAINT fk_state_city_state_id;
ALTER TABLE city DROP CONSTRAINT fk_country_city_country_id;
ALTER TABLE residence DROP CONSTRAINT fk_country_residence_country_id;
ALTER TABLE residence DROP CONSTRAINT fk_state_residence_state_id;
ALTER TABLE residence DROP CONSTRAINT fk_city_residence_state_id;

ALTER TABLE employee DROP CONSTRAINT fk_residence_employee_residence_id;
ALTER TABLE employeepositiondetail DROP CONSTRAINT fk_position_employee_position_id;
ALTER TABLE employeepositiondetail DROP CONSTRAINT fk_position_employee_employee_id;
ALTER TABLE employeemanagerdetail DROP CONSTRAINT fk_manager_employee_manager_id;
ALTER TABLE employeemanagerdetail DROP CONSTRAINT fk_manager_employee_employee_id;

ALTER TABLE customer DROP CONSTRAINT fk_residence_customer_residence_id;
ALTER TABLE paymentcard DROP CONSTRAINT fk_customer_paymentcard_customer_id;
ALTER TABLE sale DROP CONSTRAINT fk_employee_sale_employee_id;
ALTER TABLE sale DROP CONSTRAINT fk_customer_sale_customer_id;
ALTER TABLE salecoupondetail DROP CONSTRAINT fk_coupon_sale_coupon_id;
ALTER TABLE salecoupondetail DROP CONSTRAINT fk_coupon_sale_sale_id;
ALTER TABLE salepaymentcarddetail DROP CONSTRAINT fk_payment_card_sale_payment_card_id;
ALTER TABLE salepaymentcarddetail DROP CONSTRAINT fk_payment_card_sale_sale_id;
ALTER TABLE saleitemdetail DROP CONSTRAINT fk_book_sale_book_id;
ALTER TABLE saleitemdetail DROP CONSTRAINT fk_book_sale_sale_id;

-- Drop Indexes
ALTER TABLE book DROP INDEX i_book_title;

ALTER TABLE country DROP INDEX i_country_alpha_2_code;
ALTER TABLE country DROP INDEX i_country_alpha_3_code;
ALTER TABLE state DROP INDEX i_state_state_code;

ALTER TABLE employee DROP INDEX i_employee_username;

ALTER TABLE paymentcard DROP INDEX i_paymentcard_primary_account_number;
ALTER TABLE coupon DROP INDEX i_coupon_coupon_code;

-- Drop Unique
ALTER TABLE country DROP CONSTRAINT uc_country_alpha_2_code;
ALTER TABLE country DROP CONSTRAINT uc_country_alpha_3_code;
ALTER TABLE state DROP CONSTRAINT uc_state_state_code;
ALTER TABLE employee DROP CONSTRAINT uc_employee_username;
ALTER TABLE customer DROP CONSTRAINT uc_customer_username;
ALTER TABLE paymentcard DROP CONSTRAINT uc_paymentcard_primary_account_number;

-- ------ Books --------------------------------------------------------------------------
-- 1
ALTER TABLE bookpublisher ADD CONSTRAINT fk_publisher_residence_residence_id
FOREIGN KEY (residence_id) REFERENCES residence(id);
-- 2
ALTER TABLE bookgenredetail ADD CONSTRAINT fk_genre_book_genre_id
FOREIGN KEY (genre_id) REFERENCES bookgenre(id);
-- 3
ALTER TABLE bookgenredetail ADD CONSTRAINT fk_genre_book_book_id 
FOREIGN KEY (book_id) REFERENCES book(id);
-- 4 
ALTER TABLE bookcategorydetail ADD CONSTRAINT fk_category_book_category_id
FOREIGN KEY (category_id) REFERENCES bookcategory(id);
-- 5
ALTER TABLE bookcategorydetail ADD CONSTRAINT fk_category_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 6
ALTER TABLE bookeditiondetail ADD CONSTRAINT fk_edition_book_edition_id
FOREIGN KEY (edition_id) REFERENCES bookedition(id);
-- 7
ALTER TABLE bookeditiondetail ADD CONSTRAINT fk_edition_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 8
ALTER TABLE bookauthordetail ADD CONSTRAINT fk_author_book_author_id
FOREIGN KEY (author_id) REFERENCES bookauthor(id);
-- 9
ALTER TABLE bookauthordetail ADD CONSTRAINT fk_author_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 10
ALTER TABLE bookpublisherdetail ADD CONSTRAINT fk_publisher_book_publisher_id
FOREIGN KEY (publisher_id) REFERENCES bookpublisher(id);
-- 11
ALTER TABLE bookpublisherdetail ADD CONSTRAINT fk_publisher_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 12
ALTER TABLE bookpricedetail ADD CONSTRAINT fk_price_book_price_id
FOREIGN KEY (price_id) REFERENCES bookprice(id);
-- 13
ALTER TABLE bookpricedetail ADD CONSTRAINT fk_price_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);

-- -----------------------------------------------------------------------------------------------------
-- Residence ---------------------------------------------------------------------------------------
-- 1
ALTER TABLE state ADD CONSTRAINT fk_country_state_country_id
FOREIGN KEY (country_id) REFERENCES country(id);
-- 2
ALTER TABLE city ADD CONSTRAINT fk_state_city_state_id
FOREIGN KEY (state_id) REFERENCES state(id);
-- 3
ALTER TABLE city ADD CONSTRAINT fk_country_city_country_id
FOREIGN KEY (country_id) REFERENCES country(id);
-- 4 
ALTER TABLE residence ADD CONSTRAINT fk_country_residence_country_id
FOREIGN KEY (country_id) REFERENCES country(id);
-- 5 
ALTER TABLE residence ADD CONSTRAINT fk_state_residence_state_id
FOREIGN KEY (state_id) REFERENCES state(id);
-- 6 
ALTER TABLE residence ADD CONSTRAINT fk_city_residence_state_id
FOREIGN KEY (city_id) REFERENCES city(id);
-- -----------------------------------------------------------------------------------------------------
-- Employee/Admin --------------------------------------------------------------------------------------
-- 1
ALTER TABLE employee ADD CONSTRAINT fk_residence_employee_residence_id
FOREIGN KEY (residence_id) REFERENCES residence(id);
-- 2
ALTER TABLE employeepositiondetail ADD CONSTRAINT fk_position_employee_position_id
FOREIGN KEY (position_id) REFERENCES logans_books.position(id);
-- 3
ALTER TABLE employeepositiondetail ADD CONSTRAINT fk_position_employee_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);
-- 4
ALTER TABLE employeemanagerdetail ADD CONSTRAINT fk_manager_employee_manager_id
FOREIGN KEY (manager_id) REFERENCES employee(id);
-- 5
ALTER TABLE employeemanagerdetail ADD CONSTRAINT fk_manager_employee_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);
-- -----------------------------------------------------------------------------------------------------
-- Customer/Sale ---------------------------------------------------------------------------------------
-- 1
ALTER TABLE customer ADD CONSTRAINT fk_residence_customer_residence_id
FOREIGN KEY (residence_id) REFERENCES residence(id);
-- 2 	
ALTER TABLE paymentcard ADD CONSTRAINT fk_customer_paymentcard_customer_id
FOREIGN KEY (customer_id) REFERENCES customer(id);
-- 3 
ALTER TABLE sale ADD CONSTRAINT fk_employee_sale_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);
-- 4 
ALTER TABLE sale ADD CONSTRAINT fk_customer_sale_customer_id
FOREIGN KEY (customer_id) REFERENCES customer(id);
-- 5
ALTER TABLE salecoupondetail ADD CONSTRAINT fk_coupon_sale_coupon_id
FOREIGN KEY (coupon_id) REFERENCES coupon(id); 
-- 6
ALTER TABLE salecoupondetail ADD CONSTRAINT fk_coupon_sale_sale_id
FOREIGN KEY (sale_id) REFERENCES sale(id);
-- 7 
ALTER TABLE salepaymentcarddetail ADD CONSTRAINT fk_payment_card_sale_payment_card_id
FOREIGN KEY (payment_card_id) REFERENCES paymentcard(id);
-- 8
ALTER TABLE salepaymentcarddetail ADD CONSTRAINT fk_payment_card_sale_sale_id
FOREIGN KEY (sale_id) REFERENCES sale(id);
-- 9
ALTER TABLE saleitemdetail ADD CONSTRAINT fk_book_sale_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 10
ALTER TABLE saleitemdetail ADD CONSTRAINT fk_book_sale_sale_id
FOREIGN KEY (sale_id) REFERENCES sale(id);
-- ----- Indexes ----------------------------------------------------------------------------------------
-- Books
ALTER TABLE book ADD INDEX i_book_title (title);
-- Residence
-- 1
ALTER TABLE country ADD INDEX i_country_alpha_2_code (alpha_2_code);
-- 2
ALTER TABLE country ADD INDEX i_country_alpha_3_code (alpha_3_code);
-- 3 
ALTER TABLE state ADD INDEX i_state_state_code (code);
-- Employee
ALTER TABLE employee ADD INDEX i_employee_username (username);
-- Customer/sale
ALTER TABLE paymentcard ADD INDEX i_paymentcard_primary_account_number (primary_account_number);
ALTER TABLE coupon ADD INDEX i_coupon_coupon_code (code);
-- ----- Unique ----------------------------------------------------------------------------------------
-- residence
ALTER TABLE country ADD CONSTRAINT UNIQUE uc_country_alpha_2_code (alpha_2_code);
ALTER TABLE country ADD CONSTRAINT UNIQUE uc_country_alpha_3_code (alpha_3_code);
ALTER TABLE state ADD CONSTRAINT UNIQUE uc_state_state_code (code);
-- Employee
ALTER TABLE employee ADD CONSTRAINT uc_employee_username UNIQUE (username);
-- Customer/sale
ALTER TABLE customer ADD CONSTRAINT uc_customer_username UNIQUE (username);
ALTER TABLE paymentcard ADD CONSTRAINT uc_paymentcard_primary_account_number UNIQUE (primary_account_number);















