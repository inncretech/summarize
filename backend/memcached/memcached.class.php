<?php 
//require_once "../constants.php";

class Memcached_Connection
{
   var $connection;
   var $check = false;
   /* Class constructor */
   function Memcached_Connection($servers,$port){
		$this->connection = new Memcached();
		$this->check = true;
		if (count($servers)>0){
			$this->check=false;
			foreach ($servers as $server){
				$this->connection->addServer($server, $port);
			}
		}
   }
   
   function getCacheProdCount(){
		return $this->connection->get("prodCount");
   }
   
   function cacheProduct($pid,$details,$categories,$feedback){
		$this->cacheProductDetails($pid,$details);
		$this->cacheProductCategories($pid,$category);
		$this->cacheProductFeedback($pid,$feedback);
		$this->connection->replace("prodCount",($this->getCacheProdCount()+1));
   }
   
   function cacheProductDetails($pid,$details){
		$this->connection->set("p-".$pid,$details);
   }
   function cacheProductCategories($pid,$categories){
		$this->connection->set("c-".$pid,$categories);
   }
   function cacheProductFeedback($pid,$feedback){
		foreach ($feedback as $key=>$value){
			$this->connection->set("f-".$key."-".$pid,$value);
		}
   }
   
   function replaceProduct($pid,$details,$categories,$feedback){
		$this->replaceProductDetails($pid,$details);
		$this->replaceProductCategories($pid,$category);
		$this->replaceProductFeedback($pid,$feedback);
   }
   
   function replaceProductDetails($pid,$details){
		$this->connection->replace("p-".$pid,$details);
   }
   function replaceProductCategories($pid,$categories){
		$this->connection->replace("c-".$pid,$categories);
   }
   function replaceProductFeedback($pid,$feedback){
		foreach ($feedback as $key=>$value){
			$this->connection->replace("f-".$key."-".$pid,$value);
		}
   }
   
    function addProductFeedback($pid,$category,$feedback){
		$this->connection->replace("f-".$category."-".$pid,$feedback);		
   }
   
   function deleteProduct($pid){
		$this->connection->delete("p-".$pid);
		$categories = $this->connection->get("c-".$pid);
		$this->connection->delete("c-".$pid);
		foreach ($categories as $category){
			$this->connection->delete("f-".$category."-".$pid);
		}
		$this->connection->replace("prodCount",($this->getCacheProdCount()-1));
   }

}
$servers=explode(",",MEMCACHED_HOSTS);
$memcached = new Memcached_Connection($servers,MEMCACHED_PORT);
?>
