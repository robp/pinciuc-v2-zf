<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: Db_Odbc
// ------------------------------------------------------------------------
// Creates and maintains state about a database connection
// Contains functions to execute SQL queries and store the
// result sets
// ------------------------------------------------------------------------
class Db_Odbc {
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
	function Db_Odbc($db = '', $dsn = "myodbc", $uid = "apache", $pwd = "f00bar") {
		$this->debug = false;
		$this->queries = 0;

		if (!$this->db = odbc_connect($dsn, $uid, $pwd)) {
			echo "<p>Error connecting to data source: ";
			echo odbc_errormsg()." (".odbc_error().")</p>\n";
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
			$sql = "USE $str_db";
			$this->query_exec($sql);
			$this->queries--; // don't count this query
			$this->db_name_prev = ($this->db_name) ? $this->db_name : $str_db;
			$this->db_name = $str_db;
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

		if ($this->debug)
			echo "<pre>$sql</pre>";
		$this->queries++;

		// prepare the statement
		if (!$this->stmt = odbc_prepare($this->db, $sql)) {
			echo "<p>Error preparing SQL statement:";
			echo odbc_errormsg()." (".odbc_error().")</p>\n";
			echo "<p><pre><blockquote>$sql</blockquote></pre></p>\n";
			exit();
		}

		// execute the statement
		// don't do this if it's an INSERT or UPDATE, as the odbc_prepare() above
		// seems to automatically execute these
		if (!eregi('^ *(INSERT|UPDATE)', $sql)) {
			if (!odbc_execute($this->stmt)) {
				echo "<p>Error executing SQL statement:";
				echo odbc_errormsg()." (".odbc_error().")</p>\n";
				echo "<p><pre><blockquote>$sql</blockquote></pre></p>\n";
				exit();
			}
		}

		// Store the number of result rows in $rc
		$this->rc = odbc_num_rows($this->stmt);

		// Store any result rows in the $rs[] array
		// with name and number array subscripts
		if ($this->rc > 0) {
			while (odbc_fetch_row($this->stmt)) {
				$row = array();
				for ($a = 1; $a <= odbc_num_fields($this->stmt); $a++) {
					$fname = odbc_field_name($this->stmt, $a);
					$row[$fname] = odbc_result($this->stmt, $a);
				}
				$this->rs[] = $row;
			}
		}

		odbc_free_result($this->stmt);
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
