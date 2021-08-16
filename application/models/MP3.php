<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: MP3
// ------------------------------------------------------------------------
// Represents an MP3 media file
// ------------------------------------------------------------------------
class MP3 {
	var $id;		// Numeric file ID
	var $file;		// Filesystem path
	var $filesize;	// File size
	var $artist;	// Artist name
	var $album;		// Album title
	var $title;		// Song title
	var $track;		// Track number
	var $length;	// Length/Time
	var $year;		// Year
	var $genre_id;		// ID3 Genre
	var $bitrate;	// Bitrate in Kbps
	var $frequency;	// Frequency in Hz
	var $mode;		// Audio mode (ie., stereo, mono, etc)

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function MP3 ($id = 0, $file = '', $row = array()) {
		global $db;

		if ($id || $file) {
			$sql = "SELECT mf.*, mg.name AS genre
				FROM mp3files mf LEFT JOIN mp3genres mg ON mf.genre_id=mg.id
				WHERE ";

			if ($id)
				$sql .= "mf.id = $id ";
			else
				$sql .= "mf.file = '".DB::encode($file)."' ";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->file = $row[file];
			$this->filesize = $row[filesize];
			$this->artist = $row[artist];
			$this->album = $row[album];
			$this->title = $row[title];
			$this->track = $row[track];
			$this->length = $row[length];
			$this->year = $row[year];
			$this->genre_id = $row[genre_id];
			$this->genre = $row[genre];
			$this->bitrate = ($row[bitrate] == -1 ? 'Variable' : $row[bitrate]);
			$this->frequency = $row[frequency];
			$this->mode = $row[mode];
			$this->composer = $row[composer];
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO mp3files
			VALUES (null,
			'".DB::encode($this->file)."',
			'".DB::encode($this->filesize)."',
			'".DB::encode($this->artist)."',
			'".DB::encode($this->album)."',
			".($this->disc ? $this->disc : 'null').",
			'".DB::encode($this->title)."',
			".($this->track ? $this->track : 'null').",
			".($this->length ? $this->length : 'null').",
			".($this->year ? $this->year : 'null').",
			".($this->genre_id ? $this->genre_id : 'null').",
			".($this->bitrate ? $this->bitrate : 'null').",
			".($this->frequency ? $this->frequency : 'null').",
			'".DB::encode($this->mode)."',
			'".DB::encode($this->composer)."'
			)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE mp3files SET
			file = '".DB::encode($this->file)."',
			filesize = ".($this->filesize ? $this->filesize : 'null').",
			artist = '".DB::encode($this->artist)."',
			album = '".DB::encode($this->album)."',
			disc = ".($this->disc ? (integer)$this->disc : 'null').",
			title = '".DB::encode($this->title)."',
			track = ".($this->track ? (integer)$this->track : 'null').",
			length = ".($this->length ? $this->length : 'null').",
			year = ".($this->year ? (integer)$this->year : 'null').",
			genre_id = ".($this->genre_id ? $this->genre_id : 'null').",
			bitrate = ".($this->bitrate ? ($this->bitrate == 'Variable' ? '-1' : $this->bitrate) : 'null').",
			frequency = ".($this->frequency ? $this->frequency : 'null').",
			mode = '".DB::encode($this->mode)."',
			composer = '".DB::encode($this->composer)."'
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM mp3files
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_mp3info($file = '') {
		require_once('getid3/getid3.php');
		$mp3info = array();

		if (!$file)
			$file = $this->file;

		$this->file = $file;
		$this->filesize = filesize($this->file);

		if (eregi('.m4a$', $file)) {
			$cmd = '/usr/local/bin/alacinfo '.escapeshellarg($file);

			$fp = popen($cmd, 'r');

			while ($line = fgets($fp))
				$alacinfo[] = str_replace("\n", "", $line);

			$this->artist = $alacinfo[1];
			$this->album = $alacinfo[2];
			$this->title = $alacinfo[3];
			$this->track = $alacinfo[4];
			$this->length = $alacinfo[5];
			$this->year = $alacinfo[6];
			$this->genre_id = $lacinfo[7];
			$this->bitrate = $alacinfo[8];
			$this->frequency = $alacinfo[9];
			$this->composer = $alacinfo[12];
		}
		elseif (eregi('.mp3$', $file)) {
			$getID3 = new getID3;
			$fileinfo = $getID3->analyze($file);
			getid3_lib::CopyTagsToComments($fileinfo);

			$this->artist = ($fileinfo['comments']['band'][0] ? $fileinfo['comments']['band'][0] : $fileinfo['comments']['artist'][0]);
			$this->album = $fileinfo['comments']['album'][0];
			$this->disc = ($fileinfo['id3v2']['TPA'][0]['data'] ? substr($fileinfo['id3v2']['TPA'][0]['data'], 0, 1) : '');
			$this->title = $fileinfo['comments']['title'][0];
			$this->track = ($fileinfo['comments']['tracknum'][0] ? $fileinfo['comments']['tracknum'][0] : $fileinfo['comments']['track'][0]);
			$this->length = round($fileinfo['playtime_seconds']);
			$this->year = $fileinfo['comments']['year'][0];
			$this->composer = $fileinfo['comments']['composer'][0];
			$this->genre_id = ereg_replace('(\(|\))', '', @$fileinfo['id3v2']['TCO'][0]['data']);
			if (!ereg('^[0-9]*$', $this->genre_id))
				$this->genre_id = 0;
			$this->bitrate = $fileinfo['audio']['bitrate'] / 1000;
			$this->frequency = $fileinfo['audio']['sample_rate'];
			$this->mode = ucwords($fileinfo['audio']['channelmode']);
		}
	}

	function cover_exists() {
		if (file_exists($this->get_cover_filename()) && filesize($this->get_cover_filename()))
			return true;
		else
			return false;
	}

	function get_cover_filename() {
		return dirname($this->file).'/folder.jpg';
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------

	function search($keywords = '', $artist = '', $album = '', $title = '') {
		global $db;
		$results = array();

		if ($keywords || $artist || $album || $title) {
			$sql = 'SELECT * FROM mp3files
					WHERE ';

			if ($keywords) {
				$ka = split('[ ,]', strToUpper($keywords));

				$sql .= "file LIKE '%" . join("%' AND UPPER(CONCAT(file,' ',artist,' ',album,' ',title)) LIKE '%", str_replace("'", "''", $ka)) . "%'";
			}
			else {
				$sql .= '1 = 1 ';

				if ($artist)
					$sql .= "AND UPPER(artist) LIKE '".str_replace("'", "''", $artist)."%' ";
				if ($album)
					$sql .= "AND UPPER(album) LIKE '".str_replace("'", "''", $album)."%' ";
				if ($title)
					$sql .= "AND UPPER(title) LIKE '".str_replace("'", "''", $title)."%' ";

			}

			$sql .= 'ORDER BY artist,album,track,title,file';
			$db->query_exec($sql);

			$results = $db->rs;
		}

		return $results;
	}

	function get_track_count() {
		global $db;

		$sql = "SELECT COUNT(DISTINCT title) as count FROM mp3files";
		$db->query_exec($sql);

		if ($db->rc == 1)
			return $db->rs[0][count];
		else
			return 0;
	}

	function get_album_count() {
		global $db;

		$sql = "SELECT COUNT(DISTINCT album) as count FROM mp3files";
		$db->query_exec($sql);

		if ($db->rc == 1)
			return $db->rs[0][count];
		else
			return 0;
	}

	function get_artist_count() {
		global $db;

		$sql = "SELECT COUNT(DISTINCT artist) as count FROM mp3files";
		$db->query_exec($sql);

		if ($db->rc == 1)
			return $db->rs[0][count];
		else
			return 0;
	}

	function get_total_size() {
		global $db;

		$sql = "SELECT SUM(filesize) filesize FROM mp3files";
		$db->query_exec($sql);

		if ($db->rc == 1)
			return $db->rs[0][filesize];
		else
			return 0;
	}

	function add_spin() {
		global $db;
		global $user;

		$sql = "INSERT INTO mp3_spins VALUES (
				$this->id,
				$user->id,
				'".date('Y-m-d H:i:s')."')";

		$db->query_exec($sql);
	}

	function get_popular_tracks($limit = 0) {
		global $db;
		$results = array();

		$sql = "SELECT mf.*, COUNT(*) AS spins
			FROM mp3_spins AS ms, mp3files AS mf
			WHERE ms.mp3_id = mf.id
			AND mf.album NOT IN ('')
			AND mf.album IS NOT NULL
			GROUP BY mp3_id
			ORDER BY spins DESC ";

		$sql .= ($limit ? "LIMIT $limit " : '');

		$db->query_exec($sql);

		foreach ($db->rs as $row) {
			$mp3 = new MP3(0, 0, $row);
			$results[] = array($mp3, $row[spins]);
		}

		return $results;
	}

	function get_recent_albums($limit = 0) {
		global $db;
		$results = array();

		$sql = "SELECT mf.*, MAX(ms.spin_time) AS spin_time, mf.artist, mf.album
			FROM mp3_spins AS ms, mp3files AS mf
			WHERE ms.mp3_id = mf.id
			AND mf.album NOT IN ('')
			AND mf.album IS NOT NULL
			GROUP BY mf.artist,mf.album
			ORDER BY spin_time DESC ";

		$sql .= ($limit ? "LIMIT $limit " : '');

		$db->query_exec($sql);

		foreach ($db->rs as $row) {
			$mp3 = new MP3(0, 0, $row);
			$results[] = $mp3;
		}

		return $results;
	}

	function get_recent_tracks($limit = 0) {
		global $db;
		$results = array();

		$sql = "SELECT mf.*, ms.spin_time
			FROM mp3_spins AS ms, mp3files as mf
			WHERE ms.mp3_id = mf.id
			AND mf.album NOT IN ('')
			AND mf.album IS NOT NULL
			ORDER BY ms.spin_time DESC ";

		$sql .= ($limit ? "LIMIT $limit " : '');

		$db->query_exec($sql);

		foreach ($db->rs as $row) {
			$mp3 = new MP3(0, 0, $row);
			$results[] = $mp3;
		}

		return $results;
	}

	function get_new_albums($limit = 0) {
		global $db;
		$results = array();

		$sql = "SELECT *
			FROM mp3files
			WHERE album NOT IN ('')
			AND album IS NOT NULL
			GROUP BY artist, album
			ORDER BY id DESC ";

		$sql .= ($limit ? "LIMIT $limit " : '');

		$db->query_exec($sql);

		foreach ($db->rs as $row) {
			$mp3 = new MP3(0, 0, $row);
			$results[] = $mp3;
		}

		return $results;
	}

	function get_amg_minibio($artist) {
		global $db;
		$bio = '';

		$sql = "SELECT *
			FROM artist_bio
			WHERE artist = '".str_replace("'", "''", $artist)."'";

		$db->query_exec($sql);

		if ($db->rc == 1) {
			$row = $db->rs[0];
			$bio = $row[bio];
		}
		else {
			require_once("HTTP/Request.php");

			$req =& new HTTP_Request("http://www.allmusic.com/cg/amg.dll");
			$req->setMethod(HTTP_REQUEST_METHOD_POST);
			$req->addPostData("P", "amg");
			$req->addPostData("sql", $artist);
			$req->addPostData("opt1", "1");
			if (!PEAR::isError($req->sendRequest())) {
				 $response1 = $req->getResponseBody();
			} else {
				 $response1 = "";
			}

			if (strlen(trim($response1))) {
				$r1 = explode('<div id="artistminibio">', $response1);
				$r2 = explode('</div>', $r1[1], 2);
				$r3 = explode('<p>', $r2[0], 2);
				$r4 = explode('</p>', $r3[1], 2);
				$bio = trim(preg_replace('/href="/', 'href="http://www.allmusic.com', $r4[0]));

				//if (strlen($bio)) {
					$sql = "INSERT INTO artist_bio VALUES (
							'".str_replace("'", "''", $artist)."',
							'".date('Y-m-d H:i:s')."',
							'".str_replace("'", "''", $bio)."')";

					$db->query_exec($sql);
				//}
			}
		}

		$bio = preg_replace('/&amp;"/', '&', $bio);
		$bio = preg_replace('/&/', '&amp;', $bio);
		return $bio;
	}

	function get_stream_bitrates() {
		return array(32, 64, 96, 128, 160, 192);
	}
	function get_playlist_formats() {
		return array('M3U', 'PLS', 'B4U');
	}
}
