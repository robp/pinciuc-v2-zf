<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: Blog_Comment
// ------------------------------------------------------------------------
// Represents a web log user comment
// ------------------------------------------------------------------------
class Blog_Comment {
	var $id;                // Numeric ID
	var $blog_entry_id;		// ID of the blog entry
	var $comment_type;		// Type of comment: blog, media, etc.
	var $creation_date;		// Creation date and time of the entry
	var $ip_address;		// Creation date and time of the entry
	var $name;				// Commentor's name
	var $email_address;		// Commentor's email
	var $url;				// Commentor's url
	var $comment;			// The comment

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Blog_Comment($id = 0, $row = array()) {
		global $db;

		if ($id) {
			$sql = "SELECT * FROM blog_comment
					WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->blog_entry_id = $row[blog_entry_id];
			$this->comment_type = $row[comment_type];
			$this->creation_date = $row[creation_date];
			$this->ip_address = htmlspecialchars($row[ip_address]);
			$this->name = htmlspecialchars($row[name]);
			$this->email_address = htmlspecialchars($row[email_address]);
			$this->url = htmlspecialchars($row[url]);
			$this->comment = htmlspecialchars($row[comment]);
		}
	}

	function insert($notify = true) {
		global $db;

		$entry = new Blog_Entry($this->blog_entry_id);

		if ($entry->allow_comments == 'N') {
			return 0;
		}

		$this->creation_date = date('Y-m-d H:i:s');

		$sql = "INSERT INTO blog_comment
				VALUES (null,
				$this->blog_entry_id,
				'$this->comment_type',
				'$this->creation_date',
				'$this->ip_address',
				'".DB::encode($this->name)."',
				'".DB::encode($this->email_address)."',
				'".DB::encode($this->url)."',
				'".DB::encode($this->comment)."'
				)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		if ($notify) {
			$subject = "New $this->comment_type comment!";
			$message = "$this->name ($this->email_address) left the following comment about ";

			if ($this->comment_type == 'M') {
				$media = new Media($this->blog_entry_id);
				$media->get_gallery_media();
				$gm = $media->gallery_media[0];
				$gallery = new Gallery($gm->gallery_id);
				$seq = $gallery->has_media($media->id);
				$message .= '"'.($gm->title ? $gm->title : 'Untitled').'" (http://www.pinciuc.com/photos/index.php?gallery_id='.$gallery->id.'&media_id='.$seq.') in "'.($gallery->title ? $gallery->title : 'Untitled').'" (http://www.pinciuc.com/photos/index.php?gallery_id='.$gallery->id.')';
			} elseif ($this->comment_type == 'B') {
				$blog_entry = new Blog_Entry($this->blog_entry_id);
				$blog = new Blog($blog_entry->blog_id);
				$message .= '"'.($blog_entry->title ? $blog_entry->title : 'Untitled').'" (http://www.pinciuc.com/entry.php?id='.$blog_entry->id.') in "'.($blog->title ? $blog->title : 'Untitled').'"';
			} elseif ($this->comment_type == 'G') {
				$gallery = new Gallery($this->blog_entry_id);
				$parent = new Gallery($gallery->parent_id);
				$message .= '"'.($gallery->title ? $gallery->title : 'Untitled').'" (http://www.pinciuc.com/photos/index.php?gallery_id='.$gallery->id.') in "'.($parent->title ? $parent->title : 'Untitled').'" (http://www.pinciuc.com/photos/index.php?gallery_id='.$parent->id.')';
			}

			$message .= ":\n\n$this->comment";
			mail('rob@pinciuc.com', $subject, $message);
		}

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE blog_comment SET
				blog_entry_id = $this->blog_entry_id,
				comment_type = '$this->comment_type',
				creation_date = '$this->creation_date',
				ip_address = '$this->ip_address',
				name = '".DB::encode($this->name)."',
				email_address= '".DB::encode($this->email_address)."',
				url = '".DB::encode($this->url)."',
				comment = '".DB::encode($this->comment)."'
				WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM blog_comment
				WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function format_body() {
		$body = preg_replace('/href="(http:\/\/.*?)"/i', 'href="$1" target="_blank"', $this->comment);
		return $body;
    }

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------

	function get_comments($options = array()) {
		global $db;

		$results = array();

		$sql = "SELECT *
				FROM blog_comment
				WHERE 1 = 1 ";

		if ($options['comment_type'])
			$sql .= "AND comment_type ".(is_array($options['comment_type']) ? "IN ('".join("','", $options['comment_type'])."') " : " = '".$options['comment_type']."' ");

		$sql .= "ORDER BY creation_date ".($options['sort'] == 'D' ? 'DESC' : 'ASC')."
				".($options['limit'] ? 'LIMIT '.$options['limit'] : '');

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$results[] = new Blog_Comment(0, $row);

		return $results;
	}
}
