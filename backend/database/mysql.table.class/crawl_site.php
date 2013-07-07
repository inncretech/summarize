<?php
class crawl_site
{
	var $connection;
	var $table = "`crawl_site`";
	/* Class constructor */
	function crawl_site($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	function add($url,$created_by){
		mysql_query("INSERT INTO ".$this->table." (`url`,`created_by`) VALUES ('$url','$created_by')",$this->connection);
	}
}
?>