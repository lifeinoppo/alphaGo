<?php
/**
 * dbProxy.php
 * 
 * @package	dbproxy
 * refrence from @author	guanhua2011(guanhua2011@gmail.com)
 * @author : Teslar 
 * @version	v1.0.0
 */
class dbProxy
{
	/**
	 * mysqli instance
	 * @var mysqli
	 */
	protected $mysqli = null;
	protected $dbname = '';
	protected $config;
	protected $lastSql;
	
	protected static $instance = array();
	
    private function __construct($dbname)
    {
        $this->dbname = $dbname;
        $this->config = dbConfig::$dbConfigArr[$dbname];
        $this->lastSql = '';
        $this->mysqli = $this->createConnection();
    }
    
    public static function getInstance($dbname)
    {
    	if (empty(self::$instance[$dbname])){
    		self::$instance[$dbname] = new self($dbname);
    	}
    	return self::$instance[$dbname];
    }
    
    private function createConnection()
    {
    	if($this->mysqli){
    		return $this->mysqli;
    	}
    	$mysqli = mysqli_init();
    	$is_OK = false;
    	for($i = 0; $i < $this->config['try_num']; $i++){
    		if(!$mysqli->real_connect($this->config['host'], $this->config['user'],
    			$this->config['password'], $this->dbname, $this->config['port'])){
    			$strError = "connect $host:{$this->config['port']} failed, errmsg:" . mysqli_connect_error();
	        	trigger_error($strError, E_USER_WARNING);
    			continue;
    		}
    		if(!$mysqli->set_charset($this->config['charset'])){
    			trigger_error("set charset to {$this->config['charset']} failed: {$mysqli->error}", E_USER_WARNING);
    			continue;
    		}
    		if(!$mysqli->select_db($this->dbname)){
    			trigger_error("select database {$this->dbname} failed: " . $mysqli->error, E_USER_WARNING);
    			continue;
    		}
    		$is_OK = true;
    	}
    	return $is_OK ? $mysqli : false;
    }
    
