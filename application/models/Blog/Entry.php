<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: Blog_Entry
// ------------------------------------------------------------------------
// Represents a web log entry
// ------------------------------------------------------------------------
class Blog_Entry {
	var $id;                // Numeric ID
	var $blog_id;       // Blog that this belongs to
	var $category_id;       // Category ID of the blog category
	var $user_id;			// User ID of the author
	var $creation_date;		// Creation date and time of the entry
	var $views;				// Number of times this entry has been viewed
	var $allow_comments;	// Are viewers allowed to comment on this entry
	var $status;			// Status code
	var $title;             // Title of the log
	var $body;				// Entry body
	var $excerpt;			// Summary of body

	var $categories;		// Array of associated categories
	var $media;				// Media associated with this blog entry
	var $comments;			// Comments on this entry

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Blog_Entry($id = 0, $row = array()) {
		global $db;
		$this->media = array();
		$this->comments = array();

		if ($id) {
			$sql = "SELECT * FROM blog_entry
					WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->blog_id = $row[blog_id];
			$this->category_id = $row[category_id];
			$this->user_id = $row[user_id];
			$this->creation_date = $row[creation_date];
			$this->views = $row[views];
			$this->allow_comments = $row[allow_comments];
			$this->status = $row[status];
			$this->title = $row[title];
			$this->body = $row[body];
			$this->excerpt = $row[excerpt];
		}
	}

	function insert() {
		global $db;

		$this->creation_date = date('Y-m-d H:i:s');
		$this->views = 0;

		$sql = "INSERT INTO blog_entry
				VALUES (null,
				$this->blog_id,
				0,
				$this->user_id,
				'$this->creation_date',
				$this->views,
				'$this->allow_comments',
				'$this->status',
				'".DB::encode($this->title)."',
				'".DB::encode($this->body)."',
				'".DB::encode($this->excerpt)."'
				)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		foreach ($this->categories as $category) {
			$sql = "INSERT INTO blog_entry_category
					VALUES ($this->id, $category->id)";

			$db->query_exec($sql);
		}

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE blog_entry SET
				blog_id = $this->blog_id,
				user_id = $this->user_id,
				creation_date = '$this->creation_date',
				views = $this->views,
				allow_comments = '$this->allow_comments',
				status = '$this->status',
				title = '".DB::encode($this->title)."',
				body = '".DB::encode($this->body)."',
				excerpt = '".DB::encode($this->excerpt)."'
				WHERE id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM blog_entry_category
				WHERE blog_entry_id = $this->id";

		$db->query_exec($sql);
		
		foreach ($this->categories as $category) {
			$sql = "INSERT INTO blog_entry_category
					VALUES ($this->id, $category->id)";

			$db->query_exec($sql);
		}

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM blog_entry
				WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_categories() {
		global $db;
		$this->media = array();

		$sql = "SELECT * FROM blog_entry_category
				WHERE blog_entry_id = $this->id";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->categories[] = new Blog_Category($row[blog_category_id]);
	}

	function get_media() {
		global $db;
		$this->media = array();

		$sql = "SELECT * FROM blog_entry_media
				WHERE blog_entry_id = $this->id";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->media[] = new Media($row[media_id]);
	}

	function get_comments() {
		global $db;
		$this->comments = array();

		$sql = "SELECT * FROM blog_comment
				WHERE blog_entry_id = $this->id
				  AND comment_type = 'B'
				ORDER BY creation_date";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->comments[] = new Blog_Comment(0, $row);

	}

	function format_body() {
		$body = preg_replace('/href="(http:\/\/.*?)"/i', 'href="http://www.pinciuc.com/click.php?id='.$this->id.'|$1" target="_blank"', preg_replace('/&/', '&amp;', $this->body));
		$body = preg_replace('/href="\//i', 'href="http://www.pinciuc.com/', $body);
		$body = str_replace('’', '&#8217;', $body);
		$body = str_replace('“', '&#147;', $body);
		$body = str_replace('”', '&#148;', $body);
		$body = str_replace('‘', '&#145;', $body);
		$body = str_replace('–', '&#150;', $body);
		$body = str_replace('…', '&#133;', $body);
		return $body;
	}

	function update_clicks($url) {
		global $db;

		$sql = "SELECT * FROM blog_click
				WHERE blog_entry_id = $this->id
				AND url = '".DB::encode($url)."'";

		$db->query_exec($sql);

		if ($db->rc == 1) {
			$sql = "UPDATE blog_click
					SET clicks = clicks + 1
					WHERE blog_entry_id = $this->id
					AND url = '".DB::encode($url)."'";

			$db->query_exec($sql);
		}
		else {
			$sql = "INSERT INTO blog_click
					VALUES ($this->id, '".DB::encode($url)."', 1)";

			$db->query_exec($sql);
		}
	}

	function get_clicks($url = '') {
		global $db;
		$results = array();

		$sql = "SELECT url,clicks FROM blog_click
				WHERE blog_entry_id = $this->id ";
		if ($url)
			$sql .= "AND url = '".DB::encode($url)."' ";
		$sql .= "ORDER BY clicks DESC, url ";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$results[] = array($row[url], $row[clicks]);

		return $results;
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------

	function get_status_types($type = '') {
		$types = array('P' => 'Publish', 'D' => 'Draft');
		return ($type ? $types[$type] : $types);
	}
}
