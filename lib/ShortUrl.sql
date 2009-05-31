-- 
-- Short Url DB Setup
-- 

-- schema
CREATE TABLE IF NOT EXISTS short_urls
(
url_id mediumint NOT NULL auto_increment,
long_url varchar(255) NOT NULL,
short_url varchar(100) NOT NULL,
date_created datetime NOT NULL,

PRIMARY KEY(url_id),
UNIQUE KEY (long_url)
); 


-- insert data
INSERT INTO `short_urls` (
`url_id` ,
`long_url` ,
`short_url` ,
`date_created`
)
VALUES (
NULL , 'http://example.com/', 'http://tinyurl.com/kotu', NOW( )
);


-- get data
SELECT `short_url`
FROM `short_urls`
WHERE `long_url` = 'http://example.com/'
LIMIT 1

