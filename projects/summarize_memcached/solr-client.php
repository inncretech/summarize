<?php
session_start(); 
include "include/database.php";
// make sure browsers see this page as utf-8 encoded HTML
header('Content-Type: text/html; charset=utf-8');


  // The Apache Solr Client library should be on the include path
  // which is usually most easily accomplished by placing in the
  // same directory as this script ( . or current directory is a default
  // php include path entry in the php.ini)
  require_once('Apache/Solr/Service.php');

  // create a new solr service instance - host, port, and webapp
  // path (all defaults in this example)
  $solr = new Apache_Solr_Service(SOLR_HOST, SOLR_PORT, SOLR_PATH);
	
	if ( ! $solr->ping() ) {
		echo 'Solr service not responding.';
		exit;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
	<body>
     
       <?php include "include/searchbox.php"; ?>
  
      <div id="container">
        <div id="innercontainer">
          <div class="summary" style="width:990px;">
		   <?
				$offset=0;
				$limit= 10;
				$queries = array('blog_tags: '.$_GET['q']);

				foreach ( $queries as $query ) {
					$response = $this->connection->search( $query, $offset, $limit );
					
					if ( $response->getHttpStatus() == 200 ) {	
						print_r( $response->getRawResponse() );
						
						if ( $response->response->numFound > 0 ) {
							echo "$query <br />";

							foreach ( $response->response->docs as $doc ) { 
								echo "$doc->partno $doc->name <br />";
							}
							
							echo '<br />';
						}
					}
					else {
						echo $response->getHttpStatusMessage();
					}
				}
		   ?>
        </div>
	  </div>
    </div>
</body>
</html>

