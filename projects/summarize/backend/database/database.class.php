<?
/** Include site constants
*/
//require_once "../constants.php";

/** Include Mysql Table classes
*/

require_once "mysql.table.class/address.php";
require_once "mysql.table.class/school.php";
require_once "mysql.table.class/employer.php";
require_once "mysql.table.class/member_address.php";
require_once "mysql.table.class/member_school.php";
require_once "mysql.table.class/member_employer.php";
require_once "mysql.table.class/member_activity.php";
require_once "mysql.table.class/member_info.php";
require_once "mysql.table.class/member.php";
require_once "mysql.table.class/member_session.php";
require_once "mysql.table.class/reference_question.php";
require_once "mysql.table.class/report_spam.php";
require_once "mysql.table.class/tag.php";
require_once "mysql.table.class/product.php";
require_once "mysql.table.class/product_info.php";
require_once "mysql.table.class/product_tag.php";
require_once "mysql.table.class/product_follow.php";
require_once "mysql.table.class/compare_products.php";
require_once "mysql.table.class/product_feedback.php";
require_once "mysql.table.class/questions.php";
require_once "mysql.table.class/answers.php";
require_once "mysql.table.class/comment_answers.php";
require_once "mysql.table.class/notifications.php";
require_once "mysql.table.class/view_details.php";
require_once "mysql.table.class/message.php";
require_once "mysql.table.class/point.php";
require_once "mysql.table.class/image_table.php";
require_once "mysql.table.class/product_image.php";
require_once "mysql.table.class/member_feedback.php";
require_once "mysql.table.class/member_image.php";


/** A PHP class to access MySQL database with convenient methods
* in an object oriented way, and with a powerful debug system.
*/

class Database
{
	/** Mysql Table Classes Objects
	  */
	 var $address;
	 var $school;
	 var $employer;
	 var $member_address;
	 var $member_school;
	 var $member_employer;
	 var $member_info;
	 var $member_activity;
	 var $member;
	 var $member_session;
	 var $reference_question;
	 var $report_spam;
	 var $tag;
	 var $product;
	 var $product_info;
	 var $product_tag;
	 var $product_follow;
	 var $compare_products;
	 var $product_feedback;
	 var $questions;
	 var $answers;
	 var $comment_answers;
	 var $notifications;
	 var $view_details;
	 var $message;
	 var $point;
	 var $image_table;
	 var $product_image;
	 var $member_feedback;
	 var $member_image;
	
	/** Put this variable to true if you want ALL queries to be debugged by default:
	  */
	var $defaultDebug = false;

	/** INTERNAL: The start time, in miliseconds.
	  */
	var $mtStart;
	/** INTERNAL: The number of executed queries.
	  */
	var $nbQueries;
	/** INTERNAL: The last result ressource of a query().
	  */
	var $lastResult;
	
	/** INTERNAL: Connection variable.
	  */

	var $connection;
	  
	/** Connect to a MySQL database to be able to use the methods below.
	  */
	function Database()
	{
	  $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('Server connexion not possible.');
	  mysql_select_db(DB_NAME) or die('Database connexion not possible.');
	  $this->mtStart    		= $this->getMicroTime();
	  $this->nbQueries  		= 0;
	  $this->lastResult		 	= NULL;
	  
	  $this->address				= new address($this->connection);
	  $this->school       			= new school($this->connection);
	  $this->employer    			= new employer($this->connection);
	  $this->member_address  		= new member_address($this->connection);
	  $this->member_school    		= new member_school($this->connection);
	  $this->member_employer      	= new member_employer($this->connection);
	  $this->member_info    		= new member_info($this->connection);
	  $this->member       			= new member($this->connection);
	  $this->member_session    		= new member_session($this->connection);
	  $this->reference_question		= new reference_question($this->connection);
	  $this->report_spam    		= new report_spam($this->connection);
	  $this->tag   					= new tag($this->connection);
	  $this->product 				= new product($this->connection);
	  $this->product_info 			= new product_info($this->connection);
	  $this->product_tag 			= new product_tag($this->connection);
	  $this->product_follow 		= new product_follow($this->connection);
	  $this->compare_products 		= new compare_products($this->connection);
	  $this->product_feedback 		= new product_feedback($this->connection);
	  $this->questions 				= new questions($this->connection);
	  $this->answers 				= new answers($this->connection);
	  $this->comment_answers 		= new comment_answers($this->connection);
	  $this->member_activity 		= new member_activity($this->connection);
	  $this->notifications 			= new notifications($this->connection);
	  $this->view_details 			= new view_details($this->connection);
	  $this->message 				= new message($this->connection);
	  $this->point 					= new point($this->connection);
	  $this->image_table 			= new image_table($this->connection);
	  $this->product_image 			= new product_image($this->connection);
	  $this->member_feedback 		= new member_feedback($this->connection);
	  $this->member_image 			= new member_image($this->connection);
	}
	
