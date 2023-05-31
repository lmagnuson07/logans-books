USE logans_books;

-- ---------------------------------------------------------------------------------------
-- ---------------------------------------------------------------------------------------
-- ------ Books --------------------------------------------------------------------------
-- 1
ALTER TABLE bookpublisher ADD CONSTRAINT fk_publisher_city_city_id
FOREIGN KEY (city_id) REFERENCES city(id);
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
-- -----------------------------------------------------------------------------------------------------
-- Employee/Admin --------------------------------------------------------------------------------------
-- 1
ALTER TABLE employee ADD CONSTRAINT fk_city_employee_city_id
FOREIGN KEY (city_id) REFERENCES city(id);
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
# ALTER TABLE customer ADD CONSTRAINT fk_city_customer_city_id
# FOREIGN KEY (city_id) REFERENCES residence(id);
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
-- -----------------------------------------------------------------------------------------------------
-- Purchase order ---------------------------------------------------------------------------------------
-- 1 
ALTER TABLE vendorcontact ADD CONSTRAINT fk_vendor_contact_vendor_id
FOREIGN KEY (vendor_id) REFERENCES vendor(id);
-- 2 
ALTER TABLE purchaseorder ADD CONSTRAINT fk_employee_purchaseorder_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);
-- 3  
ALTER TABLE purchaseorder ADD CONSTRAINT fk_vendor_purchaseorder_vendor_id
FOREIGN KEY (vendor_id) REFERENCES vendor(id);
-- 4 
ALTER TABLE vendorcontactdetail ADD CONSTRAINT fk_vendor_vendorcontact_vendor_id
FOREIGN KEY (vendor_id) REFERENCES vendor(id);
-- 5 
ALTER TABLE vendorcontactdetail ADD CONSTRAINT fk_vendor_vendorcontact_vendor_contact_id
FOREIGN KEY (vendor_contact_id) REFERENCES vendorcontact(id);
-- 6 
ALTER TABLE bookvendordetail ADD CONSTRAINT fk_vendor_book_vendor_id
FOREIGN KEY (vendor_id) REFERENCES vendor(id);
-- 7
ALTER TABLE bookvendordetail ADD CONSTRAINT fk_vendor_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 8 
ALTER TABLE purchaseorderdetail ADD CONSTRAINT fk_purchaseorder_book_purchase_order_id
FOREIGN KEY (purchase_order_id) REFERENCES purchaseorder(id);
-- 9 
ALTER TABLE purchaseorderdetail ADD CONSTRAINT fk_purchaseorder_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- -----------------------------------------------------------------------------------------------------
-- Receiving -------------------------------------------------------------------------------------------
-- 1 
ALTER TABLE receiveorder ADD CONSTRAINT fk_purchaseorder_receiveorder_purchase_order_id
FOREIGN KEY (purchase_order_id) REFERENCES purchaseorder(id);
-- 2 
ALTER TABLE receiveorder ADD CONSTRAINT fk_employee_receiveorder_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);
-- 3 
ALTER TABLE receivedatedetail ADD CONSTRAINT fk_receiveorder_receivedatedetail_receive_order_id
FOREIGN KEY (receive_order_id) REFERENCES receiveorder(id);
-- 4 
ALTER TABLE receiveorderdetail ADD CONSTRAINT fk_podetail_ro_purchase_order_detail_id
FOREIGN KEY (purchase_order_detail_id) REFERENCES purchaseorderdetail(id);
-- 5 
ALTER TABLE receiveorderdetail ADD CONSTRAINT fk_receiveorder_rodetail_receive_order_id
FOREIGN KEY (receive_order_id) REFERENCES receiveorder(id);
-- -----------------------------------------------------------------------------------------------------
-- Rentals ---------------------------------------------------------------------------------------------
-- 1 
ALTER TABLE rental ADD CONSTRAINT fk_employee_rental_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);
-- 2 
ALTER TABLE rental ADD CONSTRAINT fk_customer_rental_customer_id
FOREIGN KEY (customer_id) REFERENCES customer(id);
-- 3 
ALTER TABLE rentalbook ADD CONSTRAINT fk_purchaseorder_rentalbook_purchase_order_detail_id
FOREIGN KEY (purchase_order_detail_id) REFERENCES purchaseorderdetail(id);
-- 4 
ALTER TABLE rentalcoupondetail ADD CONSTRAINT fk_rental_rentalcoupon_rental_id
FOREIGN KEY (rental_id) REFERENCES rental(id);
-- 5 
ALTER TABLE rentalcoupondetail ADD CONSTRAINT fk_coupon_rentalcoupon_coupon_id
FOREIGN KEY (coupon_id) REFERENCES coupon(id);
-- 6 
ALTER TABLE rentaldetail ADD CONSTRAINT fk_rental_rentaldetail_rental_id
FOREIGN KEY (rental_id) REFERENCES rental(id);
-- 7
ALTER TABLE rentaldetail ADD CONSTRAINT fk_rentalbook_rentaldetail_rental_book_id
FOREIGN KEY (rental_book_id) REFERENCES rentalbook(id);
-- -----------------------------------------------------------------------------------------------------
-- Refunds ---------------------------------------------------------------------------------------------
-- 1 
ALTER TABLE salerefund ADD CONSTRAINT fk_employee_salerefund_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);
-- 2 
ALTER TABLE salerefund ADD CONSTRAINT fk_customer_salerefund_customer_id
FOREIGN KEY (customer_id) REFERENCES customer(id);
-- 3 
ALTER TABLE salerefund ADD CONSTRAINT fk_sale_salerefund_sale_id
FOREIGN KEY (sale_id) REFERENCES sale(id);
-- 4 
ALTER TABLE salerefunddetail ADD CONSTRAINT fk_salerefund_salerefunddetal_sale_refund_id
FOREIGN KEY (sale_refund_id) REFERENCES salerefund(id);
-- 5 
ALTER TABLE salerefunddetail ADD CONSTRAINT fk_book_salerefunddetal_sale_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- -----------------------------------------------------------------------------------------------------
-- Company ---------------------------------------------------------------------------------------------
-- 1 
ALTER TABLE store ADD CONSTRAINT fk_city_store_city_id
FOREIGN KEY (city_id) REFERENCES city(id);
-- 2 
ALTER TABLE storeemployeedetail ADD CONSTRAINT fk_store_storeemployeedetail_store_id
FOREIGN KEY (store_id) REFERENCES store(id);
-- 3 
ALTER TABLE storeemployeedetail ADD CONSTRAINT fk_employee_storeemployeedetail_employee_id
FOREIGN KEY (store_id) REFERENCES store(id);
-- ----- Indexes ---------------------------------------------------------------------------------------
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
-- Purchase Order
ALTER TABLE vendor ADD INDEX i_vendor_vendor_name (name);
-- Receive Order
ALTER TABLE receivedatedetail ADD INDEX i_recevedatedetail_receive_status (receive_status);
-- ----- Unique ----------------------------------------------------------------------------------------
-- book
ALTER TABLE bookgenre ADD CONSTRAINT UNIQUE uc_genre_book_is_fiction (name, is_fiction);
-- residence
ALTER TABLE country ADD CONSTRAINT UNIQUE uc_country_alpha_2_code (alpha_2_code);
ALTER TABLE country ADD CONSTRAINT UNIQUE uc_country_alpha_3_code (alpha_3_code);
ALTER TABLE state ADD CONSTRAINT UNIQUE uc_state_state_code (code);
-- Employee
ALTER TABLE employee ADD CONSTRAINT uc_employee_username UNIQUE (username);
-- Customer/sale
ALTER TABLE customer ADD CONSTRAINT uc_customer_username UNIQUE (username);
ALTER TABLE paymentcard ADD CONSTRAINT uc_paymentcard_primary_account_number UNIQUE (primary_account_number);
















