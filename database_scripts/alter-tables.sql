USE logans_books;

-- ---------------------- Drop constraints -----------------------------------------------
-- Drop Foreign keys
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

ALTER TABLE employeepositiondetail DROP CONSTRAINT fk_position_employee_position_id;
ALTER TABLE employeepositiondetail DROP CONSTRAINT fk_position_employee_employee_id;
ALTER TABLE employeemanagerdetail DROP CONSTRAINT fk_manager_employee_manager_id;
ALTER TABLE employeemanagerdetail DROP CONSTRAINT fk_manager_employee_employee_id;

-- Drop Indexes
ALTER TABLE book DROP INDEX i_book_title;
ALTER TABLE employee DROP INDEX i_employee_username;

-- Drop Unique
ALTER TABLE employee DROP CONSTRAINT uc_username;

-- ------ Books --------------------------------------------------------------------------
-- 1
ALTER TABLE bookgenredetail ADD CONSTRAINT fk_genre_book_genre_id
FOREIGN KEY (genre_id) REFERENCES bookgenre(id);

ALTER TABLE bookgenredetail ADD CONSTRAINT fk_genre_book_book_id 
FOREIGN KEY (book_id) REFERENCES book(id);
-- 2
ALTER TABLE bookcategorydetail ADD CONSTRAINT fk_category_book_category_id
FOREIGN KEY (category_id) REFERENCES bookcategory(id);

ALTER TABLE bookcategorydetail ADD CONSTRAINT fk_category_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 3
ALTER TABLE bookeditiondetail ADD CONSTRAINT fk_edition_book_edition_id
FOREIGN KEY (edition_id) REFERENCES bookedition(id);

ALTER TABLE bookeditiondetail ADD CONSTRAINT fk_edition_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 4 
ALTER TABLE bookauthordetail ADD CONSTRAINT fk_author_book_author_id
FOREIGN KEY (author_id) REFERENCES bookauthor(id);

ALTER TABLE bookauthordetail ADD CONSTRAINT fk_author_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 5
ALTER TABLE bookpublisherdetail ADD CONSTRAINT fk_publisher_book_publisher_id
FOREIGN KEY (publisher_id) REFERENCES bookpublisher(id);

ALTER TABLE bookpublisherdetail ADD CONSTRAINT fk_publisher_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 6
ALTER TABLE bookpricedetail ADD CONSTRAINT fk_price_book_price_id
FOREIGN KEY (price_id) REFERENCES bookprice(id);

ALTER TABLE bookpricedetail ADD CONSTRAINT fk_price_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- -----------------------------------------------------------------------------------------------------
-- Employee/Admin --------------------------------------------------------------------------------------
ALTER TABLE employeepositiondetail ADD CONSTRAINT fk_position_employee_position_id
FOREIGN KEY (position_id) REFERENCES logans_books.position(id);

ALTER TABLE employeepositiondetail ADD CONSTRAINT fk_position_employee_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);

ALTER TABLE employeemanagerdetail ADD CONSTRAINT fk_manager_employee_manager_id
FOREIGN KEY (manager_id) REFERENCES employee(id);

ALTER TABLE employeemanagerdetail ADD CONSTRAINT fk_manager_employee_employee_id
FOREIGN KEY (employee_id) REFERENCES employee(id);


-- ----- Indexes ----------------------------------------------------------------------------------------
-- Books
ALTER TABLE book ADD INDEX i_book_title (title);

-- Employee
ALTER TABLE employee ADD INDEX i_employee_username (username);

-- ----- Unique ----------------------------------------------------------------------------------------
-- Employee
ALTER TABLE employee ADD CONSTRAINT uc_username UNIQUE (username);
















