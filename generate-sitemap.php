<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        $time = explode(" ",microtime());
        $time = $time[1];

        // include class
        include 'backend/seo/SitemapGenerator.php';
		include 'backend/session.class.php';
		
		$database = new Database();
		
        // create object
        $sitemap = new SitemapGenerator("http://www.summarizit.com/");
		
        // sitemap file name
        $sitemap->sitemapFileName = "sitemap.xml";

        // sitemap index file name
        $sitemap->sitemapIndexFileName = "sitemap-index.xml";

        // robots file name
        $sitemap->robotsFileName = "robots.txt";

        // add urls
		$sitemap->addUrl("http://www.summarizit.com/",date('c'),'daily','1');
        $sitemap->addUrl("http://www.summarizit.com/index.php",date('c'),'daily','1');
        $sitemap->addUrl("http://www.summarizit.com/recently-added.php",date('c'),'daily','0.9');
        $sitemap->addUrl("http://www.summarizit.com/most-viewed.php",date('c'),'daily','0.9');
        $sitemap->addUrl("http://www.summarizit.com/highest-rated.php",date('c'),'daily','0.9');
        $sitemap->addUrl("http://www.summarizit.com/survey.php?id=26",date('c'),'daily','0.8');
		
		$productSeoLinks = $database->product->getAllSeoTitles();
		echo "Products: ".count($productSeoLinks);
		foreach ($productSeoLinks as $item){
			$sitemap->addUrl("http://www.summarizit.com/product/".$item['seo_title'],date('c'),'daily','0.7');
		}

        try {
            // create sitemap
            $sitemap->createSitemap();

            // write sitemap as file
            $sitemap->writeSitemap();

            // update robots.txt file
            $sitemap->updateRobots();

            // submit sitemaps to search engines
            $result = $sitemap->submitSitemap();
			
            // shows each search engine submitting status
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            
        }
        catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        echo "Memory peak usage: ".number_format(memory_get_peak_usage()/(1024*1024),2)."MB";
        $time2 = explode(" ",microtime());
        $time2 = $time2[1];
        echo "<br>Execution time: ".number_format($time2-$time)."s";
        ?>
    </body>
</html>