	function escape($data)
	{
		$escaped_data = array();
		foreach ($data as $key=>$value){
			if (is_array($value)){
				$escaped_data[$key] = $this->escape($value);
			}else{
				$escaped_data[$key] = mysql_real_escape_string($value); 
			}		
		}
		return $escaped_data;
	}
	
	/** Query the database.
	  * @param $query The query.
	  * @param $debug If true, it output the query and the resulting table.
	  * @return The result of the query, to use with fetchNextObject().
	  */
	function query($query, $debug = -1)
	{
	  $this->nbQueries++;
	  $this->lastResult = mysql_query($query, $this->connection) or $this->debugAndDie($query);

	  $this->debug($debug, $query, $this->lastResult);

	  return $this->lastResult;
	}
	/** Do the same as query() but do not return nor store result.\n
	  * Should be used for INSERT, UPDATE, DELETE...
	  * @param $query The query.
	  * @param $debug If true, it output the query and the resulting table.
	  */
	function execute($query, $debug = -1)
	{
	  $this->nbQueries++;
	  mysql_query($query, $this->connection) or $this->debugAndDie($query);

	  $this->debug($debug, $query);
	}
	/** Convenient method for mysql_fetch_object().
	  * @param $result The ressource returned by query(). If NULL, the last result returned by query() will be used.
	  * @return An object representing a data row.
	  */
	function fetchNextObject($result = NULL)
	{
	  if ($result == NULL)
		$result = $this->lastResult;

	  if ($result == NULL || mysql_num_rows($result) < 1)
		return NULL;
	  else
		return mysql_fetch_object($result);
	}
	/** Get the number of rows of a query.
	  * @param $result The ressource returned by query(). If NULL, the last result returned by query() will be used.
	  * @return The number of rows of the query (0 or more).
	  */
	function numRows($result = NULL)
	{
	  if ($result == NULL)
		return mysql_num_rows($this->lastResult);
	  else
		return mysql_num_rows($result);
	}
	/** Get the result of the query as an object. The query should return a unique row.\n
	  * Note: no need to add "LIMIT 1" at the end of your query because
	  * the method will add that (for optimisation purpose).
	  * @param $query The query.
	  * @param $debug If true, it output the query and the resulting row.
	  * @return An object representing a data row (or NULL if result is empty).
	  */
	function queryUniqueObject($query, $debug = -1)
	{
	  $query = "$query LIMIT 1";

	  $this->nbQueries++;
	  $result = mysql_query($query, $this->connection) or $this->debugAndDie($query);

	  $this->debug($debug, $query, $result);

	  return mysql_fetch_object($result);
	}
	/** Get the result of the query as value. The query should return a unique cell.\n
	  * Note: no need to add "LIMIT 1" at the end of your query because
	  * the method will add that (for optimisation purpose).
	  * @param $query The query.
	  * @param $debug If true, it output the query and the resulting value.
	  * @return A value representing a data cell (or NULL if result is empty).
	  */
	function queryUniqueValue($query, $debug = -1)
	{
	  $query = "$query LIMIT 1";

	  $this->nbQueries++;
	  $result = mysql_query($query, $this->connection) or $this->debugAndDie($query);
	  $line = mysql_fetch_row($result);

	  $this->debug($debug, $query, $result);

	  return $line[0];
	}
	/** Get the maximum value of a column in a table, with a condition.
	  * @param $column The column where to compute the maximum.
	  * @param var $table The table where to compute the maximum.
	  * @param $where The condition before to compute the maximum.
	  * @return The maximum value (or NULL if result is empty).
	  */
	function maxOf($column, $table, $where)
	{
	  return $this->queryUniqueValue("SELECT MAX(`$column`) FROM `var $table` WHERE $where");
	}
	/** Get the maximum value of a column in a table.
	  * @param $column The column where to compute the maximum.
	  * @param var $table The table where to compute the maximum.
	  * @return The maximum value (or NULL if result is empty).
	  */
	function maxOfAll($column, $table)
	{
	  return $this->queryUniqueValue("SELECT MAX(`$column`) FROM `var $table`");
	}
	/** Get the count of rows in a table, with a condition.
	  * @param var $table The table where to compute the number of rows.
	  * @param $where The condition before to compute the number or rows.
	  * @return The number of rows (0 or more).
	  */
	function countOf($table, $where)
	{
	  return $this->queryUniqueValue("SELECT COUNT(*) FROM `var $table` WHERE $where");
	}
	/** Get the count of rows in a table.
	  * @param var $table The table where to compute the number of rows.
	  * @return The number of rows (0 or more).
	  */
	function countOfAll($table)
	{
	  return $this->queryUniqueValue("SELECT COUNT(*) FROM `var $table`");
	}
	/** Internal function to debug when MySQL encountered an error,
	  * even if debug is set to Off.
	  * @param $query The SQL query to echo before diying.
	  */
	function debugAndDie($query)
	{
	  $this->debugQuery($query, "Error");
	  die("<p style=\"margin: 2px;\">".mysql_error()."</p></div>");
	}
	/** Internal function to debug a MySQL query.\n
	  * Show the query and output the resulting table if not NULL.
	  * @param $debug The parameter passed to query() functions. Can be boolean or -1 (default).
	  * @param $query The SQL query to debug.
	  * @param $result The resulting table of the query, if available.
	  */
	function debug($debug, $query, $result = NULL)
	{
	  if ($debug === -1 && $this->defaultDebug === false)
		return;
	  if ($debug === false)
		return;

	  $reason = ($debug === -1 ? "Default Debug" : "Debug");
	  $this->debugQuery($query, $reason);
	  if ($result == NULL)
		echo "<p style=\"margin: 2px;\">Number of affected rows: ".mysql_affected_rows()."</p></div>";
	  else
		$this->debugResult($result);
	}
	/** Internal function to output a query for debug purpose.\n
	  * Should be followed by a call to debugResult() or an echo of "</div>".
	  * @param $query The SQL query to debug.
	  * @param $reason The reason why this function is called: "Default Debug", "Debug" or "Error".
	  */
	function debugQuery($query, $reason = "Debug")
	{
	  $color = ($reason == "Error" ? "red" : "orange");
	  echo "<div style=\"border: solid $color 1px; margin: 2px;\">".
		   "<p style=\"margin: 0 0 2px 0; padding: 0; background-color: #DDF;\">".
		   "<strong style=\"padding: 0 3px; background-color: $color; color: white;\">$reason:</strong> ".
		   "<span style=\"font-family: monospace;\">".htmlentities($query)."</span></p>";
	}
	/** Internal function to output a table representing the result of a query, for debug purpose.\n
	  * Should be preceded by a call to debugQuery().
	  * @param $result The resulting table of the query.
	  */
	function debugResult($result)
	{
	  echo "<table border=\"1\" style=\"margin: 2px;\">".
		   "<thead style=\"font-size: 80%\">";
	  $numFields = mysql_num_fields($result);
	  // BEGIN HEADER
	  $tables    = array();
	  $nbTables  = -1;
	  $lastTable = "";
	  $fields    = array();
	  $nbFields  = -1;
	  while ($column = mysql_fetch_field($result)) {
		if ($column->table != $lastTable) {
		  $nbTables++;
		  $tables[$nbTables] = array("name" => $column->table, "count" => 1);
		} else
		$tables[$nbTables]["count"]++;
		$lastTable = $column->table;
		$nbFields++;
		$fields[$nbFields] = $column->name;
	  }
	  for ($i = 0; $i <= $nbTables; $i++)
		echo "<th colspan=".$tables[$i]["count"].">".$tables[$i]["name"]."</th>";
	  echo "</thead>";
	  echo "<thead style=\"font-size: 80%\">";
	  for ($i = 0; $i <= $nbFields; $i++)
		echo "<th>".$fields[$i]."</th>";
	  echo "</thead>";
	  // END HEADER
	  while ($row = mysql_fetch_array($result)) {
		echo "<tr>";
		for ($i = 0; $i < $numFields; $i++)
		  echo "<td>".htmlentities($row[$i])."</td>";
		echo "</tr>";
	  }
	  echo "</table></div>";
	  $this->resetFetch($result);
	}
	/** Get how many time the script took from the begin of this object.
	  * @return The script execution time in seconds since the
	  * creation of this object.
	  */
	function getExecTime()
	{
	  return round(($this->getMicroTime() - $this->mtStart) * 1000) / 1000;
	}
	/** Get the number of queries executed from the begin of this object.
	  * @return The number of queries executed on the database server since the
	  * creation of this object.
	  */
	function getQueriesCount()
	{
	  return $this->nbQueries;
	}
	/** Go back to the first element of the result line.
	  * @param $result The resssource returned by a query() function.
	  */
	function resetFetch($result)
	{
	  if (mysql_num_rows($result) > 0)
		mysql_data_seek($result, 0);
	}
	/** Get the id of the very last inserted row.
	  * @return The id of the very last inserted row (in any table).
	  */
	function lastInsertedId()
	{
	  return mysql_insert_id();
	}
	/** Close the connexion with the database server.\n
	  * It's usually unneeded since PHP do it automatically at script end.
	  */
	function close()
	{
	  mysql_close($this->connection);
	}

	/** Internal method to get the current time.
	  * @return The current time in seconds with microseconds (in float format).
	  */
	function getMicroTime()
	{
	  list($msec, $sec) = explode(' ', microtime());
	  return floor($sec / 1000) + $msec;
	}
} // class Database
?>
