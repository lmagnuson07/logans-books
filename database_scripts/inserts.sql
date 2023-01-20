USE logans_books;

INSERT INTO bookgenre
	(name, is_fiction, description)
VALUES
	('Action and adventure', 1, ""),				('Art/architecture', 0, ""),	
    ('Alternate history', 1, ""),					('Autobiography', 0, ""),
    ('Anthologyy', 1, ""),							('Biography', 0, ""),
    ('Chick lit', 1, ""),							('Business/economics', 0, ""),	
    ('Children\'s', 1, ""),							('Crafts/hobbies', 0, ""),
    ('Classic', 1, ""),								('Cookbook', 0, ""),
    ('Comic book', 1, ""),							('Diary', 0, ""),				
    ('Coming-of-age', 1, ""),						('Dictionary', 0, ""),
    ('Crime', 1, ""),								('Encyclopedia', 0, ""),				
    ('Drama', 1, ""),								('Guide', 0, ""),			
    ('Fairytale', 1, ""),							('Health/fitness', 0, ""),		
    ('Fantasy', 1, ""),								('Home and garden', 0, ""),		
    ('Graphic novel', 1, ""),						('Humor', 0, ""),		
    ('Historical fiction', 1, ""),					('Journal', 0, ""),
    ('Horror', 1, ""),								('Math', 0, ""),
    ('Mystery', 1, ""),								('Memoir', 0, ""),
    ('Paranormal romance', 1, ""),					('Philosophy', 0, ""),
    ('Picture book', 1, ""),						('Prayer', 0, ""),
    ('Poetry', 1, ""),								('Religion, spirituality, and new age', 0, ""),
    ('Political thriller', 1, ""),					('Textbook', 0, ""),
    ('Romance', 1, ""),								('True crime', 0, ""),
    ('Science fiction', 1, ""),						('Review', 0, ""),
    ('Short story', 1, ""),							('Science', 0, ""),
    ('Suspense', 1, ""),							('Self help', 0, ""),
    ('Thriller', 1, ""),							('Sports and leisure', 0, ""),	
    ('Western', 1, ""),								('Travel', 0, ""),
    ('Young adult', 1, ""),							('History', 0, "")
;
   
INSERT INTO bookcategory
	(name, description)
VALUES 
	("Best Sellers", ""),
    ("Logans Top Picks", ""),
    ("Most Popular", ""),
    ("5 Stars", ""),
    ("Book of the year", "")
;

INSERT INTO bookedition
	(name, description)
VALUES 
	("Calla Facsimiles", ""),
    ("Penguin Clothbounds", ""),
    ("Beehive Illuminated", ""),
    ("Chiltern Classics", ""),
    ("Barnes & Noble Collectibles", ""),
    ("Penguin \'Leatherbound\' Classics", ""),
    ("MinaLima's Interactive Classics", ""),
    ("Seasons Editions", ""),
    ("Penguin Vitae", ""),
    ("Penguin Ink", ""),
    ("Little Clothbounds", ""),
    ("Painted Editions", ""),
    ("Macmillan Popular Classics", "")
;

