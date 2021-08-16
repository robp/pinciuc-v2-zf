<?php
/** Zend_Db_Table_Abstract */
require_once('Zend/Db/Table/Abstract.php');

class Itunes extends Zend_Db_Table_Abstract
{
    protected $_schema  = 'pinciuc';
    protected $_name    = 'itunesmusic';
    
    const DEFAULT_TITLE = '(none)'; //Zend_Registry::get('config')->music->defaultTitle;

    public static function getAllTracksCount() {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('COUNT(*) AS count'));
        $row = $table->fetchRow($select);

        return $row->count;
    }

    public static function getAllAlbumsCount() {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('COUNT(DISTINCT(CONCAT(albumArtist, album))) AS count'));
        $row = $table->fetchRow($select);

        return $row->count;
    }

    public static function getAllArtistsCount() {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('COUNT(DISTINCT(artist)) AS count'));
        $row = $table->fetchRow($select);

        return $row->count;
    }

    public static function getAllSizesSum() {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('SUM(size) AS size'));
        $row = $table->fetchRow($select);

        return $row->size;
    }

    public static function getAllAlbumArtistNames() {
        $table = new self();
        $allArtistNames = array(Zend_Registry::get('config')->music->defaultTitle);

        $select = $table->select();
        $select->from($table, array('DISTINCT (albumArtist)'))
               ->order("TRIM(LEADING 'The ' FROM albumArtist)");

        $rows = $table->fetchAll($select);

        foreach ($rows as $row)
            $allArtistNames[] = $row->albumArtist;

        return $allArtistNames;
    }

    public static function getAllArtistNames() {
        $table = new self();
        $allArtistNames = array(Zend_Registry::get('config')->music->defaultTitle);

        $select = $table->select();
        $select->from($table, array('DISTINCT (artist)'))
               ->order("TRIM(LEADING 'The ' FROM artist)");

        $rows = $table->fetchAll($select);

        foreach ($rows as $row)
            $allArtistNames[] = $row->artist;

        return $allArtistNames;
    }

    public static function getAlbumsByAlbumArtist($albumArtist = '') {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('album', 'year'));

        if (!strlen($albumArtist))
            $select->where('albumArtist IS NULL');
        else
            $select->where('albumArtist = ?', $albumArtist);

		$select->group('album')
               ->order('year DESC')
               ->order("TRIM(LEADING 'The ' FROM album)");

        $rows = $table->fetchAll($select);
        return $rows;
    }

    public static function getOtherAlbumsByArtist($artist = '') {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('album', 'albumArtist', 'year'))
               ->where('albumArtist != artist');

        if (!strlen($artist))
            $select->where('artist IS NULL');
        else
            $select->where('artist = ?', $artist);

        $select->group('album')
               ->group('albumArtist')
               ->order('year DESC')
               ->order("TRIM(LEADING 'The ' FROM album)");

        $rows = $table->fetchAll($select);
        return $rows;
    }

    public static function getTracksByAlbum($albumArtist = '', $album = '') {
        $table = new self();
        $select = $table->select();

        if (!strlen($albumArtist))
            $select->where('albumArtist IS NULL');
        else
            $select->where('albumArtist = ?', $albumArtist);

        if (!strlen($album))
            $select->where('album IS NULL');
        else
            $select->where('album = ?', $album);

        $select->order(array('discNumber', 'trackNumber', 'location'));

        $rows = $table->fetchAll($select);
        return $rows;
    }

    public static function getRecentlyAddedAlbums($limit = 10) {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('album', 'albumArtist'))
               ->group('album')
               ->group('albumArtist')
               ->order('dateAdded DESC')
               ->order("TRIM(LEADING 'The ' FROM album)")
               ->limit($limit);

        $rows = $table->fetchAll($select);
        return $rows;
    }

    public static function getRecentlyPlayedAlbums($limit = 10) {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('album', 'albumArtist'))
               ->group('album')
               ->group('albumArtist')
               ->order('playDateUtc DESC')
               ->order("TRIM(LEADING 'The ' FROM album)")
               ->limit($limit);

        $rows = $table->fetchAll($select);
        return $rows;
    }

    public static function getTrackByPersistentId($persistentId = '') {
        $table = new self();

        $select = $table->select();
        $select->where('persistentId = ?', $persistentId);

        $row = $table->fetchRow($select);
        return $row;
    }

/*
    function cover_exists() {
        if (file_exists($this->get_cover_filename()) && filesize($this->get_cover_filename()))
            return true;
        else
            return false;
    }

    function get_cover_filename() {
        return dirname($this->file).'/folder.jpg';
    }
*/

    // ------------------------------------------------
    // Static/Class functions
    // ------------------------------------------------
/*
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
*/
}
