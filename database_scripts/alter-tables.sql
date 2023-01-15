USE logans_books;

-- Drop constraints
ALTER TABLE bookGenreDetail DROP CONSTRAINT fk_genre_book_genre_id;
ALTER TABLE bookGenreDetail DROP CONSTRAINT fk_genre_book_book_id;
ALTER TABLE bookCategoryDetail DROP CONSTRAINT fk_category_book_category_id;
ALTER TABLE bookCategoryDetail DROP CONSTRAINT fk_category_book_book_id;
ALTER TABLE bookEditionDetail DROP CONSTRAINT fk_edition_book_edition_id;
ALTER TABLE bookEditionDetail DROP CONSTRAINT fk_edition_book_book_id;
ALTER TABLE bookAuthorDetail DROP CONSTRAINT fk_author_book_author_id;
ALTER TABLE bookAuthorDetail DROP CONSTRAINT fk_author_book_book_id;
ALTER TABLE bookPublisherDetail DROP CONSTRAINT fk_publisher_book_publisher_id;
ALTER TABLE bookPublisherDetail DROP CONSTRAINT fk_publisher_book_book_id;
ALTER TABLE bookPriceDetail DROP CONSTRAINT fk_price_book_price_id;
ALTER TABLE bookPriceDetail DROP CONSTRAINT fk_price_book_book_id;

-- Foreign Keys
-- ------ Books ----------------------------------------------------------
-- 1
ALTER TABLE bookGenreDetail ADD CONSTRAINT fk_genre_book_genre_id
FOREIGN KEY (genre_id) REFERENCES bookGenre(id);

ALTER TABLE bookGenreDetail ADD CONSTRAINT fk_genre_book_book_id 
FOREIGN KEY (book_id) REFERENCES book(id);
-- 2
ALTER TABLE bookCategoryDetail ADD CONSTRAINT fk_category_book_category_id
FOREIGN KEY (category_id) REFERENCES bookCategory(id);

ALTER TABLE bookCategoryDetail ADD CONSTRAINT fk_category_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 3
ALTER TABLE bookEditionDetail ADD CONSTRAINT fk_edition_book_edition_id
FOREIGN KEY (edition_id) REFERENCES bookEdition(id);

ALTER TABLE bookEditionDetail ADD CONSTRAINT fk_edition_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 4 
ALTER TABLE bookAuthorDetail ADD CONSTRAINT fk_author_book_author_id
FOREIGN KEY (author_id) REFERENCES bookAuthor(id);

ALTER TABLE bookAuthorDetail ADD CONSTRAINT fk_author_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 5
ALTER TABLE bookPublisherDetail ADD CONSTRAINT fk_publisher_book_publisher_id
FOREIGN KEY (publisher_id) REFERENCES bookPublisher(id);

ALTER TABLE bookPublisherDetail ADD CONSTRAINT fk_publisher_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- 6
ALTER TABLE bookPriceDetail ADD CONSTRAINT fk_price_book_price_id
FOREIGN KEY (price_id) REFERENCES bookPrice(id);

ALTER TABLE bookPriceDetail ADD CONSTRAINT fk_price_book_book_id
FOREIGN KEY (book_id) REFERENCES book(id);
-- ------------------------------------------------------------------------






























