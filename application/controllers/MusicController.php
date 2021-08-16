<?php
/** BaseController */
Zend_Loader::loadClass('BaseController');

class MusicController extends BaseController
{
    public function indexAction()
    {
        Zend_Loader::loadClass('Itunes_Artist');

        $dom = &$this->view->dom;

        // get all artist names
        $allArtistNames     = Itunes_Artist::getAlbumArtistNames();
        /*
        $domAlbumArtists    = $dom->createElement('albumArtists');

        foreach ($allArtistNames as $albumArtist)  {
            $domAlbumArtist = $dom->createElement('albumArtist');
            $domAlbumArtist->appendChild($dom->createElement('name', $albumArtist));
            $domAlbumArtists->appendChild($domAlbumArtist);
        }
        $this->view->dom->appendChild($domAlbumArtists);
*/
        /*
        // get recently added albums
        $recentlyAddedAlbums    = ItunesTrack::getRecentlyAddedAlbums();
        $domRecentlyAddedAlbums = $dom->createElement('recentlyAddedAlbums');

        foreach ($recentlyAddedAlbums as $album) {
            $domAlbum = $dom->createElement('album');
            $domAlbum->appendChild($dom->createElement('albumArtist', $album->albumArtist));
            $domAlbum->appendChild($dom->createElement('title', $album->album));
            $domRecentlyAddedAlbums->appendChild($domAlbum);
        }
        $this->view->dom->appendChild($domRecentlyAddedAlbums);


        // get recently played albums
        $recentlyPlayedAlbums       = ItunesTrack::getRecentlyPlayedAlbums();
        $domRecentlyPlayedAlbums    = $dom->createElement('recentlyPlayedAlbums');

        foreach ($recentlyPlayedAlbums as $album) {
            $domAlbum = $dom->createElement('album');
            $domAlbum->appendChild($dom->createElement('albumArtist', $album->albumArtist));
            $domAlbum->appendChild($dom->createElement('title', $album->album));
            $domRecentlyPlayedAlbums->appendChild($domAlbum);
        }
        $this->view->dom->appendChild($domRecentlyPlayedAlbums);


        // add some other statistics
        $this->view->allTracksCount     = ItunesTrack::getAllTracksCount();
        $this->view->allAlbumsCount     = ItunesTrack::getAllAlbumsCount();
        $this->view->allArtistsCount    = ItunesTrack::getAllArtistsCount();
        $this->view->allSizesSum        = ItunesTrack::getAllSizesSum();
        */
    }

    public function albumsAction()
    {
        Zend_Loader::loadClass('ItunesTrack');
        Zend_Loader::loadClass('Zend_Filter_Input');

        $table = new ItunesTrack();

        // get all artist names to validate input
        $allArtistNames = array_merge(ItunesTrack::getAllAlbumArtistNames(), ItunesTrack::getAllArtistNames());

        // Filter and validate our input
        $filters = array(
            'albumArtist' => array(
                'StringTrim',
                'StripTags',
            ),
        );
        $validators = array(
            'albumArtist' => array(
                'presence' => 'required',
                'NotEmpty',
                array('InArray', $allArtistNames),
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            $this->view->albumArtist = $input->albumArtist;

            $dom = &$this->view->dom;


            // get all albums associated to this artist
            $domAlbums = $dom->createElement('albums');

            $rows = ItunesTrack::getAlbumsByAlbumArtist(
                $input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist
            );

            foreach ($rows as $row) {
                $title = strlen($row->album) ? $row->album : Zend_Registry::get('config')->music->defaultTitle;
                $domAlbum = $dom->createElement('album');
                $domAlbum->appendChild($dom->createElement('title', $title));
                $domAlbum->appendChild($dom->createElement('year', $row->year));
                $domAlbums->appendChild($domAlbum);
            }
            $this->view->dom->appendChild($domAlbums);


            // get all albums this artist appears on
            $domCreditedAlbums = $dom->createElement('creditedAlbums');

            $rows = ItunesTrack::getOtherAlbumsByArtist(
                $input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist
            );

            foreach ($rows as $row) {
                $title = strlen($row->album) ? $row->album : Zend_Registry::get('config')->music->defaultTitle;
                $domAlbum = $dom->createElement('album');
                $domAlbum->appendChild($dom->createElement('title', $title));
                $domAlbum->appendChild($dom->createElement('albumArtist', $row->albumArtist));
                $domCreditedAlbums->appendChild($domAlbum);
            }
            $this->view->dom->appendChild($domCreditedAlbums);
        }
        else {
            $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input->getMessages());
        }
    }

