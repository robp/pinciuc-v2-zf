<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------

require_once('Blog/Comment.php');
require_once('Lens.php');

// ------------------------------------------------------------------------
// class: Media
// ------------------------------------------------------------------------
// Represents an uploaded media file
// ------------------------------------------------------------------------
class Media {
	var $id;			// Numeric user ID
	var $user_id;		// User ID of the owner
	var $file;			// Local filesystem path
	var $mime_type;		// MIME type of the file
	var $title;			// A user-submitted title
	var $description;	// A user-submitted description
	var $status;		// Status code
	var $allow_comments;	// allow comments?

	var $latitude;		// GPS
	var $longitude;		// Coordinates


	var $width;
	var $height;
	var $channels;
	var $bits;
	var $mime;

	var $lens;
	var $views;
	var $comments;
	var $exif;
	var $galleries;
	var $gallery_media;

	// --------------------------------------------------------------------
	// Constructor
	// --------------------------------------------------------------------
	function Media ($id = 0, $row = array()) {
		global $db;
		$this->comments = array();
		$this->exif = array();
		$this->galleries = array();
		$this->gallery_media = array();

		if ($id) {
			$sql = "SELECT * FROM media
				WHERE id = $id";

			$db->query_exec($sql);

			if ($db->rc == 1)
				$row = $db->rs[0];
		}
		if ($row) {
			$this->id = $row[id];
			$this->user_id = $row[user_id];
			$this->file = $row[file];
			$this->mime_type = $row[mime_type];
			$this->title = $row[title];
			$this->description = $row[description];
			$this->status = $row[status];
			$this->allow_comments = $row[allow_comments];

			$this->latitude = $row[latitude];
			$this->longitude = $row[longitude];
			
			$this->get_fileinfo();
			$this->get_lens();
		}
	}

	function insert() {
		global $db;

		$sql = "INSERT INTO media
			VALUES (NULL,
			$this->user_id,
			'".DB::encode($this->file)."',
			'".DB::encode($this->mime_type)."',
			'".DB::encode($this->title)."',
			'".DB::encode($this->description)."',
			'$this->status',
			".($this->latitude != '' ? $this->latitude : 'NULL').", 
			".($this->longitude != '' ? $this->longitude : 'NULL')."
			)";

		$db->query_exec($sql);

		$this->id = $db->get_insert_id();

		return $db->rc;
	}

	function update() {
		global $db;

		$sql = "UPDATE media SET
			user_id = $this->user_id,
			file = '".DB::encode($this->file)."',
			mime_type = '".DB::encode($this->mime_type)."',
			title = '".DB::encode($this->title)."',
			description = '".DB::encode($this->description)."',
			status = '$this->status',
			latitude = ".($this->latitude != '' ? $this->latitude : 'NULL').",
			longitude = ".($this->longitude != '' ? $this->longitude : 'NULL')."
			WHERE id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM media_lens
			WHERE media_id = $this->id";

		$db->query_exec($sql);

		if ($this->lens->id) {
			$sql = "INSERT INTO media_lens
				VALUES ($this->id, ".$this->lens->id.")";

			$db->query_exec($sql);
		}

		return $db->rc;
	}

