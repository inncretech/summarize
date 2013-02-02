<?php
//require_once "../constants.php";

// The Apache Solr Client library should be on the include path
// which is usually most easily accomplished by placing in the
// same directory as this script ( . or current directory is a default
// php include path entry in the php.ini)
require_once('solr.sdk.class/Service.php'); 


class Solr
{
   var $connection;
   var $check = false;
   
   /* Class constructor */
    function Solr(){
		// create a new solr service instance - host, port, and webapp
		$this->connection = new Apache_Solr_Service(SOLR_HOST, SOLR_PORT, SOLR_PATH);
		if ( ! $solr->ping() ) {
			echo 'Solr service not responding.';
			exit;
		}else{
			$this->check = true;
		}
    }
	/*
	** Run some queries. Provide the raw path, a starting offset
	**   for result documents, and the maximum number of result
	**   documents to return. You can also use a fourth parameter
	**   to control how results are sorted, among other options.
	*/
	function search($offset,$limit,$queries){
		
		// Example: $queries = array('blog_tags: '.$_GET['q']);

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
	}
	
	/*
	** Curl function to add data to the Sorl server.
	*/
	
    function add($data){
		$post_string = '<add><doc>';
		foreach ($data as $key => $value){
			$post_string = '<field name="$key">$value</field>';
		}
		$post_string = ' </doc></add>';
		$header = array("Content-type:text/xml; charset=utf-8");

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, SOLR_UPDATE_URL);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

		$data = curl_exec($ch);

		if (curl_errno($ch)) {
		   //print "curl_error:" . curl_error($ch);
		} else {
		   curl_close($ch);
		   //print "curl exited okay\n";
		   // echo "Data returned...\n";
		   //echo "------------------------------------\n";
		   //echo $data;
		   //echo "------------------------------------\n";
		}
	}
}

?>