	/**
	 * Insert data into specified table
	 *
	 * @param array $arrFields	Data to be inserted in key/value array format
	 * @param string $table		Table name
	 * @return bool Returns true on success or false on failure
	 */
	public function insert(array $arrFields = array(), $table)
	{
		if (!$this->mysqli || count($arrFields) <= 0) {
			return false;
		}
		$this->lastSql = 'INSERT INTO ' . $table . ' (';
		$strValues = '';
		$needComma = false;
		foreach ($arrFields as $field => $value) {
			if ($needComma) {
				$this->lastSql .= ',';
				$strValues .= ',';
			}
			$needComma = true;
			$this->lastSql .= '`' . $field . '`';
			$strValues .= "'" . mysqli_real_escape_string($this->mysqli, $value) . "'";
		}
		$this->lastSql .= ') VALUES (' . $strValues . ')';
		$ret = $this->mysqli->query($this->lastSql);
		if (!$ret) {
			return false;
		}
		return true;
	}
	/**
	 * Perform a update query on the database
	 * @param string $strSql	The query string
	 * @return bool Returns true on success or false on failure
	 */
	public function update($strSql)
	{
		if (!$this->mysqli) {
			return false;
		}
		$this->lastSql = $strSql;
		return $this->mysqli->query($this->lastSql);
	}
	/**
	 * Perform a select query on the database and retriev all the result rows
	 * @param string $strSql	The query string
	 * @return bool|array	Return result rows on success or false on failure
	 */
	public function queryAllRows($strSql)
	{
		if (!$this->mysqli) {
			return false;
		}
		$this->lastSql = $strSql;
		$objRes = $this->mysqli->query($this->lastSql);
		if (!$objRes) {
			return false;
		}
		$arrResult = array();
		$arrTmp = $objRes->fetch_assoc();
		while ($arrTmp) {
			$arrResult[] = $arrTmp;
			$arrTmp = $objRes->fetch_assoc();
		}
		return $arrResult;
	}
	/**
	 * Perform a select query on the database and retriev the first row in results
	 * @param string $strSql	The query string
	 * @return bool|array	Return result row on success or false on failure
	 */
	public function queryFirstRow($strSql)
	{
		if (!$this->mysqli) {
			return false;
		}
		$this->lastSql = $strSql;
		$objRes = $this->mysqli->query($this->lastSql);
		if (!$objRes) {
			return false;
		}
		$arrResult = $objRes->fetch_assoc();
		if ($arrResult) {
			return $arrResult;
		}
		return false;
	}
	/**
	 * Perform a select query on the database and retriev the specified field value in the first row result
	 * @param string $strSql	The query string
	 * @param bool $isInt		Whether the specified field is integer type
	 * @return bool|int|string	Return field value on success or false on failure
	 */
	public function querySpecifiedField($strSql, $isInt = false)
	{
		if (!$this->mysqli) {
			return false;
		}
		$this->lastSql = $strSql;
		$objRes = $this->mysqli->query($this->lastSql);
		if (!$objRes) {
			return false;
		}
		$arrResult = $objRes->fetch_row();
		if ($arrResult) {
			if ($isInt) {
				return intval($arrResult[0]);
			}
			return $arrResult[0];
		} else {
			if ($isInt) {
				return 0;
			}
			return false;
		}
	}
	/**
	 * Do multiple sql queries as a transaction
	 *
	 * @param array $arrSql	Array of sql queries to be executed
	 * @return bool Returns true on success or false on failure
	 */
	public function doTransaction(array $arrSql)
	{
		if (!$this->mysqli) {
			return false;
		}
		$this->mysqli->autocommit(false);
		foreach ($arrSql as $strSql) {
			$ret = $this->mysqli->query($strSql);
			if (!$ret) {
				$this->lastSql = $strSql;
				$this->mysqli->rollback();
				$this->mysqli->autocommit(true);
				return false;
			}
		}
		$this->mysqli->commit();
		$this->mysqli->autocommit(true);
		return true;
	}
	/**
	 * Get the last inserted data's autoincrement id
	 * @return int
	 */
	public function getLastInsertID()
	{
		return mysqli_insert_id($this->mysqli);
	}
	/**
	 * Get number of affected rows of the last SQL query
	 * @return int
	 */
	public function getAffectedRows()
	{
		return mysqli_affected_rows($this->mysqli);
	}
	/**
	 * Selects the defaut database for database queries
	 * @param string $database	The database name
	 * @return bool Returns true on success or false on failure
	 */
	public function selectDB($dbname)
	{
		return $this->mysqli->select_db($dbname);
	}
	/**
	 * Escapes special characters in a string for use in a SQL query
	 * @param string $str	String to be escaped
	 * @return bool|string	Return escaped string on success or false on failure
	 */
	public function realEscapeString($str)
	{
		if (!$this->mysqli) {
			return false;
		}
		return $this->mysqli->real_escape_string($str);
	}
	/**
	 * Perform a select query on the database
	 * @param string $strSql	The query string
	 * @return mix	Return array on success or false on failure
	 */
	public function  doSelectQuery($strSql)
	{
		if (!$this->mysqli) {
			return false;
		}
		$this->lastSql = $strSql;
		$objRes = $this->mysqli->query($this->lastSql);
		if (!$objRes) {
			return false;
		}
		$arrResult = array();
		$arrTmp = $objRes->fetch_assoc();
		while ($arrTmp) {
			$arrResult[] = $arrTmp;
			$arrTmp = $objRes->fetch_assoc();
		}
		return $arrResult;
	}
	/**
	 * Perform a update query on the database
	 * @param string $strSql	The query string
	 * @return bool Returns true on success or false on failure
	 */
	public function doUpdateQuery($strSql)
	{
		if (!$this->mysqli) {
			return false;
		}
		$this->lastSql = $strSql;
		return $this->mysqli->query($this->lastSql);
	}
	/**
	 * Get errno of the last sql query
	 */
	public function getErrno()
	{
		if (!$this->mysqli) {
			return -1;
		} else {
			return $this->mysqli->errno;
		}
	}
	/**
	 * Get errmsg of the last sql query
	 */
	public function getErrmsg()
	{
		if (!$this->mysqli) {
			return 'mysql server not available';
		} else {
			$host = $this->current_host . ':' . $this->config['port'];
			return $host . ', ' . $this->mysqli->error;
		}
	}
	/**
	 * Get the sql string of last query
	 */
	public function getSqlStr()
	{
		return $this->lastSql;
	}
	/**
	 * Return a safe SQL string according to the format and its arguments
	 * Usage example:
	 * <code>
	 * $format = 'SELECT * FROM table WHERE age=%d and fav=%s';
	 * $sql = $dbproxy->buildSqlStr($format, $age, $fav);
	 * $res = $dbproxy->doSelectQuery($sql);
	 * </code>
	 * @param string $format	Template of SQL string
	 * @return string	Safe SQL query string
	 */
	public function buildSqlStr($format)
	{
		$argv = func_get_args();
		$argc = count($argv);
		$sql_params = array();
		if ($argc > 1) {
			if (!self::typeCheckVprintf($format, $argv, 1)) {
				return false;
			}
			for ($x = 1; $x < $argc; $x++) {
					if (is_string($argv[$x])) {
						$sql_str = $argv[$x];
						$sql_str = $this->realEscapeString($sql_str);
						if ($sql_str === false) {
							return false;
						}
						$sql_params[] = '\'' . $sql_str . '\'';
					} elseif (is_scalar($argv[$x])) {	// check for int/float/bool
						// don't do anything to int types, they are safe
						$sql_params[] = $argv[$x];
					} else {	// unsupported type (array, object, resource, null)
						return false;
					}
			}
			$sql = vsprintf($format, $sql_params);
		} else {
			$sql = str_replace('%%', '%', $format);
		}
		return $sql;
	}
	/**
	 * Build SQL query string for Insert operation
	 *
	 * @param array $arrFields	Data to be inserted in key/value array format
	 * @param string $table		Table name
	 * @return string	Safe SQL query string
	 */
	public function buildInsertSqlStr(array $arrFields, $table)
	{
		if (!$this->mysqli || count($arrFields) <= 0) {
			return false;
		}
		$strSql = 'INSERT INTO ' . $table . ' (';
		$strValues = '';
		$needComma = false;
		foreach ($arrFields as $field => $value) {
			if ($needComma) {
				$strSql .= ',';
				$strValues .= ',';
			}
			$needComma = true;
			$strSql .= '`' . $field. '`';
			if (is_string($value)) {
				$strValues .= "'" . mysqli_real_escape_string($this->mysqli, $value) . "'";
			} elseif (is_array($value) || is_object($value) || is_null($value)) {
				continue;
			} else {
				$strValues .= "'$value'";
			}
		}
		$strSql .= ') VALUES (' . $strValues . ')';
		return $strSql;
	}
	/**
	 * Build SQL query string <b>without WHERE condition</b> for update operation,
	 * callers should add <code>WHERE</code> condition part them self.
	 *
	 * @param array $arrFields	Data to be update in key/value array format
	 * @param string $table		Table name
	 * @return string	Safe SQL query string
	 */
	public function buildUpdateSqlStr(array $arrFields, $table)
	{
		if (!$this->mysqli || count($arrFields) <= 0) {
			return false;
		}
		$strSql = 'UPDATE ' . $table . ' SET ';
		$needComma = false;
		foreach ($arrFields as $field => $value) {
			if ($needComma) {
				$strSql .= ',';
			}
			$needComma = true;
			$strSql .= '`' . $field. '`=';
			if (is_string($value)) {
				$strSql .= "'" . mysqli_real_escape_string($this->mysqli, $value) . "'";
			} elseif (is_array($value) || is_object($value) || is_null($value)) {
				continue;
			} else {
				$strSql .= "'$value'";
			}
		}
		$strSql .= ' ';
		return $strSql;
	}
	/**
	 *
	 * @param string $format
	 * @param array $argv
	 * @param int $offset
	 */
	protected static function typeCheckVprintf($format, array &$argv, $offset)
	{
		$argc = count($argv);     // number of arguments total
		$specs = '+-\'-.0123456789';  // +-'-.0123456789 are special printf specifiers
		$pos   = 0;                   // string position
		$param = $offset;             // current parameter
		while ($pos = strpos($format, '%', $pos)) {	// read each %
			if ($format[$pos + 1] == '%') {	// '%%' for literal %
				$pos += 2;
				continue;
			}
			while ($pos2 = strpos($specs, $format{$pos + 1})) {	// read past specs chars
				$pos++;
			}
			if (ctype_alpha($format{$pos + 1})) {
				if ((!is_scalar($argv[$param])) && (!is_null($argv[$param]))) {
					return false;
				}
				switch ($format{$pos + 1}) {	// use ascii value
					case 's': // the argument is treated as and presented as a string.
						if (!is_string($argv[$param])) {
							$argv[$param] = (string)$argv[$param];
						}
						break;
					case 'd': // presented as a (signed) decimal number.
					case 'b': // presented as a binary number.
					case 'c': // presented as the character with that ASCII value.
					case 'e': // presented as scientific notation (e.g. 1.2e+2).
					case 'u': // presented as an unsigned decimal number.
					case 'o': // presented as an octal number.
					case 'x': // presented as a hexadecimal number (with lowercase letters).
					case 'X': // presented as a hexadecimal number (with uppercase letters).
						if (!is_int($argv[$param])) {
							$argv[$param] = (int)$argv[$param];
						}
						break;
					case 'f': // presented as a floating-point number (locale aware).
					case 'F': // presented as a floating-point number (non-locale aware).
						if (!is_float($argv[$param])) {
							$argv[$param] = (float)$argv[$param];
						}
						break;
				}
				$param++;  // next please!
			}
			$pos++;  // your number is up!
		}
		// make sure the number of parameters actually matches the number of params in string
		if ($param != $argc) {
			return false;
		}
		return true;
	}
}