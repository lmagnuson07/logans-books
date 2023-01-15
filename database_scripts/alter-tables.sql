USE logans_books;

-- Drop constraints
ALTER TABLE bookGenreDetail
DROP CONSTRAINT fk_genre_genre_id;
ALTER TABLE bookGenreDetail
DROP CONSTRAINT fk_book_book_id;

-- Foreign Keys
-- 1
ALTER TABLE bookGenreDetail
ADD CONSTRAINT fk_genre_genre_id
FOREIGN KEY (genre_id) REFERENCES bookGenre(id);

ALTER TABLE bookGenreDetail
ADD CONSTRAINT fk_book_book_id 
FOREIGN KEY (book_id) REFERENCES book(id);
-- 2