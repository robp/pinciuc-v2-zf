<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

require_once('GameScore.php');

// ------------------------------------------------------------------------
// class: Game
// ------------------------------------------------------------------------
// Represents a game
// ------------------------------------------------------------------------
class Game {
	var $id;		// Numeric game ID
	var $user_id;		// User ID of the owner
	var $name;		// Keyword name
	var $description;	// A user-submitted description
	var $plays;		// How many times played

	var $scores;

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Game ($id = 0, $name = '', $row = array()) {
		global $db;
		$this->scores = array();

		if ($id || $name) {
			$sql = "SELECT * FROM games
				WHERE ";

			if ($id)
				$sql .= "id = $id";
			else
				$sql .= "name = '".DB::encode($name)."'";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->user_id = $row[user_id];
			$this->name = $row[name];
			$this->description = $row[description];
			$this->plays = $row[plays];
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO games
			VALUES (null,
			$this->user_id,
			'".DB::encode($this->name)."',
			'".DB::encode($this->description)."'
			)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE games SET
			user_id = $this->user_id,
			name = '".DB::encode($this->name)."',
			description = '".DB::encode($this->description)."'
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM gamescores
			WHERE game_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM games
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_scores($limit = 0) {
		global $db;
		$this->scores = array();

		$sql = "SELECT * FROM gamescores
			WHERE game_id = $this->id
			ORDER BY score DESC, time DESC ";

		if ($limit)
			$sql .= "LIMIT $limit ";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->scores[] = new GameScore(0, $row);
	}

	function print_scores($limit = 0) {
		global $db;
		$this->get_scores($limit);

		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="iso-8859-1" standalone="yes" ?>'."\n";
		echo "<highscores>\n";
		for ($rank = 1; $rank <= count($this->scores); $rank++) {
			$score = $this->scores[$rank-1];
			echo "  <score rank=\"$rank\">\n";
			echo "    <playerscore>$score->score</playerscore>\n";
			echo "    <playernickname>$score->nickname</playernickname>\n";
			echo "  </score>\n";
		}
		echo "</highscores>\n";
	}

	function add_score($score, $nickname = '') {
		global $db;

		$gamescore = new GameScore();
		$gamescore->game_id = $this->id;
		$gamescore->score = $score;
		$gamescore->nickname = $nickname;
		$gamescore->insert();
	}

	function increment_plays() {
		global $db;

		$sql = "UPDATE games
			SET plays = plays + 1
			WHERE game_id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------
}