	function delete() {
		global $db;

		$sql = "DELETE FROM media_comment
			WHERE media_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM gallery_media
			WHERE media_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM media_lens
			WHERE media_id = $this->id";

		$db->query_exec($sql);

		$sql = "DELETE FROM media
			WHERE id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_fileinfo() {
		if (in_array($this->mime_type, array('image/pjpeg', 'image/jpeg', 'image/png', 'image/x-png'))) {
			$size = getimagesize($this->file);
			$this->width = $size[0];
			$this->height = $size[1];
			$this->channels = $size['channels'];
			$this->bits = $size['bits'];
			$this->mime = $size['mime'];
		}
	}

	function get_file_extension() {
		return substr(strrchr($this->file, '.'), 1);
	}

	function output($thumbw = 0, $thumbh = 0, $usm = false, $usm_amount = 50, $usm_radius = .5, $usm_threshold = 3, $copyright_file = '/home/robp/www.pinciuc.com/htdocs/image/copyright.jpg') {
		if (in_array($this->mime_type, array('image/pjpeg', 'image/jpeg', 'image/png', 'image/x-png'))) {
			$outfile = $this->file;

			if ($thumbw || $thumbh) {
				if (!$this->thumb_exists($thumbw, $thumbh))
					$this->create_thumb($thumbw, $thumbh, $usm, $usm_amount, $usm_radius, $usm_threshold, $copyright_file);

				$outfile = $this->get_thumb_name($thumbw, $thumbh);
			}

			header('Content-type: '.$this->mime_type);
			header('Content-length: '.filesize($outfile));
			$fp = fopen($outfile, 'rb');
			fpassthru($fp);
			fclose($fp);
		}
		else {
			echo "unsupported media format";
		}
	}

	function get_thumb_name($thumbw, $thumbh) {
		$tdim = $this->get_thumb_dimensions($thumbw, $thumbh);
		// use deltaX to create "letterbox" thumbs
		$deltaw = (int)(($thumbw - $width)/2);
		$deltah = (int)(($thumbh - $height)/2);

		$fileext = strtolower(strrchr($this->file, '.'));

		return dirname($this->file).'/'.$this->id.'_'.$tdim['width'].'x'.$tdim['height'].$fileext;
	}

	function thumb_exists($width, $height) {
		if (file_exists($this->get_thumb_name($width, $height)))
			return true;
		else
			return false;
	}

	function create_thumb($thumbw, $thumbh, $usm, $usm_amount, $usm_radius, $usm_threshold, $copyright_file) {
		$inner_frame_size = 8;
		$outer_frame_size = 5;
		$copyright_height = 30;
		$copyright_text = "© Rob Pinciuc - www.pinciuc.com";

		$tdim = $this->get_thumb_dimensions($thumbw, $thumbh);

		// use deltaX to create "letterbox" thumbs
		$deltaw = (int)(($thumbw - $tdim['width'])/2);
		$deltah = (int)(($thumbh - $tdim['height'])/2);

		$inner_frame_colour = array(255, 255, 255);
		$inner_frame_width = $tdim['width'] + (2 * $inner_frame_size);
		$inner_frame_height = $tdim['height'] + (2 * $inner_frame_size);
		$outer_frame_width = $inner_frame_width + (2 * $outer_frame_size);
		$outer_frame_height = $inner_frame_height + $outer_frame_size + $copyright_height;


		$fileext = strtolower(strrchr($this->file, '.'));
		if (in_array($this->mime_type, array('image/pjpeg', 'image/jpeg', 'image/png', 'image/x-png'))) {
			// use ImageMagick to resample and sharpen the source image
			$cmd = '/usr/bin/convert -geometry '.$thumbw.'x'.$thumbh.' -unsharp 4x1+0.4 -quality 100 '.$this->file.' '.$this->get_thumb_name($thumbw, $thumbh).'.tmp';
			//echo $cmd;
			//exit();
			$im_error = exec($cmd);

			$src_img = in_array($this->mime_type, array('image/pjpeg', 'image/jpeg')) ? imagecreatefromjpeg($this->get_thumb_name($thumbw, $thumbh).'.tmp') : imagecreatefrompng($this->get_thumb_name($thumbw, $thumbh).'.tmp');

			if ($tdim['width'] > 200 || $tdim['height'] > 300) {
				$dst_img = imagecreatetruecolor($outer_frame_width, $outer_frame_height);
				$frame_colour = imagecolorallocate($dst_img, $inner_frame_colour[0], $inner_frame_colour[1], $inner_frame_colour[2]);
				imagefilledrectangle($dst_img, $outer_frame_size, $outer_frame_size, ($outer_frame_width - $outer_frame_size), ($outer_frame_height - $copyright_height), $frame_colour);

				imagecopy($dst_img, $src_img, ($outer_frame_size + $inner_frame_size), ($outer_frame_size + $inner_frame_size), 0, 0, $tdim['width'], $tdim['height']);
				imagedestroy($src_img);

				$copyright_img = imagecreatefromjpeg($copyright_file);
				imagecopy($dst_img, $copyright_img, $outer_frame_width - imagesx($copyright_img) - $outer_frame_size - $inner_frame_size, $outer_frame_height - ((($copyright_height - imagesy($copyright_img))/2) + imagesy($copyright_img)), 0, 0, imagesx($copyright_img), imagesy($copyright_img));
				imagedestroy($copyright_img);
			}
			else {
				$dst_img = $src_img;
			}

			$result = in_array($this->mime_type, array('image/pjpeg', 'image/jpeg')) ? imagejpeg($dst_img, $this->get_thumb_name($thumbw, $thumbh), 95) : imagepng($dst_img, $this->get_thumb_name($thumbw, $thumbh), 95);

			imagedestroy($dst_img);
			unlink($this->get_thumb_name($thumbw, $thumbh).'.tmp');
			return true;
		}
		else {
			return false;
		}
	}

	function get_views($gallery_id) {
		global $db;

		if ($gallery_id) {
			// Get views for the gallery specified
			$sql = "SELECT views FROM gallery_media
				WHERE gallery_id = $gallery_id
				  AND media_id = $this->id";
		}
		else {
			// Get views for all galleries
			$sql = "SELECT SUM(views) AS views FROM gallery_media
				WHERE media_id = $this->id";
		}

		$db->query_exec($sql);

		if ($db->rc == 1) {
			$row = $db->rs[0];
			$this->views = $row[views];
		}
	}

	function increment_views($gallery_id) {
		global $db;

		$sql = "UPDATE gallery_media
			SET views = views + 1
			WHERE gallery_id = $gallery_id
			  AND media_id = $this->id";

		$db->query_exec($sql);

		return $db->rc;
	}

	function get_exif($foo = false) {
		ini_set('include_path', ini_get('include_path').'/home/robp/www.pinciuc.com/include/PJMT');
		// Hide any unknown EXIF tags
		$GLOBALS['HIDE_UNKNOWN_TAGS'] = TRUE;
		require_once('PJMT/EXIF.php');

		$this->exif = array();
		$display_exif_atts = array('Model', 'ISOSpeedRatings', 'DateTimeOriginal', 'ShutterSpeedValue', 'ExposureTime', 'ApertureValue', 'FNumber', 'ExposureBiasValue', 'FocalLength');
		$exif_fractions = array('ShutterSpeedValue', 'ApertureValue', 'FNumber', 'ExposureBiasValue', 'FocalLength');

		$exif = exif_read_data($this->file,'EXIF');

		if ($exif != NULL) {
			echo "\n<!-- \n";
			print_r($exif);
			//print "$this->latitude,$this->longitude\n";
			echo "\n-->\n";
			foreach ($exif as $key => $value) {
				if (in_array($key, $display_exif_atts) || $foo) {
					if ($key == 'Model') {
						$key = 'Camera';
						if ($value == 'EOS DIGITAL REBEL')
							$value = "Canon $value";
					}
					elseif ($key == 'ISOSpeedRatings')
						$key = 'ISO';
					elseif ($key == 'DateTimeOriginal') {
						$key = 'Date/Time';
						$timestamp = strtotime($value);
						$value = date('F jS, Y', $timestamp).' at '.date('g:ia', $timestamp);
//						list($date,$time) = split(' ', $value);
//						$value = str_replace(':', '/', $date).' '.$time;
					} elseif ($key == 'ExposureTime') {
						$key = 'Exposure Time';
						if (ereg('/1$', $value))
							$value = preg_replace('/\/1$/', '', $value);
					}

					if (in_array($key, $exif_fractions)) {
						list($lhs,$rhs) = split('/', $value);
						if ($key == 'ShutterSpeedValue') {
						/*
							$key = 'Shutter Speed';
							if (ereg('^-', $lhs))
								$value = round(pow(2,(-$lhs/$rhs)));
							else
								$value = '1/'.round(pow(2,($lhs/$rhs)));
						*/
						}
						elseif ($key == 'FNumber') {
							$key = 'Aperture';
							$value = $lhs/$rhs;
							$value = strpos($value, '.') ? substr($value, 0, strpos($value, '.')+2) : $value; //round($value, ($value > 7.9 ? 0 : 1));
							$value = 'f/'.str_replace('.0', '', ($value > 7.9 ? round($value, 0) : $value));
						}
						elseif ($key == 'ApertureValue' && !$this->exif['Aperture']) {
							$key = 'Aperture';
							$value = exp((($lhs/$rhs)*log(2))/2);
							$value = strpos($value, '.') ? substr($value, 0, strpos($value, '.')+2) : $value; //round($value, ($value > 7.9 ? 0 : 1));
							$value = 'f/'.str_replace('.0', '', ($value > 7.9 ? round($value, 0) : $value));
						}
						elseif ($key == 'ExposureBiasValue' && round(($lhs/$rhs), 1) != 0) {
							$key = 'Exposure Compensation';
							$value = round(($lhs/$rhs), 1);
						}
						elseif ($key == 'FocalLength' && !$this->lens->prime) {
							$key = 'Focal Length';
							$value = round(($lhs/$rhs), 1).'mm';
						}
					}
					$this->exif[$key] = $value;
					if ($key == 'Camera' && $this->lens->id)
						$this->exif['Lens'] = $this->lens->name;

				}
			}
			if ($this->exif['Focal Length']) {
				// apply the focal length multiplier
				if (strstr($this->exif['Camera'], 'DIGITAL REBEL') || strstr($this->exif['Camera'], '10D'))
					$this->exif['Focal Length'] .= ' ('.floor($this->exif['Focal Length'] * 1.6).'mm equiv.)';
				elseif (strstr($this->exif['Camera'], 'PowerShot A40'))
					$this->exif['Focal Length'] .= ' ('.floor($this->exif['Focal Length'] * 6.5).'mm equiv.)';
			}
		}
	}

	function get_comments() {
		global $db;
		$this->comments = array();

		$sql = "SELECT * FROM blog_comment
				WHERE blog_entry_id = $this->id
				  AND comment_type = 'M'
				ORDER BY creation_date";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->comments[] = new Blog_Comment(0, $row);
	}

	function get_galleries($options = array()) {
		global $db;

		$sql = "SELECT g.*
				FROM gallery_media gm, gallery g
				WHERE gm.media_id = $this->id
				  AND gm.gallery_id = g.id
				ORDER BY ".($options['order_by'] == 'title' ? 'title' : 'gallery_id')." ".($options['sort'] ? $options['sort'] : 'ASC');

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->galleries[] = new Gallery(0, $row);
	}

	function get_gallery_media($options = array()) {
		global $db;

		$sql = "SELECT *
			FROM gallery_media
			WHERE media_id = $this->id";

		$db->query_exec($sql);

		foreach ($db->rs as $row)
			$this->gallery_media[] = new Gallery_Media(0, 0, $row);
	}

	function get_lens() {
		global $db;

		$sql = "SELECT l.*
				FROM media_lens ml, lens l
				WHERE ml.media_id = $this->id
				  AND ml.lens_id = l.id";

		$db->query_exec($sql);

		if ($db->rc == 1) {
			$row = $db->rs[0];
			$this->lens = new Lens(0, $row);
		}
	}

	function get_thumb_dimensions($thumbw, $thumbh) {
		$result = array();

		$scale = min($thumbw/$this->width, $thumbh/$this->height);
		$result['width'] = (int)($this->width*$scale);
		$result['height'] = (int)($this->height*$scale);

		return $result;
	}
}
