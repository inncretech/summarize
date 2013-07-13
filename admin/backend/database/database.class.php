<?
// Include site constants 

include "constants.php";

/** A PHP class to access MySQL database with convenient methods
* in an object oriented way, and with a powerful debug system.
*/

class Database
{
	var $connection;
	  
	// Connect to a MySQL database to be able to use the methods below.
	 
	function Database()
	{
		try{
			$this->connection = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS,array(PDO::ATTR_PERSISTENT => true));
	 		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	 		//Dynamically Generate Table Objects From The Database
	 		foreach ($this->connection->query("SHOW TABLES") as $item) {
			
				
				$file_path = realpath(__DIR__)."/mysql.table.class/".$item[0].".php";
				if (file_exists($file_path)) { 
					
					// Include Mysql Table Class File
					include $file_path; 
					
					// Created Mysql Table Object
					$this->$item[0] = new $item[0]($this->connection);
				}
 			}

 			//Define All Options From Database
 			$this->defineConstants();

		} catch(PDOException $exception){
			print "Error!: " . $exception->getMessage() . "<br/>";
			die();
		}
	}
	
	function defineConstants(){
  		$system = $this->system->getAll();
  		foreach ($system as $item) {
 			DEFINE($item['key'],$item['value']);
 		}
 	}
}

//Declare Database Class
$db = new Database();
?>
