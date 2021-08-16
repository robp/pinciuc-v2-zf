<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: Db
// ------------------------------------------------------------------------
// Creates and maintains state about a database connection
// Contains functions to execute SQL queries and store the
// result sets
// ------------------------------------------------------------------------
class Db {
	var $db;		// ODBC connection handle
	var $db_name;	// name of database
	var $db_name_prev;	// name of previous database
	var $rc;		// Result count of last query
	var $stmt;		// ODBC statement handle
	var $rs;		// Array to store query results

	var $debug;		// Output queries for debugging
	var $queries;		// Stores number of queries executed

	// --------------------------------------------------------------------
	// Constructor connects to the database using defaults, or
	// supplied credentials
	// --------------------------------------------------------------------
	function Db($db = '', $dsn = "myodbc", $uid = "apache", $pwd = "f00bar") {
		$thie->debug = false;
		$this->queries = 0;

		if (!$this->db = mysql_connect(':/tmp/mysql.sock', $uid, $pwd)) {
			echo '<p>Error connecting to data source:</p>';
			if ($this->debug)
				echo "<p>".mysql_error()." (".mysql_errno().")</p>\n";
			else
				echo '<p>Debug mode off, error message suppressed.</p>';
			exit();
		}

		if ($db)
			$this->select_db($db);
	}

	// --------------------------------------------------------------------
	// Select a database by name
	// --------------------------------------------------------------------
	function select_db($str_db) {
		if ($str_db != $this->db_name) {
			if (!$db_selected = mysql_select_db($str_db)) {
				echo '<p>Error selecting database "'.$str_db.'".</p>';
				exit();
			}
			else {
				$this->db_name_prev = ($this->db_name) ? $this->db_name : $str_db;
				$this->db_name = $str_db;
			}
		}
	}

	// --------------------------------------------------------------------
	// Revert to previous db
	// --------------------------------------------------------------------
	function revert_db() {
		$this->select_db($this->db_name_prev);
	}

	// --------------------------------------------------------------------
	// prepare and then execute a supplied sql statement
	// --------------------------------------------------------------------
	function query_exec($sql) {
		$this->rc = null;		// Reset the result count and
		$this->rs = array();	// result set vars on each query

		$sql = trim($sql);

		if ($this->debug)
			echo "<pre>$sql</pre>";
		$this->queries++;

		if (!$this->stmt = mysql_query($sql)) {
			echo '<p>Error executing SQL statement:</p>';
			if ($this->debug) {
				echo "<p>".mysql_error()." (".mysql_errno().")</p>\n";
				echo "<p><pre><blockquote>$sql</blockquote></pre></p>\n";
			}
			else
				echo '<p>Debug mode off, error message suppressed.</p>';
			exit();
		}

		// Store the number of result rows in $rc
		if ($this->stmt) {
			if (preg_match('/^(SELECT|SHOW) /', $sql))
				$this->rc = mysql_num_rows($this->stmt); 
			else
				$this->rc = mysql_affected_rows();
			
			// Store any result rows in the $rs[] array
			// with name and number array subscripts
			if (preg_match('/^(SELECT|SHOW) /', $sql)) {
				while ($row = mysql_fetch_array($this->stmt))
					$this->rs[] = $row;
			}

			if (preg_match('/^(SELECT|SHOW) /', $sql))
				mysql_free_result($this->stmt);
		}
	}

	function get_insert_id() {
		$sql = "SELECT LAST_INSERT_ID() AS id";

		$this->query_exec($sql);

		if ($this->rc == 1) {
			$row = $this->rs[0];
			return $row[id];
		}
	}

	function encode($str) {
		return str_replace("'", "''", $str);
	}
}
