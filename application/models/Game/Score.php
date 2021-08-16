<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// class: Game_Score
// ------------------------------------------------------------------------
// Represents a game
// ------------------------------------------------------------------------
class Game_Score {
	var $id;		// Numeric score ID
	var $game_id;		// Game ID of the owner
	var $time;		// Timestamp of score
	var $score;		// The score
	var $nickname;		// Player nickname

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Game_Score ($id = 0, $row = array()) {
		global $db;

		if ($id) {
			$sql = "SELECT * FROM gamescores
				WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->game_id = $row[game_id];
			$this->time = $row[time];
			$this->score = $row[score];
			$this->nickname = $row[nickname];
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO gamescores
			VALUES (null,
			$this->game_id,
			null,
			$this->score,
			'".DB::encode($this->nickname)."'
			)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE gamescores SET
			game_id = $this->game_id,
			score = $this->score,
			nickname = '".DB::encode($this->nickname)."'
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM gamescores
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	// ------------------------------------------------
	// Static/Class functions
	// ------------------------------------------------
}
