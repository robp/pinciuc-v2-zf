<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------
 
// ------------------------------------------------------------------------
// class: Blog_Category
// ------------------------------------------------------------------------
// Represents a web log sub category
// ------------------------------------------------------------------------
class Blog_Category {
	var $id;                // Numeric ID
	var $blog_id;           // ID of the blog
	var $title;             // Title of the log
	var $description;       // Brief description
	
	var $entries;			// Blog entries in this category

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Blog_Category($id = 0, $row = array()) {
		global $db;
		$this->entries = array();

		if ($id) {
			$sql = "SELECT * FROM blog_category
					WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->blog_id = $row[blog_id];
			$this->title = $row[title];
			$this->description = $row[description];
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO blog_category
				VALUES (null,
				$this->blog_id,
				'".DB::encode($this->title)."',
				'".DB::encode($this->description)."'
				)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE blog_category SET
				blog_id = $this->blog_id,
				title = '".DB::encode($this->title)."',
				description = '".DB::encode($this->description)."'
				WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM blog_category
				WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_entries($args = array()) {
		global $db;
		$this->entries = array();

		$sql = "SELECT be.* 
				FROM blog_entry AS be, blog_entry_category AS bec
				WHERE bec.blog_category_id = $this->id
				  AND bec.blog_entry_id = be.id ";

		$sql .= "ORDER BY creation_date ".($args[order] ? "$args[order] " : 'DESC ');
		$sql .= ($args[limit] ? 'LIMIT '.$args[limit].' ' : '');

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->entries[] = new Blog_Entry(0, $row);
	}

	function get_num_entries() {
		global $db;
 
		$result = 0;

		$sql = "SELECT COUNT(*) AS num_entries FROM blog_entry
				WHERE category_id = $this->id";

		$db->query_exec($sql);

		if ($db->rc == 1)
			$result = $db->rs[0][num_entries];
 
		return $result;
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------
}
