<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

require_once('MP3.php');

// ------------------------------------------------------------------------
// class: Playlist
// ------------------------------------------------------------------------
// Represents a media gallery
// ------------------------------------------------------------------------
class Playlist {
	var $id;		// Numeric ID
	var $name;		// A user-submitted name

	var $media;	 	// Array of media

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Playlist ($id = 0, $row = array()) {
		global $db;

		if ($id) {
			$sql = "SELECT * FROM playlist
				WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->name = $row[name];
			$this->get_media();
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO playlist
			VALUES (null,
			'".DB::encode($this->name)."'
			)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		foreach ($this->media as $media) {
			$this->insert_media($media);
		}

		return $db->rc;
	}

	function update($force = false) {
		global $db;

		$sql = "UPDATE playlist SET
			name = '".DB::encode($this->name)."'
			WHERE id = $this->id";

		$db->query_exec($sql);
		
		$sql = "DELETE FROM playlist_media
			WHERE playlist_id = $this->id";
			
		$db->query_exec($sql);
		
		foreach ($this->media as $media) {
			$this->insert_media($media);
		}

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM playlist_media
			WHERE playlist_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM playlist
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_media() {
		global $db;

		$this->media = array();

		if ($this->media_query) {
			$sql = $this->media_query;
		}
		else {
			$sql = "SELECT media_id
				FROM playlist_media
				WHERE playlist_id = $this->id
				ORDER BY sequence, media_id ";
		}

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->media[] = new MP3($row[media_id]);
	}
}
