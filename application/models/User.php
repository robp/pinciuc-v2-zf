<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: User
// ------------------------------------------------------------------------
// Represents a site user
// ------------------------------------------------------------------------
class User {
	var $id;		// Numeric user ID
	var $username;		// Username for logging in
	var $password;		// Password for logging in (encrypted)
	var $userinfo;		// Array to store additional user information
	var $priveleges;	// Array to store access privilege flags

	var $media;		// Array to store media references
	var $galleries;		// Array to store gallery references
	var $blogs;		// Array to store blog references
	var $playlists;		// Array to store playlist references

	// --------------------------------------------------------------------
	// Constructor connects to the database using defaults, or
	// supplied credentials
	// --------------------------------------------------------------------
	function User ($id = 0, $username = '', $row = array()) {
		global $db;

		$this->userinfo		= array();
		$this->privileges	= array();
		$this->media		= array();
		$this->galleries	= array();
		$this->blogs		= array();
		$this->playlists	= array();


		if ($id || $username) {
			$sql = "SELECT * FROM user
				WHERE ";

			if ($id)
				$sql .= "id = $id";
			else
				$sql .= "username = '".DB::encode($username)."'";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->username = $row[username];
			$this->password = $row[password];
			$this->get_userinfo();
			$this->get_privileges();
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO user(username, password)
			VALUES (
			'".DB::encode($this->username)."',
			'".DB::encode($this->password)."'
			)";

		$db->query_exec($sql);

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE user SET
			username = '".DB::encode($this->username)."',
			password = '".DB::encode($this->password)."'
			WHERE id = $this->id";

		$db->query_exec($sql);

		if (count($this->userinfo)) {
			$sql = "DELETE FROM userinfo
				WHERE id = $this->id";

			$db->query_exec($sql);

			foreach ($this->userinfo as $label => $value) {
				$sql = "INSERT INTO userinfo
					VALUES (
					$this->id,
					'".DB::encode($label)."',
					'".DB::encode($value)."'
					)";

				$db->query_exec($sql);
			}
		}

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM userinfo
			WHERE id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM user
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function authenticate($password) {
		if ($this->password == crypt($password, $this->password))
			return true;
		else
			return false;
	}

	function get_userinfo() {
		global $db;

		$sql = "SELECT * FROM userinfo
			WHERE id = $this->id";

		$db->query_exec($sql);

		foreach ($db->rs as $row) {
			$this->userinfo[$row[label]] = $row[value];
		}
	}

	function get_privileges() {
		global $db;

		$sql = "SELECT * FROM userprivilege
			WHERE id = $this->id";

		$db->query_exec($sql);

		foreach ($db->rs as $row) {
			$this->privileges[$row[label]] = $row[value];
		}
	}

	function is_privileged($privilege, $url = '') {
		if ($this->privileges[$privilege] == 'Y')
			return true;
		elseif ($url) {
			header("Location: $url");
			exit();
		}
		else
			return false;
	}

	function get_media($options = array()) {
		global $db;

		$this->media = array();

		$sql = "SELECT * FROM media
			WHERE user_id = $this->id ";

		if ($options['order'])
			$sql .= 'ORDER BY id '.$options['order'];

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->media[] = new Media(0, $row);
	}

	function get_galleries($options = array()) {
		global $db;

		$this->galleries = array();

		$sql = "SELECT * FROM gallery
			WHERE user_id = $this->id ";

		if ($options['status'] == 'private')
			$sql .= "AND status = 'X' ";
		elseif ($options['status'] == 'public')
			$sql .= "AND status = 'A' ";

		if ($options['order'])
			$sql .= 'ORDER BY gallery_date '.$options['order'].', id '.$options['order'];

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->galleries[] = new Gallery(0, $row);
	}

	function get_blogs($options = array()) {
		global $db;

		$this->blogs = array();

		$sql = "SELECT * FROM blog
			WHERE user_id = $this->id
			ORDER BY id";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->blogs[] = new Blog(0, $row);
	}

	function get_playlists($options = array()) {
		global $db;

		$this->playlists = array();

		$sql = "SELECT playlist_id FROM user_playlist
			WHERE user_id = $this->id
			ORDER BY playlist_id";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->playlists[] = new Playlist($row[playlist_id]);
	}


	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------

	// check if logged in, based on session auth_id
	// if not logged in, redirect to supplied $url or return false
	function is_logged_in($url = '') {
		$user = new User($_SESSION['auth_id']);
		if ($user->id)
			return $user;
		elseif ($url) {
			header("Location: $url");
			exit();
		}
		else
			return false;
	}

	// check if a username exists
	function exists($username) {
		$user = new User(0, $username);
		if ($user->id)
			return true;
		else
			return false;
	}

	// encode a password
	function encode_password($password) {
		return crypt($password);
	}

	// check if a string is a valid username
	function valid_username($username) {
		if (eregi('^[a-z0-9]{2,16}$', $username))
			return true;
		else
			return false;
	}

	// check if a string is a valid password
	function valid_password($password) {
		if (strlen($password) >= 6 && eregi("[^a-z]", $password))
			return true;
		else
			return false;
	}
}
