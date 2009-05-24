-- schema
CREATE TABLE shorten_url
(
url_id mediumint NOT NULL auto_increment,
target_url varchar(255) NOT NULL,
short_url varchar(100) NOT NULL,
date_created datetime NOT NULL,

PRIMARY KEY(url_id),
UNIQUE KEY (target_url)
); 


-- insert data
INSERT INTO `podshow`.`shorten_url` (
`url_id` ,
`target_url` ,
`short_url` ,
`date_created`
)
VALUES (
NULL , 'http://example.com/', 'http://tinyurl.com/kotu', NOW( )
);


-- get data
SELECT `short_url`
FROM `shorten_url`
WHERE `target_url` = 'http://example.com/'
LIMIT 1

