<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// function: form_param(mixed &$var, mixed $default)
// ------------------------------------------------------------------------
// Used at the top of a php file, this function checks to see if a variable is
// set (such as, from a calling form), and if not, sets it to a default value.
// Returns 1 when the variable is set to the default by this function
// Returns 0 when variable was found to already have been set.
// ------------------------------------------------------------------------
function form_param(&$variable, $default = false) {
	if (!isset($variable)) {
		$variable = $default;
		return 1;
	}
	else
		return 0;
}

function force_https() {
	global $PHP_SELF;
	$query_string = getenv('QUERY_STRING');
	$server_name = getenv('SERVER_NAME') ? getenv('SERVER_NAME') : 'www.pinciuc.com';

	if (!getenv('HTTPS')) {
		header('Location: https://'.$server_name.$PHP_SELF.($query_string ? "?$query_string" : ''));
		exit();
	}
}

function force_http() {
	global $PHP_SELF;
	$query_string = getenv('QUERY_STRING');
	$server_name = getenv('SERVER_NAME') ? getenv('SERVER_NAME') : 'www.pinciuc.com';

	if (getenv('HTTPS')) {
		header('Location: http://'.$server_name.$PHP_SELF.($query_string ? "?$query_string" : ''));
		exit();
	}
}

function ip_location($ip) {
	global $db;
	$result = array();
	$t_result = array();

	$sql = "SELECT * FROM ip_location
			WHERE ip_address = '$ip'";

	$db->query_exec($sql);

	if ($db->rc == 1) {
		$row = $db->rs[0];
		$result['city'] = $row[city];
		$result['province'] = $row[province];
		$result['country'] = $row[country];
	}
	// if we didn't have a db hit, or if the db hit was more than 90 days old
	if (!$db->rc || strtotime($row[updated]) < (time() - (86400 * 90))) {
		$cmd = 'whois -h whois.arin.net + n '.$ip.' | egrep \'(City:|StateProv:|Country)\'';

		if ($fd = @popen($cmd, 'r')) {
			while (!feof($fd)) {
				$line = fgets($fd);
				list($key,$value) = split(':', $line);
				if ($key == 'City')
					$t_result['city'] = trim($value);
				elseif ($key == 'StateProv')
					$t_result['province'] = trim($value);
				elseif ($key == 'Country')
					$t_result['country'] = trim($value);
			}
			pclose($fd);

			if ($t_result['city'] || $t_result['province'] || $t_result['country']) {
				// delete the old
				$sql = "DELETE FROM ip_location
						WHERE ip_address = '$ip'";

				$db->query_exec($sql);

				// insert the new
				$sql = "INSERT INTO ip_location
						VALUES ('$ip',
						'".DB::encode($t_result['city'])."',
						'".DB::encode($t_result['province'])."',
						'".DB::encode($t_result['country'])."',
						null
						)";

				$db->query_exec($sql);

				$result = $t_result;
			}
		}
	}

	return $result;
}

function preview_text($text = '', $words = 20, $strip = true, $elipsis = true) {
	$text = ($strip ? strip_tags($text) : $text);
	$arr1 = split(' ', $text);
	$arr2 = array_slice($arr1, 0, ($words-1));
	return join(' ', $arr2).($elipsis && (count($arr2) < count($arr1)) ? '...' : '');
}

function ISO8601_date($timestamp) {
	return date('Y-m-d\TH:i:s', $timestamp).substr_replace(date('O', strtotime($entry->creation_date)), ':', 3, 0);
}
