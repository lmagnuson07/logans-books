USE logans_books;

-- ---------------------- Drop constraints -----------------------------------------------
-- Drop Foreign keys
ALTER TABLE bookpublisher DROP CONSTRAINT fk_publisher_city_city_id;
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

ALTER TABLE employee DROP CONSTRAINT fk_city_employee_city_id;
ALTER TABLE employeepositiondetail DROP CONSTRAINT fk_position_employee_position_id;
ALTER TABLE employeepositiondetail DROP CONSTRAINT fk_position_employee_employee_id;
ALTER TABLE employeemanagerdetail DROP CONSTRAINT fk_manager_employee_manager_id;
ALTER TABLE employeemanagerdetail DROP CONSTRAINT fk_manager_employee_employee_id;

# ALTER TABLE customer DROP CONSTRAINT fk_city_customer_city_id;
ALTER TABLE paymentcard DROP CONSTRAINT fk_customer_paymentcard_customer_id;
ALTER TABLE sale DROP CONSTRAINT fk_employee_sale_employee_id;
ALTER TABLE sale DROP CONSTRAINT fk_customer_sale_customer_id;
ALTER TABLE salecoupondetail DROP CONSTRAINT fk_coupon_sale_coupon_id;
ALTER TABLE salecoupondetail DROP CONSTRAINT fk_coupon_sale_sale_id;
ALTER TABLE salepaymentcarddetail DROP CONSTRAINT fk_payment_card_sale_payment_card_id;
ALTER TABLE salepaymentcarddetail DROP CONSTRAINT fk_payment_card_sale_sale_id;
ALTER TABLE saleitemdetail DROP CONSTRAINT fk_book_sale_book_id;
ALTER TABLE saleitemdetail DROP CONSTRAINT fk_book_sale_sale_id;

ALTER TABLE vendorcontact DROP CONSTRAINT fk_vendor_contact_vendor_id;
ALTER TABLE purchaseorder DROP CONSTRAINT fk_employee_purchaseorder_employee_id;
ALTER TABLE purchaseorder DROP CONSTRAINT fk_vendor_purchaseorder_vendor_id;
ALTER TABLE vendorcontactdetail DROP CONSTRAINT fk_vendor_vendorcontact_vendor_id;
ALTER TABLE vendorcontactdetail DROP CONSTRAINT fk_vendor_vendorcontact_vendor_contact_id;
ALTER TABLE bookvendordetail DROP CONSTRAINT fk_vendor_book_vendor_id;
ALTER TABLE bookvendordetail DROP CONSTRAINT fk_vendor_book_book_id;
ALTER TABLE purchaseorderdetail DROP CONSTRAINT fk_purchaseorder_book_purchase_order_id;
ALTER TABLE purchaseorderdetail DROP CONSTRAINT fk_purchaseorder_book_book_id;

ALTER TABLE receiveorder DROP CONSTRAINT fk_purchaseorder_receiveorder_purchase_order_id;
ALTER TABLE receiveorder DROP CONSTRAINT fk_employee_receiveorder_employee_id;
ALTER TABLE receivedatedetail DROP CONSTRAINT fk_receiveorder_receivedatedetail_receive_order_id;
ALTER TABLE receiveorderdetail DROP CONSTRAINT fk_podetail_ro_purchase_order_detail_id;
ALTER TABLE receiveorderdetail DROP CONSTRAINT fk_receiveorder_rodetail_receive_order_id;

ALTER TABLE rental DROP CONSTRAINT fk_employee_rental_employee_id;
ALTER TABLE rental DROP CONSTRAINT fk_customer_rental_customer_id;
ALTER TABLE rentalbook DROP CONSTRAINT fk_purchaseorder_rentalbook_purchase_order_detail_id;
ALTER TABLE rentalcoupondetail DROP CONSTRAINT fk_rental_rentalcoupon_rental_id;
ALTER TABLE rentalcoupondetail DROP CONSTRAINT fk_coupon_rentalcoupon_coupon_id;
ALTER TABLE rentaldetail DROP CONSTRAINT fk_rental_rentaldetail_rental_id;
ALTER TABLE rentaldetail DROP CONSTRAINT fk_rentalbook_rentaldetail_rental_book_id;

ALTER TABLE salerefund DROP CONSTRAINT fk_employee_salerefund_employee_id;
ALTER TABLE salerefund DROP CONSTRAINT fk_customer_salerefund_customer_id;
ALTER TABLE salerefund DROP CONSTRAINT fk_sale_salerefund_sale_id;
ALTER TABLE salerefunddetail DROP CONSTRAINT fk_salerefund_salerefunddetal_sale_refund_id;
ALTER TABLE salerefunddetail DROP CONSTRAINT fk_book_salerefunddetal_sale_book_id;

ALTER TABLE store DROP CONSTRAINT fk_city_store_city_id;
ALTER TABLE storeemployeedetail DROP CONSTRAINT fk_store_storeemployeedetail_store_id;
ALTER TABLE storeemployeedetail DROP CONSTRAINT fk_employee_storeemployeedetail_employee_id;

-- Drop Indexes
ALTER TABLE book DROP INDEX i_book_title;

ALTER TABLE country DROP INDEX i_country_alpha_2_code;
ALTER TABLE country DROP INDEX i_country_alpha_3_code;
ALTER TABLE state DROP INDEX i_state_state_code;

ALTER TABLE employee DROP INDEX i_employee_username;

ALTER TABLE paymentcard DROP INDEX i_paymentcard_primary_account_number;
ALTER TABLE coupon DROP INDEX i_coupon_coupon_code;

ALTER TABLE vendor DROP INDEX i_vendor_vendor_name;

ALTER TABLE receivedatedetail DROP INDEX i_recevedatedetail_receive_status;

-- Drop Unique
ALTER TABLE bookgenre DROP CONSTRAINT uc_genre_book_is_fiction;
ALTER TABLE country DROP CONSTRAINT uc_country_alpha_2_code;
ALTER TABLE country DROP CONSTRAINT uc_country_alpha_3_code;
ALTER TABLE state DROP CONSTRAINT uc_state_state_code;
ALTER TABLE employee DROP CONSTRAINT uc_employee_username;
ALTER TABLE customer DROP CONSTRAINT uc_customer_username;
ALTER TABLE paymentcard DROP CONSTRAINT uc_paymentcard_primary_account_number;















