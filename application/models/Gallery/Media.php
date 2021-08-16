<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

require_once('Media.php');
require_once('Blog/Comment.php');

// ------------------------------------------------------------------------
// class: Gallery_Media
// ------------------------------------------------------------------------
// Represents a media item in a Gallery
// ------------------------------------------------------------------------
class Gallery_Media extends Media {
	var $gallery_id;	// Numeric user ID
	var $media_id;

	var $title;		// A user-submitted title
	var $description;	// A user-submitted description

	var $sequence;
	var $allow_comments;	// allow comments?

	var $gallery;
	var $media;

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Gallery_Media ($gallery_id = 0, $media_id = 0, $row = array()) {
		global $db;
		$this->sequence = 0;
		$this->allow_comments = 'O';

		if ($gallery_id && $media_id) {
			$sql = "SELECT * FROM gallery_media
				WHERE gallery_id = $gallery_id
				AND media_id = $media_id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->gallery_id = $row[gallery_id];
			$this->media_id = $row[media_id];
			$this->title = $row[title];
			$this->description = $row[description];
			$this->sequence = $row[sequence];
			$this->allow_comments = $row[allow_comments];
		}
		else {
			$this->gallery_id = $gallery_id;
			$this->media_id = $media_id;
		}
		$this->media = new Media($this->media_id);
		$this->gallery = new Gallery($this->gallery_id);
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO gallery_media
			VALUES ($this->gallery_id,
			$this->sequence,
			'$this->allow_comments',
			'".DB::encode($this->title)."',
			'".DB::encode($this->description)."',
			$this->media_id
			)";

		$db->query_exec($sql);

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE gallery_media SET
			gallery_id = $this->gallery_id,
			media_id = $this->media_id,
			title = '".DB::encode($this->title)."',
			description = '".DB::encode($this->description)."',
			sequence = $this->sequence,
			allow_comments = '$this->allow_comments'
			WHERE gallery_id = $this->gallery_id
			AND media_id = $this->media_id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM gallery_media
			WHERE media_id = $this->media_id
			AND gallery_id = $this->gallery_id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_views() {
		$sql = "SELECT count(*) AS views
				FROM gallery_media_views
				WHERE gallery_id = $this->gallery_id
				AND media_id = $this->media_id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];

			return $row[views];
	}

	function increment_views() {
		global $db;

		if (!$this->gallery->id) {
			$this->gallery = new Gallery($this->gallery_id);
		}

		$parent_gallery = new Gallery($this->gallery->parent_id);

		// return false if this is a sub gallery
		//  of the "Popular" gallery
		if ($parent_gallery->title == 'Popular' || $gallery->title == 'Recent')
			return false;

		$remote_addr = getenv('REMOTE_ADDR');

		if ($remote_addr) {
			$sql = "SELECT view_time
					FROM gallery_media_views
					WHERE gallery_id = $this->gallery_id
					  AND media_id = $this->media_id
					  AND remote_host = '$remote_addr'
					  AND view_time > CURDATE() - INTERVAL 10 MINUTE
					ORDER BY view_time DESC
					LIMIT 1";

			$db->query_exec($sql);

			if ($db->rc == 0) {
				$sql = "INSERT INTO gallery_media_views
						VALUES ($this->gallery_id, $this->media_id, '$remote_addr', '".date('Y-m-d H:i:s')."')";

				$db->query_exec($sql);

				return $db->rc;
			}
		}

		return false;
	}
}