insert into bookauthor (first_name, last_name, image_url, email) values ('Markos', 'Roxburch', 'https://xsgames.co/randomusers/assets/avatars/male/21.jpg', 'mroxburch0@usa.gov');
insert into bookauthor (first_name, last_name, image_url, email) values ('Weston', 'More', 'https://xsgames.co/randomusers/assets/avatars/male/5.jpg', 'wmore1@salon.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Dale', 'Kinsell', 'https://xsgames.co/randomusers/assets/avatars/male/6.jpg', 'dkinsell2@google.ca');
insert into bookauthor (first_name, last_name, image_url, email) values ('Huntlee', 'Matula', 'https://xsgames.co/randomusers/assets/avatars/male/38.jpg', 'hmatula3@businessweek.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Dionysus', 'Esby', 'https://xsgames.co/randomusers/assets/avatars/male/65.jpg', 'desby4@dagondesign.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Shawn', 'Heathcoat', 'https://xsgames.co/randomusers/assets/avatars/male/10.jpg', 'sheathcoat5@hhs.gov');
insert into bookauthor (first_name, last_name, image_url, email) values ('Cy', 'Wraggs', 'https://xsgames.co/randomusers/assets/avatars/male/18.jpg', 'cwraggs6@istockphoto.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Frederik', 'Staton', 'https://xsgames.co/randomusers/assets/avatars/male/16.jpg', 'fstaton7@hao123.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Dennie', 'Mardoll', 'https://xsgames.co/randomusers/assets/avatars/male/13.jpg', 'dmardoll8@g.co');
insert into bookauthor (first_name, last_name, image_url, email) values ('Gris', 'Espada', 'https://xsgames.co/randomusers/assets/avatars/male/17.jpg', 'gespada9@rakuten.co.jp');
insert into bookauthor (first_name, last_name, image_url, email) values ('Vyky', 'McDavid', 'https://xsgames.co/randomusers/assets/avatars/female/10.jpg', 'vmcdavid0@yale.edu');
insert into bookauthor (first_name, last_name, image_url, email) values ('Ainslee', 'Ervin', 'https://xsgames.co/randomusers/assets/avatars/female/41.jpg', 'aervin1@typepad.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Eda', 'Colisbe', 'https://xsgames.co/randomusers/assets/avatars/female/30.jpg', 'ecolisbe2@soup.io');
insert into bookauthor (first_name, last_name, image_url, email) values ('Ezmeralda', 'Gutherson', 'https://xsgames.co/randomusers/assets/avatars/female/27.jpg', 'egutherson3@1und1.de');
insert into bookauthor (first_name, last_name, image_url, email) values ('Lotta', 'Lampel', 'https://xsgames.co/randomusers/assets/avatars/female/18.jpg', 'llampel4@redcross.org');
insert into bookauthor (first_name, last_name, image_url, email) values ('Ellie', 'Goeff', 'https://xsgames.co/randomusers/assets/avatars/female/5.jpg', 'egoeff5@yelp.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Diahann', 'Grimsdell', 'https://xsgames.co/randomusers/assets/avatars/female/28.jpg', 'dgrimsdell6@home.pl');
insert into bookauthor (first_name, last_name, image_url, email) values ('Sibeal', 'Spight', 'https://xsgames.co/randomusers/assets/avatars/female/37.jpg', 'sspight7@msn.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Margaretta', 'Calderon', 'https://xsgames.co/randomusers/assets/avatars/female/60.jpg', 'mcalderon8@macromedia.com');
insert into bookauthor (first_name, last_name, image_url, email) values ('Rikki', 'Baugham', 'https://xsgames.co/randomusers/assets/avatars/female/68.jpg', 'rbaugham9@odnoklassniki.ru');

INSERT INTO country
	(alpha_2_code, alpha_3_code, name)
VALUES 
	("CA", "CAN", "Canada"),
    ("US", "USA", "United States of America"),
    ("CN", "CHN", "China"),
    ("MX", "MEX", "Mexico"),
    ("IN", "IND", "India"),
    ("GB", "GBR", "United Kingdom")
    ;

INSERT INTO state
	(name, code, country_id)
VALUES
	("Alberta", "AB", 1),
    ("British Columbia", "BC", 1),
    ("Saskatchewan", "SK", 1),
    ("Manitoba", "MB", 1),
    ("Ontario", "ON", 1)
;

INSERT INTO city
	(name, state_id, country_id)
VALUES
	("Edmonton", 1, 1),
    ("Calgary", 1, 1),
    ("Vancouver", 2, 1),
    ("Kamloops", 2, 1),
    ("Moosejaw", 3, 1),
    ("Saskatoon", 3, 1),
    ("North Battleford", 3, 1)
;

insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Wordtune', 3, '611 Kim Circle', '396130', 'https://www.wordtune.com', 'wordtune@zoho.com', '1735653026');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Lazzy', 2, '45 Transport Court', '84950-000', 'https://www.lazzy.com', 'lazzy@yandex.com', '7085399186');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Jaxspan', 6, '2742 Burrows Plaza', 'J8L 1P2', 'https://www.jaxspan.com', 'jaxspan@gmx.com', '7786821933');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Voonder', 4, '41057 Buena Vista Hill', '97670', 'https://www.voonder.com', 'voonder@icloud.com', '7003493693');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Edgeify', 1, '941 Bowman Pass', '051059', 'https://www.edgeify.com', 'edgeify@aol.com', '3295545422');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Yata', 3, '9 Banding Drive', '13155 CEDEX', 'https://www.yata.com', 'yata@yahoo.com', '7868043570');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Riffpath', 5, '1 New Castle Park', 'E5P 2C4', 'https://www.riffpath.com', 'riffpath@outlook.com', '8943281602');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Skiptube', 3, '789 Arapahoe Place', 'E8G 3H4', 'https://www.skiptube.com', 'skiptube@hotmail.com', '5295988112');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Oyoloo', 5, '029 Karstens Parkway', '2500-454', 'https://www.oyoloo.com', 'oyoloo@gmail.com', '4863682703');
insert into bookpublisher (name, city_id, street_address, postal_code, website_url, email, phone) values ('Babbleopia', 5, '9 Donald Lane', '6419', 'https://www.babbleopia.com', 'babbleopia@gmail.com', '4783511901');

insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Moonraker', 'Self-enabling human-resource archive', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat. Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem. Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', 428, 'Afrikaans', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000173624-L.jpg', 32, 18, 146.6406, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Horse Soldiers, The', 'Distributed client-driven function', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros. Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.', 292, 'Bulgarian', 'Softcover', 'https://covers.openlibrary.org/b/id/0000571218-L.jpg', 26, 28, 140.3726, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Standby', 'Multi-channelled client-driven productivity', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl. Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum. Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', 109, 'Burmese', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000932543-L.jpg', 38, 11, 114.8632, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Adulthood', 'Grass-roots asymmetric secured line', 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh. In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet. Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.', 196, 'Telugu', 'Softcover', 'https://covers.openlibrary.org/b/id/0000729133-L.jpg', 48, 18, 166.9948, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Mark of Cain, The', 'Centralized actuating firmware', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat. Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', 494, 'Kashmiri', 'Softcover', 'https://covers.openlibrary.org/b/id/0000234895-L.jpg', 38, 50, 128.5597, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Sleepless & Night', 'Fully-configurable incremental neural-net', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst. Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', 639, 'Hiri Motu', 'Softcover', 'https://covers.openlibrary.org/b/id/0000018524-L.jpg', 36, 10, 199.2438, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Would You <> Rather', 'Public-key foreground synergy', 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 1325, 'Kyrgyz', 'Softcover', 'https://covers.openlibrary.org/b/id/0000428919-L.jpg', 24, 49, 163.6888, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Boris Godunov', 'Monitored stable time-frame', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 981, 'English', 'Softcover', 'https://covers.openlibrary.org/b/id/0000071505-L.jpg', 28, 4, 82.4641, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('I Accuse', 'Distributed methodical architecture', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi. Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus. Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', 1452, 'Guaraní', 'Softcover', 'https://covers.openlibrary.org/b/id/0000911329-L.jpg', 37, 22, 64.7811, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Twister', 'Balanced cohesive attitude', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', 309, 'Burmese', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000369727-L.jpg', 47, 33, 59.2488, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Parker', 'Multi-layered client-server emulation', 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede. Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem. Fusce consequat. Nulla nisl. Nunc nisl.', 602, 'Bengali', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000390344-L.jpg', 21, 34, 15.5974, 0);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Diamond Men', 'Progressive logistical service-desk', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem. Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat. Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 1482, 'Filipino', 'Softcover', 'https://covers.openlibrary.org/b/id/0000591006-L.jpg', 29, 44, 27.7334, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Lipstick', 'Monitored optimizing hardware', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', 745, 'Korean', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000265862-L.jpg', 8, 12, 193.0707, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Dragon Ball Z: Dead Zone', 'Intuitive systematic initiative', 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', 1096, 'Northern Sotho', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000214056-L.jpg', 27, 39, 104.8344, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Kill Bill: Vol. 2', 'Innovative incremental parallelism', 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat. Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede. Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.', 224, 'Maltese', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000380354-L.jpg', 41, 38, 115.909, 0);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Chill Out!', 'Extended optimal service-desk', 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque. Quisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus. Phasellus in felis. Donec semper sapien a libero. Nam dui.', 1380, 'Marathi', 'Softcover', 'https://covers.openlibrary.org/b/id/0000356446-L.jpg', 30, 14, 126.8294, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Gloomy Sunday', 'Vision-oriented empowering paradigm', 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', 569, 'Tetum', 'Softcover', 'https://covers.openlibrary.org/b/id/0000100587-L.jpg', 28, 19, 131.7472, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Love Bites', 'Virtual heuristic forecast', 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.', 1447, 'English', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000407756-L.jpg', 35, 13, 134.8445, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Coriolanus', 'Object-based didactic database', 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', 69, 'Kurdish', 'Hardcover', 'https://covers.openlibrary.org/b/id/0000534455-L.jpg', 40, 21, 65.452, 1);
insert into book (title, tagline, synopsis, number_of_pages, language, format, cover_image_url, qty_in_stock, qty_on_order, current_price, is_available) values ('Rollerball', 'Down-sized 6th generation pricing structure', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', 1222, 'English', 'Softcover', 'https://covers.openlibrary.org/b/id/0000873521-L.jpg', 34, 41, 102.6741, 1);

insert into bookprice (historical_price, historical_price_date) values (138.5804, '2021-11-28 05:25:23');
insert into bookprice (historical_price, historical_price_date) values (34.5474, '2022-02-18 04:12:34');
insert into bookprice (historical_price, historical_price_date) values (110.9647, '2020-05-13 16:02:32');
insert into bookprice (historical_price, historical_price_date) values (30.9998, '2021-03-30 21:20:47');
insert into bookprice (historical_price, historical_price_date) values (151.8027, '2020-09-27 17:20:08');
insert into bookprice (historical_price, historical_price_date) values (93.1908, '2022-09-18 06:09:38');
insert into bookprice (historical_price, historical_price_date) values (182.728, '2022-09-16 10:40:06');
insert into bookprice (historical_price, historical_price_date) values (147.6574, '2020-10-18 05:24:15');
insert into bookprice (historical_price, historical_price_date) values (126.8743, '2021-02-27 17:34:21');
insert into bookprice (historical_price, historical_price_date) values (69.9724, '2020-08-11 03:53:57');
insert into bookprice (historical_price, historical_price_date) values (96.7887, '2020-02-21 07:53:55');
insert into bookprice (historical_price, historical_price_date) values (134.422, '2019-06-06 19:32:46');
insert into bookprice (historical_price, historical_price_date) values (19.4744, '2021-12-21 01:23:44');
insert into bookprice (historical_price, historical_price_date) values (37.4026, '2022-04-09 18:14:31');
insert into bookprice (historical_price, historical_price_date) values (90.6722, '2019-12-04 02:25:30');
insert into bookprice (historical_price, historical_price_date) values (159.4353, '2020-03-03 17:01:36');
insert into bookprice (historical_price, historical_price_date) values (40.6274, '2021-08-23 12:46:47');
insert into bookprice (historical_price, historical_price_date) values (55.4776, '2020-07-04 17:23:16');
insert into bookprice (historical_price, historical_price_date) values (188.1278, '2019-02-19 12:34:19');
insert into bookprice (historical_price, historical_price_date) values (65.0521, '2021-06-24 14:08:51');

insert into bookgenredetail (book_id, genre_id) values (1, 10);
insert into bookgenredetail (book_id, genre_id) values (2, 8);
insert into bookgenredetail (book_id, genre_id) values (3, 44);
insert into bookgenredetail (book_id, genre_id) values (4, 41);
insert into bookgenredetail (book_id, genre_id) values (4, 8);
insert into bookgenredetail (book_id, genre_id) values (5, 41);
insert into bookgenredetail (book_id, genre_id) values (6, 13);
insert into bookgenredetail (book_id, genre_id) values (7, 34);
insert into bookgenredetail (book_id, genre_id) values (8, 29);
insert into bookgenredetail (book_id, genre_id) values (9, 17);
insert into bookgenredetail (book_id, genre_id) values (10, 37);
insert into bookgenredetail (book_id, genre_id) values (11, 1);
insert into bookgenredetail (book_id, genre_id) values (12, 39);
insert into bookgenredetail (book_id, genre_id) values (13, 13);
insert into bookgenredetail (book_id, genre_id) values (14, 35);
insert into bookgenredetail (book_id, genre_id) values (15, 16);
insert into bookgenredetail (book_id, genre_id) values (16, 40);
insert into bookgenredetail (book_id, genre_id) values (17, 50);
insert into bookgenredetail (book_id, genre_id) values (18, 3);
insert into bookgenredetail (book_id, genre_id) values (19, 39);
insert into bookgenredetail (book_id, genre_id) values (20, 53);

insert into bookcategorydetail (book_id, category_id) values (1, 1);
insert into bookcategorydetail (book_id, category_id) values (2, 1);
insert into bookcategorydetail (book_id, category_id) values (3, 2);
insert into bookcategorydetail (book_id, category_id) values (4, 1);
insert into bookcategorydetail (book_id, category_id) values (4, 3);
insert into bookcategorydetail (book_id, category_id) values (4, 4);
insert into bookcategorydetail (book_id, category_id) values (5, 4);
insert into bookcategorydetail (book_id, category_id) values (6, 3);
insert into bookcategorydetail (book_id, category_id) values (7, 4);
insert into bookcategorydetail (book_id, category_id) values (8, 2);
insert into bookcategorydetail (book_id, category_id) values (9, 4);
insert into bookcategorydetail (book_id, category_id) values (10, 5);
insert into bookcategorydetail (book_id, category_id) values (10, 1);
insert into bookcategorydetail (book_id, category_id) values (11, 5);
insert into bookcategorydetail (book_id, category_id) values (12, 3);
insert into bookcategorydetail (book_id, category_id) values (13, 4);
insert into bookcategorydetail (book_id, category_id) values (14, 2);
insert into bookcategorydetail (book_id, category_id) values (15, 3);
insert into bookcategorydetail (book_id, category_id) values (16, 4);
insert into bookcategorydetail (book_id, category_id) values (17, 2);
insert into bookcategorydetail (book_id, category_id) values (18, 4);
insert into bookcategorydetail (book_id, category_id) values (19, 1);
insert into bookcategorydetail (book_id, category_id) values (20, 5);

insert into bookeditiondetail (book_id, edition_id) values (1, 1);
insert into bookeditiondetail (book_id, edition_id) values (2, 3);
insert into bookeditiondetail (book_id, edition_id) values (3, 11);
insert into bookeditiondetail (book_id, edition_id) values (4, 6);
insert into bookeditiondetail (book_id, edition_id) values (5, 13);
insert into bookeditiondetail (book_id, edition_id) values (6, 7);
insert into bookeditiondetail (book_id, edition_id) values (6, 13);
insert into bookeditiondetail (book_id, edition_id) values (7, 7);
insert into bookeditiondetail (book_id, edition_id) values (8, 13);
insert into bookeditiondetail (book_id, edition_id) values (9, 9);
insert into bookeditiondetail (book_id, edition_id) values (10, 3);
insert into bookeditiondetail (book_id, edition_id) values (11, 7);
insert into bookeditiondetail (book_id, edition_id) values (12, 11);
insert into bookeditiondetail (book_id, edition_id) values (13, 6);
insert into bookeditiondetail (book_id, edition_id) values (14, 3);
insert into bookeditiondetail (book_id, edition_id) values (15, 1);
insert into bookeditiondetail (book_id, edition_id) values (16, 13);
insert into bookeditiondetail (book_id, edition_id) values (17, 6);
insert into bookeditiondetail (book_id, edition_id) values (18, 9);
insert into bookeditiondetail (book_id, edition_id) values (19, 9);
insert into bookeditiondetail (book_id, edition_id) values (20, 1);
insert into bookeditiondetail (book_id, edition_id) values (5, 10);
insert into bookeditiondetail (book_id, edition_id) values (10, 1);
insert into bookeditiondetail (book_id, edition_id) values (8, 5);
insert into bookeditiondetail (book_id, edition_id) values (10, 11);
insert into bookeditiondetail (book_id, edition_id) values (13, 10);
insert into bookeditiondetail (book_id, edition_id) values (18, 1);

insert into bookauthordetail (book_id, author_id) values (1, 17);
insert into bookauthordetail (book_id, author_id) values (2, 8);
insert into bookauthordetail (book_id, author_id) values (3, 3);
insert into bookauthordetail (book_id, author_id) values (4, 9);
insert into bookauthordetail (book_id, author_id) values (5, 9);
insert into bookauthordetail (book_id, author_id) values (6, 19);
insert into bookauthordetail (book_id, author_id) values (7, 17);
insert into bookauthordetail (book_id, author_id) values (8, 12);
insert into bookauthordetail (book_id, author_id) values (9, 15);
insert into bookauthordetail (book_id, author_id) values (10, 18);
insert into bookauthordetail (book_id, author_id) values (11, 8);
insert into bookauthordetail (book_id, author_id) values (12, 17);
insert into bookauthordetail (book_id, author_id) values (13, 14);
insert into bookauthordetail (book_id, author_id) values (14, 6);
insert into bookauthordetail (book_id, author_id) values (15, 12);
insert into bookauthordetail (book_id, author_id) values (16, 12);
insert into bookauthordetail (book_id, author_id) values (17, 16);
insert into bookauthordetail (book_id, author_id) values (18, 6);
insert into bookauthordetail (book_id, author_id) values (19, 17);
insert into bookauthordetail (book_id, author_id) values (20, 11);
insert into bookauthordetail (book_id, author_id) values (8, 4);
insert into bookauthordetail (book_id, author_id) values (1, 2);
insert into bookauthordetail (book_id, author_id) values (13, 20);
insert into bookauthordetail (book_id, author_id) values (2, 11);
insert into bookauthordetail (book_id, author_id) values (5, 2);
insert into bookauthordetail (book_id, author_id) values (10, 14);
insert into bookauthordetail (book_id, author_id) values (17, 5);
insert into bookauthordetail (book_id, author_id) values (2, 12);


insert into bookpublisherdetail (book_id, publisher_id, published_date) values (1, 1, '2011-08-07 16:58:11');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (2, 6, '2015-03-31 20:17:45');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (3, 1, '2018-08-21 06:26:12');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (4, 8, '2017-02-04 11:47:32');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (5, 8, '2002-07-09 06:56:05');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (6, 2, '2002-03-29 22:01:09');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (6, 5, '2002-03-29 22:01:09');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (7, 4, '2018-02-07 20:21:40');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (8, 6, '2019-05-27 18:19:53');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (9, 5, '2017-06-28 08:24:06');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (10, 2, '2004-05-07 17:10:59');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (11, 6, '2007-03-26 03:16:26');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (12, 1, '2006-04-02 10:13:25');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (12, 4, '2006-04-02 10:13:25');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (12, 7, '2006-04-02 10:13:25');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (13, 9, '2002-03-18 06:19:16');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (14, 2, '2011-10-25 12:28:58');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (15, 9, '2013-06-14 14:03:49');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (16, 2, '2003-01-02 23:51:42');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (17, 9, '2001-11-18 09:08:36');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (18, 6, '2006-09-22 15:38:03');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (19, 1, '2019-11-06 19:46:08');
insert into bookpublisherdetail (book_id, publisher_id, published_date) values (20, 4, '2005-03-12 14:42:48');

insert into bookpricedetail (book_id, price_id) values (1, 15);
insert into bookpricedetail (book_id, price_id) values (2, 8);
insert into bookpricedetail (book_id, price_id) values (3, 5);
insert into bookpricedetail (book_id, price_id) values (4, 9);
insert into bookpricedetail (book_id, price_id) values (5, 15);
insert into bookpricedetail (book_id, price_id) values (6, 3);
insert into bookpricedetail (book_id, price_id) values (7, 11);
insert into bookpricedetail (book_id, price_id) values (8, 20);
insert into bookpricedetail (book_id, price_id) values (9, 9);
insert into bookpricedetail (book_id, price_id) values (10, 12);
insert into bookpricedetail (book_id, price_id) values (11, 9);
insert into bookpricedetail (book_id, price_id) values (12, 16);
insert into bookpricedetail (book_id, price_id) values (13, 10);
insert into bookpricedetail (book_id, price_id) values (14, 9);
insert into bookpricedetail (book_id, price_id) values (15, 3);
insert into bookpricedetail (book_id, price_id) values (16, 19);
insert into bookpricedetail (book_id, price_id) values (17, 6);
insert into bookpricedetail (book_id, price_id) values (18, 7);
insert into bookpricedetail (book_id, price_id) values (19, 1);
insert into bookpricedetail (book_id, price_id) values (20, 19);





