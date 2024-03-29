USE logans_books;

INSERT INTO openlibbookendpoints
	(title, base_url, api_version, api_endpoint)
VALUES
    ('isbn endpoint', 'https://openlibrary.org/', '', 'isbn/'),
    ('works endpoint', 'https://openlibrary.org/', '', 'works/'),
    ('authors endpoint', 'https://openlibrary.org/', '', 'authors/')
;

INSERT INTO googlebookendpoints
	(title, base_url, api_version, api_endpoint)
VALUES
	('volumes endpoint', 'https://www.googleapis.com/books/', 'v1', 'volumes/')
;