    public function albumAction()
    {
        Zend_Loader::loadClass('ItunesTrack');
        Zend_Loader::loadClass('Zend_Filter_Input');

        $table = new ItunesTrack();

        // get all artist names to validate input
        $allArtistNames = ItunesTrack::getAllAlbumArtistNames();

        // Filter and validate our input
        $filters = array(
            'albumArtist' => array(
                'StringTrim',
                'StripTags',
            ),
        );
        $validators = array(
            'albumArtist' => array(
                'presence' => 'required',
                'NotEmpty',
                array('InArray', $allArtistNames),
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            // get all titles to validate input
            $allTitles = array(Zend_Registry::get('config')->music->defaultTitle);

            $rows = ItunesTrack::getAlbumsByAlbumArtist(
                $input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist
            );

            foreach ($rows as $row)
                $allTitles[] = $row->album;

            // Filter and validate our input
            $filters = array(
                'title' => array(
                    'StringTrim',
                    'StripTags',
                ),
            );
            $validators = array(
                'title' => array(
                    'presence' => 'required',
                    'NotEmpty',
                    array('InArray', $allTitles),
                ),
            );

            $input2 = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

            if ($input2->isValid()) {

                $dom = &$this->view->dom;

                $year       = NULL;
                $discNumber = 1;
                $discCount  = NULL;
                $trackCount = NULL;
                $totalTime  = NULL;
                $totalSize  = NULL;

                // get all albums associated to this artist
                $domAlbum = $dom->createElement('album');
                $domAlbum->appendChild($dom->createElement('albumArtist', $input->albumArtist));
                $domAlbum->appendChild($dom->createElement('title', $input2->title));

                $domTracklist = $dom->createElement('tracklist');
                $domTracklist->setAttribute('discNumber', $discNumber);

                $rows = ItunesTrack::getTracksByAlbum(
                    $input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist,
                    $input2->title == Zend_Registry::get('config')->music->defaultTitle ? '' : $input2->title
                );

                foreach ($rows as $row) {
                    $filename = Zend_Registry::get('config')->music->libraryDir . '/' . rawurldecode($row->location);

                    if (file_exists($filename))
                        $totalSize += filesize($filename);

                    $totalTime += $row->totalTime;

                    if ($row->year)
                        $year = $row->year;
                    if ($row->discCount)
                        $discCount = $row->discCount;
                    if ($row->trackCount)
                        $trackCount = $row->trackCount;

                    if ($row->discNumber && ($row->discNumber != $discNumber)) {
                        $domAlbum->appendChild($domTracklist);
                        $discNumber = $row->discNumber;
                        $domTracklist = $dom->createElement('tracklist');
                        $domTracklist->setAttribute('discNumber', $discNumber);
                    }

                    $domTrack = $dom->createElement('track');
                    $domTrack->setAttribute('id', $row->trackId);
                    $domTrack->setAttribute('persistentId', $row->persistentId);
                    $domTrack->setAttribute('discNumber', $row->discNumber);
                    $domTrack->setAttribute('discCount', $row->discCount);
                    $domTrack->setAttribute('trackNumber', $row->trackNumber);
                    $domTrack->setAttribute('trackCount', $row->trackCount);

                    $domTrack->appendChild($dom->createElement('name', $row->name));
                    $domTrack->appendChild($dom->createElement('artist', $row->artist));
                    $domTrack->appendChild($dom->createElement('totalTime', $row->totalTime));
                    $domTracklist->appendChild($domTrack);
                }
                $domAlbum->appendChild($domTracklist);

                $domAlbum->appendChild($dom->createElement('year', $year));
                $domAlbum->appendChild($dom->createElement('discCount', $discCount));
                $domAlbum->appendChild($dom->createElement('trackCount', $trackCount));
                $domAlbum->appendChild($dom->createElement('totalTime', $totalTime));
                $domAlbum->appendChild($dom->createElement('totalSize', $totalSize));

                $this->view->dom->appendChild($domAlbum);

                // Add other albums to XML
                $domOtherAlbums = $dom->createElement('otherAlbums');

                $rows = ItunesTrack::getAlbumsByAlbumArtist(
                    $input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist
                );

                foreach ($rows as $row) {
                    $title = strlen($row->album) ? $row->album : Zend_Registry::get('config')->music->defaultTitle;
                    if ($title != $input2->title) {
                        $domAlbum = $dom->createElement('album');
                        $domAlbum->appendChild($dom->createElement('title', $title));
                        $domOtherAlbums->appendChild($domAlbum);
                    }
                }
                $this->view->dom->appendChild($domOtherAlbums);


                // Add credited albums to XML
                $domCreditedAlbums = $dom->createElement('creditedAlbums');

                $rows = ItunesTrack::getOtherAlbumsByArtist(
                    $input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist
                );

                foreach ($rows as $row) {
                    $title = strlen($row->album) ? $row->album : Zend_Registry::get('config')->music->defaultTitle;
                    $domAlbum = $dom->createElement('album');
                    $domAlbum->appendChild($dom->createElement('title', $title));
                    $domAlbum->appendChild($dom->createElement('albumArtist', $row->albumArtist));
                    $domCreditedAlbums->appendChild($domAlbum);
                }
                $this->view->dom->appendChild($domCreditedAlbums);
            }
            else {
                $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input2->getMessages());
            }
        }
        else {
            $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input->getMessages());
        }
    }

    public function trackAction()
    {
        Zend_Loader::loadClass('ItunesTrack');
        Zend_Loader::loadClass('Zend_Filter_Input');

        $table = new ItunesTrack();

        // get all artist names to validate input
        //$allArtistNames = ItunesTrack::getAllAlbumArtistNames();

        // Filter and validate our input
        $filters = array(
            'persistentId' => array(
                'Alnum',
                'StringToUpper',
            ),
        );
        //e.g., 7314DECE7C673AD9
        $validators = array(
            'persistentId' => array(
                'presence' => 'required',
                'NotEmpty',
                array('StringLength', 16, 16),
                array('Regex', '/^[0-9A-F]+$/'),
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            $track = ItunesTrack::getTrackByPersistentId($input->persistentId);

            $dom = &$this->view->dom;

            $domTrack = $dom->createElement('track');
            $domTrack->setAttribute('id', $track->trackId);
            $domTrack->setAttribute('persistentId', $track->persistentId);
            $domTrack->setAttribute('discNumber', $track->discNumber);
            $domTrack->setAttribute('discCount', $track->discCount);
            $domTrack->setAttribute('trackNumber', $track->trackNumber);
            $domTrack->setAttribute('trackCount', $track->trackCount);

            $domTrack->appendChild($dom->createElement('albumArtist', $track->albumArtist));
            $domTrack->appendChild($dom->createElement('album', $track->album));
            $domTrack->appendChild($dom->createElement('artist', $track->artist));
            $domTrack->appendChild($dom->createElement('name', $track->name));
            $domTrack->appendChild($dom->createElement('composer', $track->composer));
            $domTrack->appendChild($dom->createElement('genre', $track->genre));
            $domTrack->appendChild($dom->createElement('kind', $track->kind));
            $domTrack->appendChild($dom->createElement('size', $track->size));
            $domTrack->appendChild($dom->createElement('totalTime', $track->totalTime));
            $domTrack->appendChild($dom->createElement('trackNumber', $track->trackNumber));
            $domTrack->appendChild($dom->createElement('year', $track->year));
            $domTrack->appendChild($dom->createElement('bitRate', $track->bitRate));
            $domTrack->appendChild($dom->createElement('sampleRate', $track->sampleRate));
            $domTrack->appendChild($dom->createElement('discNumber', $track->discNumber));
            $domTrack->appendChild($dom->createElement('location', rawurldecode($track->location)));

            $this->view->dom->appendChild($domTrack);
        }
        else {
            $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input->getMessages());
        }
    }

    public function coverAction() {
        Zend_Loader::loadClass('ItunesTrack');
        Zend_Loader::loadClass('Zend_Filter_Input');

        $table = new ItunesTrack();

        // get all artist names to validate input
        $allArtistNames = ItunesTrack::getAllAlbumArtistNames();

        // Filter and validate our input
        $filters = array(
            'albumArtist' => array(
                'StringTrim',
                'StripTags',
            ),
        );
        $validators = array(
            'albumArtist' => array(
                'presence' => 'required',
                'NotEmpty',
                array('InArray', $allArtistNames),
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            // get all titles to validate input
            $allTitles = array(Zend_Registry::get('config')->music->defaultTitle);

            $rows = ItunesTrack::getAlbumsByAlbumArtist($input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist);

            foreach ($rows as $row)
                $allTitles[] = $row->album;

            // Filter and validate our input
            $filters = array(
                'title' => array(
                    'StringTrim',
                    'StripTags',
                ),
            );
            $validators = array(
                'title' => array(
                    'presence' => 'required',
                    'NotEmpty',
                    array('InArray', $allTitles),
                ),
            );

            $input2 = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

            if ($input2->isValid()) {
                $rows = ItunesTrack::getTracksByAlbum(
                    $input->albumArtist == Zend_Registry::get('config')->music->defaultTitle ? '' : $input->albumArtist,
                    $input2->title == Zend_Registry::get('config')->music->defaultTitle ? '' : $input2->title
                );

                $row = $rows->current();

                $filename = Zend_Registry::get('config')->music->libraryDir . '/' . rawurldecode(dirname($row->location)) . '/folder.jpg';

                if (!file_exists($filename))
                    $filename = getenv("DOCUMENT_ROOT") . '/' . Zend_Registry::get('config')->music->defaultCover;

                if (file_exists($filename)) {
                    $finfo = finfo_open(FILEINFO_MIME);
                    $mimeType = finfo_file($finfo, $filename);

                    header("Content-type: $mimeType");
                    header('Content-length: '.filesize($filename));
                    readfile($filename);
                    exit();
                }

                echo "Error: file does not exist";
            }
            else {
                $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input2->getMessages());
            }
        }
        else {
            $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input->getMessages());
        }
    }
}
