<?php
/** Itunes */
require_once('Itunes.php');

class Itunes_Artist extends Itunes
{
    public $name;
    
    public function __construct($name = '') {
        $this->name = $name;
    }
    
    public function getAlbums() {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('album', 'year'));

        if (!strlen($this->name))
            $select->where('albumArtist IS NULL');
        else
            $select->where('albumArtist = ?', $this->name);

        $select->group('album')
               ->order('year DESC')
               ->order("TRIM(LEADING 'The ' FROM album)");

        $rows = $table->fetchAll($select);
        return $rows;
    }

    public function getAlbumsContributedTo() {
        $table = new self();

        $select = $table->select();
        $select->from($table, array('album', 'albumArtist', 'year'))
               ->where('albumArtist != artist');

        if (!strlen($this->name))
            $select->where('artist IS NULL');
        else
            $select->where('artist = ?', $this->name);

        $select->group('album')
               ->group('albumArtist')
               ->order('year DESC')
               ->order("TRIM(LEADING 'The ' FROM album)");

        $rows = $table->fetchAll($select);
        return $rows;
    }
  
    public static function getAlbumArtistNames() {
        $table = new self();
        $allArtistNames = array(self::DEFAULT_TITLE);
        
        $select = $table->select();
    /*
        $select->from($table, array('DISTINCT (albumArtist)'))
               ->order("TRIM(LEADING 'The ' FROM albumArtist)");

        $rows = $table->fetchAll($select);

        foreach ($rows as $row)
            $allArtistNames[] = $row->albumArtist;

        return $allArtistNames;
        */
    }  
/*
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
*/
}
