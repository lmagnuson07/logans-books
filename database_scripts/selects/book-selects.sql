USE logans_books;

SELECT b.id, b.current_price, b.qty_in_stock, b.qty_on_order, 
	b.title, b.tagline, b.synopsis, b.number_of_pages, b.format, 
    b.language, b.cover_image_url, b.is_available,
	bgd.genre_id, bg.name AS genre_name, 
    bcd.category_id, bc.name AS category_name, 
    bed.edition_id, be.name AS edition_name,
    bad.author_id, CONCAT(ba.first_name, " ", ba.last_name) AS author_fullname,
    bpd.publisher_id, bp.name AS publisher_name
FROM book b
INNER JOIN bookgenredetail bgd
	ON bgd.book_id = b.id
INNER JOIN bookgenre bg
	ON bg.id = bgd.genre_id
INNER JOIN bookcategorydetail bcd
	ON bcd.book_id = b.id
INNER JOIN bookcategory bc
	ON bc.id = bcd.category_id
INNER JOIN bookeditiondetail bed
	ON bed.book_id = b.id
INNER JOIN bookedition be
	ON be.id = bed.edition_id
INNER JOIN bookauthordetail bad
	ON bad.book_id = b.id
INNER JOIN bookauthor ba
	ON ba.id = bad.author_id
INNER JOIN bookpublisherdetail bpd
	ON bpd.book_id = b.id
INNER JOIN bookpublisher bp
	ON bp.id = bpd.publisher_id
WHERE b.id = 4
;
