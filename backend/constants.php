<?php

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "admin12()");
define("DB_NAME", "summarize");
define("EXPERT_POINTS", "5");

define("SITE_ROOT", "http://www.summarizit.com");

define("S3_SECRET","9EPKTOzmnVr5YHLJkSv4umnhRC64BysDeVgRGhTh");
define("S3_ACCESS","AKIAJOXBJIL3WPPPA6AQ");
define("S3_BUCKET","summarizit");

define("TAG_POINTS", "1");
define("FEEDBACK_POINTS", "5");
define("LIKE_POINTS", "2");
define("PRODUCT_POINTS", "10");
define("QUESTION_POINTS", "5");
define("ANSWER_POINTS", "10");
define("ANSWER_RATE_POINTS", "2");
 
define("FB_APP_ID", "284555878320108");
define("FB_APP_SECRET", "0aeaad8d5bb6998a90f36c8b2fa1944f");

define("TW_APP_ID", "sP8jqLIqxWlpCV69zf5Zbw");
define("TW_APP_SECRET", "ldeBgnO5ltA9KHguo5grZMnzVzBqQ8OIFVM8lfXk");

define("SOLR_HOST", 'ec2-54-243-196-105.compute-1.amazonaws.com');
define("SOLR_PORT", '8080');
define("SOLR_PATH", '/solr/collection1/');
define("SOLR_UPDATE_URL", 'http://ec2-54-243-196-105.compute-1.amazonaws.com:8080/solr/collection1/update?commit=true');

define("MEMCACHED_HOSTS", 'ec2-54-243-196-105.compute-1.amazonaws.com'); //use coma to separate them
define("MEMCACHED_PORT", 11211);
define("MEMCACHED_RANK", 100);

define("AWS_SAS_ACCESS","AKIAJOXBJIL3WPPPA6AQ");
define("AWS_SAS_SECRET","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");
define("AWS_SAS_EMAIL","summarizit@gmail.com");
?>
