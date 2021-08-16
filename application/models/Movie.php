<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: Movie
// ------------------------------------------------------------------------
// Represents a DVD movie
// ------------------------------------------------------------------------
class Movie {
	var $id;		// Numeric file ID
	var $folder;		// Filesystem path
	var $title;		// Song title
	var $year;		// Year

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Movie ($id = 0, $folder = '', $row = array()) {
		global $db;

		if ($id || $folder) {
			$sql = "SELECT *
				FROM moviefiles
				WHERE ";

			if ($id)
				$sql .= "id = $id ";
			else
				$sql .= "folder = '".DB::encode($folder)."' ";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->folder = $row[folder];
			$this->title = $row[title];
			$this->year = $row[year];
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO moviefiles
			VALUES (null,
			'".DB::encode($this->folder)."',
			'".DB::encode($this->title)."',
			".($this->year ? $this->year : 'null')."
			)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE moviefiles SET
			folder = '".DB::encode($this->folder)."',
			title = '".DB::encode($this->title)."',
			year = ".($this->year ? (integer)$this->year : 'null')."
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM moviefiles
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_movieinfo($folder = '') {
		$movieinfo = '';

                if (!$folder)
			$folder = $this->folder;

		$this->folder = $folder;

		if (file_exists($this->get_movieinfo_filename()))
			$movieinfo = simplexml_load_file($this->get_movieinfo_filename());

		return $movieinfo;
	}

	function cover_exists() {
		if (file_exists($this->get_cover_filename()) && filesize($this->get_cover_filename()))
			return true;
		else
			return false;
	}

	function stream_exists($quality = 'mid') {
		if (file_exists($this->get_stream_filename($quality)) && filesize($this->get_stream_filename($quality)))
			return true;
		else
			return false;
	}

	function get_cover_filename() {
		return $this->folder.'/folder.jpg';
	}

	function get_movieinfo_filename() {
		return $this->folder.'/mymovies.xml';
	}

	function get_stream_filename($quality = 'mid') {
		$dirname = substr(strrchr(preg_replace('/\/VIDEO_TS/', '', $this->folder), '/'), 1);
		$file = preg_replace('/\/VIDEO_TS/', '', $this->folder)."/$dirname-$quality.mp4";
		return $file;
	}
	function get_stream_url($quality = 'mid') {
		$dirname = substr(strrchr(preg_replace('/\/VIDEO_TS/', '', $this->folder), '/'), 1);
		$url = "rtsp://www.pinciuc.com/movies/$dirname/$dirname-$quality.mp4";
		return $url;
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------

	function get_movie_count() {
		global $db;

		$sql = "SELECT COUNT(*) as count FROM moviefiles";
		$db->query_exec($sql);

		if ($db->rc == 1)
			return $db->rs[0][count];
		else
			return 0;
	}

	function get_new_movies($limit = 0) {
		global $db;
		$results = array();

		$sql = "SELECT *
			FROM moviefiles
			ORDER BY id DESC ";

		$sql .= ($limit ? "LIMIT $limit " : '');

		$db->query_exec($sql);

		foreach ($db->rs as $row) {
			$movie = new Movie(0, 0, $row);
			$results[] = $movie;
		}

		return $results;
	}

	function get_stream_bitrates() {
		return array(32, 64, 96, 128, 160, 192);
	}

	function get_playlist_formats() {
		return array('M3U', 'PLS', 'B4U');
	}
}
