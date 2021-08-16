<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

require_once('Media.php');
require_once('Gallery/Media.php');

// ------------------------------------------------------------------------
// class: Gallery
// ------------------------------------------------------------------------
// Represents a media gallery
// ------------------------------------------------------------------------
class Gallery {
	var $id;			// Numeric user ID
	var $parent_id;		// ID of parent gallery
	var $user_id;		// User ID of the owner
	var $title;			// A user-submitted title
	var $description;	// A user-submitted description
	var $thumb_media_id;	// media_id of thumbnail
	var $gallery_date;	// A user-submitted date
	var $media_query;	// SQL override to select media for gallery
	var $sort_order;
	var $status;		// Status code
	var $allow_comments;	// allow comments?

	var $galleries; 	// Array of sub galleries
	var $media;			// Array to store associated media
	var $thumb_media;	// thumbnail media
	var $comments;		// Gallery comments

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Gallery ($id = 0, $row = array()) {
		global $db;

		if ($id) {
			$sql = "SELECT * FROM gallery
				WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->parent_id = $row[parent_id];
			$this->user_id = $row[user_id];
			$this->sequence = $row[sequence];
			$this->title = $row[title];
			$this->description = $row[description];
			$this->thumb_media_id = $row[thumb_media_id];
			$this->gallery_date = $row[gallery_date];
			$this->media_query = $row[media_query];
			$this->sort_order = $row[sort_order];
			$this->allow_comments = $row[allow_comments];
			$this->display_map = $row[display_map];
			$this->status = $row[status];
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO gallery
			VALUES (null,
			$this->parent_id,
			$this->user_id,
			".($this->sequence ? $this->sequence : 'null').",
			'".DB::encode($this->title)."',
			'".DB::encode($this->description)."',
			".($this->thumb_media_id ? $this->thumb_media_id : 'null').",
			'$this->gallery_date',
			'".DB::encode($this->media_query)."',
			'$this->sort_order',
			'$this->allow_comments',
			".($this->display_map ? $this->display_map : '0').",
			'$this->status'
			)";

		//echo "$sql";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update($force = false) {
		global $db;

		$sql = "UPDATE gallery SET
			parent_id = $this->parent_id,
			user_id = $this->user_id,
			sequence = ".($this->sequence ? $this->sequence : 'null').",
			title = '".DB::encode($this->title)."',
			description = '".DB::encode($this->description)."',
			thumb_media_id = ".($this->thumb_media_id ? $this->thumb_media_id : 'null').",
			gallery_date = '$this->gallery_date',
			media_query = '".DB::encode($this->media_query)."',
			sort_order = '$this->sort_order',
			allow_comments = '$this->allow_comments',
			display_map = ".($this->display_map ? $this->display_map : 'null').",
			status = '$this->status'
			WHERE id = $this->id";

		$db->query_exec($sql);

		if (count($this->media) || $force) {
			$new_media_ids = array();
			$old_media_ids = array();

			$new_gmedia = $this->media;
			foreach ($new_gmedia as $gmedia)
				$new_media_ids[] = $gmedia->media->id;

			$this->get_media(array('status' => 'all', 'noquery' => 1));

			$old_gmedia = $this->media;
			foreach ($old_gmedia as $gmedia)
				$old_media_ids[] = $gmedia->media->id;

			foreach ($old_gmedia as $gmedia) {
				if (!in_array($gmedia->media->id, $new_media_ids)) {
					$gmedia->delete();
				}
			}

			for ($x = 0; $x < count($new_gmedia); $x++) {
				$gmedia = $new_gmedia[$x];
				$gmedia->sequence = $x+1;
				if (in_array($gmedia->media->id, $old_media_ids)) {
					$gmedia->update();
				}
				else {
					$gmedia->insert();
				}
			}

			$this->media = $new_media;
		}

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM gallery_comment
			WHERE gallery_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM gallery_media
			WHERE gallery_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM gallery
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_media($options = array()) {
		global $db;

		$this->media = array();

		if ($this->media_query && !$options['noquery']) {
			$sql = $this->media_query;
		}
		else {
			$sql = "SELECT gm.*
					FROM gallery_media AS gm, media AS m
					WHERE gm.gallery_id = $this->id
					AND gm.media_id = m.id ";
			$sql .= ($options['status'] == 'all' ? '' : ($options['status'] == 'private' ? "AND m.status = 'X' " : "AND m.status = 'A' "));
			$sql .= "ORDER BY gm.sequence, gm.media_id ";

			if ($options['order'])
				$sql .= $options['order'];

		}

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->media[] = new Gallery_Media(0, 0, $row);
	}

	function has_media($id, $options = array()) {
		global $db;

		if ($this->media_query) {
			$sql = $this->media_query;
		}
		else {
			$sql = "SELECT gm.*
					FROM gallery_media AS gm, media AS m
					WHERE gm.gallery_id = $this->id
					AND gm.media_id = m.id ";
			$sql .= ($options['status'] == 'all' ? '' : ($options['status'] == 'private' ? "AND m.status = 'X' " : "AND m.status = 'A' "));
			$sql .= "ORDER BY sequence ";
		}

		$db->query_exec($sql);

		for ($x = 0; $x < count($db->rs); $x++) {
			$row = $db->rs[$x];
			//echo $row[title]."<br>";
			if ($row[media_id] == $id)
				return $x + 1;
		}

		return false;

	}

	function get_thumb() {
		global $db;

		if ($this->thumb_media_id) {
			$sql = "SELECT *
				FROM media
				WHERE id = $this->thumb_media_id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$this->thumb_media = new Media(0, $db->rs[0]);
		}
		else {
			if (!$this->media)
				$this->get_media();

			if ($this->media)
				$this->thumb_media = $this->media[0]->media;
			else {
				if (!$this->galleries)
					$this->get_galleries();

				foreach ($this->galleries as $gallery) {
					$gallery->get_thumb();
					if ($gallery->thumb_media) {
						$this->thumb_media = $gallery->thumb_media;
						break;
					}
				}
			}
		}
	}

	function get_galleries($options = array()) {
		global $db;

		$this->galleries = array();

		$sql = "SELECT * FROM gallery
				WHERE parent_id = $this->id ";

		if ($options['status'] == 'private')
			$sql .= "AND status = 'X' ";
		elseif ($options['status'] == 'public')
			$sql .= "AND status = 'A' ";

		if ($options['order'])
			$sql .= 'ORDER BY sequence ASC, gallery_date '.$options['order'].', id '.$options['order'];

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->galleries[] = new Gallery(0, $row);
	}

	function get_comments() {
		global $db;
		$this->comments = array();

		$sql = "SELECT * FROM blog_comment
				WHERE blog_entry_id = $this->id
				  AND comment_type = 'G'
				ORDER BY creation_date";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->comments[] = new Blog_Comment(0, $row);
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------

	function get_recent_galleries($limit = 0) {
		global $db;

		$results = array();

		$sql = "SELECT g.*
				FROM gallery AS g, gallery_media AS gm
				WHERE g.id = gm.gallery_id
				AND g.status = 'A'
				GROUP BY g.id
				ORDER BY g.id DESC ";

		if ($limit)
			$sql .= "LIMIT $limit";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$results[] = new Gallery(0, $row);

		return $results;
	}

	function get_parents() {
		$results = array();
		$parent = new Gallery($this->parent_id);
		$results[] = $parent;
		if ($parent->parent_id)
			return array_merge($results, $parent->get_parents());
		else
			return $results;
	}
}
