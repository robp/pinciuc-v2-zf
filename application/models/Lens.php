<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

require_once('Media.php');

// ------------------------------------------------------------------------
// class: Media
// ------------------------------------------------------------------------
// Represents an uploaded media file
// ------------------------------------------------------------------------
class Lens {
	var $id;			// Numeric user ID
	var $name;			// User ID of the owner
	var $prime;			// Is this a prime lens?

	var $gallery_media;	// Array of media shot with this lens

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Lens ($id = 0, $row = array()) {
		global $db;
		$this->gallery_media = array();

		if ($id) {
			$sql = "SELECT * FROM lens
				WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->name = $row[name];
			$this->prime = $row[prime];
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO lens
			VALUES (null,
			'".DB::encode($this->name)."',
			".$this->prime."
			)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE lens SET
			name = '".DB::encode($this->name)."',
			prime = ".$this->prime."
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM media_lens
			WHERE lens_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM lens
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_gallery_media($options = array()) {
		global $db;

		$sql = "SELECT gm.*
				FROM media_lens ml, gallery_media gm, media m
				WHERE ml.lens_id = $this->id
				  AND ml.media_id = gm.media_id
				  AND gm.media_id = m.media_id ";
		$sql .= ($options['status'] == 'all' ? '' : ($options['status'] == 'private' ? "AND m.status = 'X' " : "AND m.status = 'A' "));
		$sql .= "ORDER BY gm.gallery_id, gm.sequence_id ";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->gallery_media[] = new GalleryMedia(0, 0, $row);
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------

	function get_lenses() {
		global $db;
		$result = array();

		$sql = "SELECT * FROM lens
				ORDER BY name";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$result[] = new Lens(0, $row);

		return $result;
	}
}
