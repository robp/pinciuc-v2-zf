<?php
	require_once('global.php');
	require_once('Gallery.php');

	form_param($gallery_id, 15);
	form_param($copyright_file, '/home/robp/www.pinciuc.com/htdocs/image/copyright.jpg');

	$db = new DB("pinciuc");

	$user = new User(1);

	$gallery = new Gallery($gallery_id);

	$sizes = array(100, 600);

	function process_gallery($gallery) {
		global $copyright_file;
		global $sizes;

		echo "GALLERY $gallery->id: $gallery->title\n";

		$gallery->get_galleries(array('order' => 'DESC', 'status' => 'public'));

		foreach ($gallery->galleries as $t_gallery) {
			process_gallery($t_gallery);
		}

		$gallery->get_media();

		foreach ($gallery->media as $media) {
			echo "    MEDIA $media->id: $media->title\n";

			foreach ($sizes as $size) {
				echo "        SIZE: $size... ";
				if (!$media->thumb_exists($size, $size)) {
					$media->create_thumb($size, $size, $usm, $usm_amount, $usm_radius, $usm_threshold, $copyright_file);
					echo "done.\n";
				}
				else {
					echo "exists.\n";
				}
			}
		}
	}

	process_gallery($gallery);
