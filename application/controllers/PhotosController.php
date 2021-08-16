<?php
/** BaseController */
Zend_Loader::loadClass('BaseController');

class PhotosController extends BaseController
{
    public function indexAction()
    {
        Zend_Loader::loadClass('Zend_Rest_Client');

        $cacheName = 'flickrPhotosets_' . str_replace(' ', '', Zend_Registry::get('config')->photos->flickrApi->username);
        $cacheLife = 86400; // cache lifetime of 1 day

        if (!$photosetsXml = $this->tryCache($cacheName, $cacheLife)) {
            // cache miss

            $client = new Zend_Rest_Client('http://api.flickr.com/services/rest/');
            $client->api_key(Zend_Registry::get('config')->photos->flickrApi->key);

            // get the flickr user for our username
            $user = $client->method('flickr.people.findByUsername')
                ->username(Zend_Registry::get('config')->photos->flickrApi->username)
                ->get();

            // get the user's photosets
            $photosets = $client->method('flickr.photosets.getList')
                ->user_id((string)$user->user['nsid'])
                ->get();

            $myPhotosets = array();

            // get the primary photo for each set and append it to the
            // photoset xml tree
            foreach ($photosets->photosets->photoset as $photoset) {
                $photo = $client->method('flickr.photos.getInfo')
                    ->photo_id((string)$photoset['primary'])
                    ->get();

                $sizes = $client->method('flickr.photos.getSizes')
                    ->photo_id((string)$photo->photo['id'])
                    ->get();

                $this->simplexmlAppend($photo->photo, $sizes->sizes);
                $this->simplexmlAppend($photoset, $photo->photo);
                $myPhotosets[] = $photoset;
            }

            $photosetsXml = join('', array_map(create_function('$p', 'return $p->asXML();'), $myPhotosets));
            $photosetsXml = $this->saveCache($photosetsXml, $cacheName, $cacheLife);
        }

        $domPhotosets      = $this->view->dom->createElement('photosets');

        $fragment = $this->view->dom->createDocumentFragment();
        $fragment->appendXML($photosetsXml);
        $domPhotosets->appendChild($fragment);

        $this->view->dom->appendChild($domPhotosets);
    }

    public function galleryAction()
    {
        Zend_Loader::loadClass('Zend_Filter_Input');

        // Filter and validate our input
        $filters = array(
            'galleryId' => 'Digits',
            'page'      => 'Digits',
        );
        $validators = array(
            'galleryId' => array(
                'presence' => 'required',
                'Digits',
                array('GreaterThan', 0),
            ),
            'page' => array(
                'Digits',
                array('GreaterThan', 0),
                'default' => 1,
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            $cacheName = 'flickrPhotoset_' . $input->galleryId . '_page' . $input->page;
            $cacheLife = 86400; // cache lifetime of 1 day

            if (!$photosetXml = $this->tryCache($cacheName, $cacheLife)) {
                // cache miss
                Zend_Loader::loadClass('Zend_Rest_Client');

                $client = new Zend_Rest_Client('http://api.flickr.com/services/rest/');
                $client->api_key(Zend_Registry::get('config')->photos->flickrApi->key);

                // get the flickr user for our username
                $user = $client->method('flickr.people.findByUsername')
                    ->username(Zend_Registry::get('config')->photos->flickrApi->username)
                    ->get();

                // get the photoset specified
                $photoset = $client->method('flickr.photosets.getInfo')
                    ->photoset_id($input->galleryId)
                    ->get();

                // make sure the photoset belongs to our user
                if ((string)$photoset->photoset['owner'] != (string)$user->user['nsid']) {
                    $this->_currentMessages['error']['photosetInvalidOwner'] = array('galleryId' => 'photoset has invalid owner.');
                } else {
                    // get all photos in the specified photoset
                    $photos = $client->method('flickr.photosets.getPhotos')
                        ->photoset_id((string)$photoset->photoset['id'])
                        ->per_page(Zend_Registry::get('config')->photos->galleries->photosPerPage)
                        ->page($input->page)
                        ->get();

                    // make sure the specified page number is valid
                    if ($input->page > $photos->photoset['pages']) {
                        $this->_currentMessages['error']['photosetInvalidPageNumber'] = array('page' => 'invalid page number.');
                    } else {
                        // for each photo, get available sizes and add to $photoset
                        foreach ($photos->photoset->photo as $photo) {
                            $sizes = $client->method('flickr.photos.getSizes')
                                ->photo_id((string)$photo['id'])
                                ->get();

                            $this->simplexmlAppend($photo, $sizes->sizes);
                            $this->simplexmlAppend($photoset->photoset, $photo);
                        }

                        $photoset->photoset->addAttribute('page', $photos->photoset['page']);
                        $photoset->photoset->addAttribute('per_page', $photos->photoset['per_page']);
                        $photoset->photoset->addAttribute('pages', $photos->photoset['pages']);

                        $photosetXml = $this->saveCache($photoset->photoset->asXML(), $cacheName, $cacheLife);
                    }
                }
            }
        }
        else {
            $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input->getMessages());
        }

        if (!count($this->_currentMessages['error'])) {
            $fragment = $this->view->dom->createDocumentFragment();
            $fragment->appendXML($photosetXml);
            $this->view->dom->appendChild($fragment);
        }
    }

    public function photoAction()
    {
        Zend_Loader::loadClass('Zend_Filter_Input');

        // Filter and validate our input
        $filters = array(
            'galleryId'     => 'Digits',
            'photoId'     => 'Digits',
        );
        $validators = array(
            'galleryId' => array(
                'presence' => 'required',
                'Digits',
                array('GreaterThan', 0),
            ),
            'photoId' => array(
                'presence' => 'required',
                'Digits',
                array('GreaterThan', 0),
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            Zend_Loader::loadClass('Zend_Cache');

            $cacheName = 'flickrPhoto_' . $input->galleryId . '_' . $input->photoId;
            $cacheLife = 86400; // cache lifetime of 1 day

            if (!$photosetXml = $this->tryCache($cacheName, $cacheLife)) {
                // cache miss
                Zend_Loader::loadClass('Zend_Rest_Client');

                $client = new Zend_Rest_Client('http://api.flickr.com/services/rest/');
                $client->api_key(Zend_Registry::get('config')->photos->flickrApi->key);

                
                // get the flickr user for our username
                $user = $client->method('flickr.people.findByUsername')
                    ->username(Zend_Registry::get('config')->photos->flickrApi->username)
                    ->get();

                    // get the photoset specified
                $photoset = $client->method('flickr.photosets.getInfo')
                    ->photoset_id($input->galleryId)
                    ->get();

                // make sure the photoset belongs to our user
                if ((string)$photoset->photoset['owner'] != (string)$user->user['nsid']) {
                    $this->_currentMessages['error']['photosetInvalidOwner'] = array('galleryId' => 'photoset has invalid owner.');
                } else {
                    // get all photos in the specified photoset
                    $photos = $client->method('flickr.photosets.getPhotos')
                        ->photoset_id((string)$photoset->photoset['id'])
                        ->get();

                    // get the photo specified
                    $photo = $client->method('flickr.photos.getInfo')
                        ->photo_id($input->photoId)
                        ->get();

                    // make sure the photo belongs to the specified photoset
                    $found = false;

                    foreach ($photos->photoset->photo as $tmpPhoto) {
                        if ((string)$tmpPhoto['id'] == (string)$photo->photo['id']) {
                            $found = true;
                            break;
                        }
                    }

                    if ($found) {
                        // get the available sizes for the photo
                        $sizes = $client->method('flickr.photos.getSizes')
                            ->photo_id($input->photoId)
                            ->get();

                        $this->simplexmlAppend($photo->photo, $sizes->sizes);
                        $this->simplexmlAppend($photoset->photoset, $photo->photo);

                        $photosetXml = $this->saveCache($photoset->photoset->asXML(), $cacheName, $cacheLife);
                    }
                    else
                        $this->_currentMessages['error']['photosetInvalidPhoto'] = array('photoId' => 'photo not found in photoset.');
                }
            }
        }
        else {
            $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input->getMessages());
        }

        if (!count($this->_currentMessages['error'])) {
            $fragment = $this->view->dom->createDocumentFragment();
            $fragment->appendXML($photosetXml);
            $this->view->dom->appendChild($fragment);
        }
    }

    public function thumbnailAction()
    {
        Zend_Loader::loadClass('Zend_Filter_Input');

        // Filter and validate our input
        $filters = array(
            'id'     => 'Digits',
            'width'  => 'Digits',
            'height' => 'Digits',
            'size'   => 'Digits',
            'html'   => array(
                'Alpha', 'StringToLower'
            ),
        );
        $validators = array(
            'id' => array(
                'presence' => 'required',
                'Digits',
                array('GreaterThan', 0),
            ),
            'width' => array(
                'Digits',
                array('Between', 40, 1000),
            ),
            'height' => array(
                'Digits',
                array('Between', 40, 1000),
            ),
            'size' => array(
                'Digits',
                array('Between', 40, 1000),
            ),
            'html' => array(
                array('InArray', array('true')),
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());


        if ($input->isValid()) {
            Zend_Loader::loadClass('Media');

            $media = new Media($input->id);

            if (!($media->id > 0))
                $this->_currentMessages['error']['idNotExist'] = array('id' => 'media id does not exist.');
            elseif (!($media->status == 'A'))
                $this->_currentMessages['error']['statusNotActive'] = array('status' => 'media status is not active.');
        }
        else {
            $this->_currentMessages['error'] = array_merge($this->_currentMessages['error'], $input->getMessages());
        }

        if (!count($this->_currentMessages['error'])) {
            // good to go

            if (isset($input->size))
                $width = $height = $size;
            else {
                $width  = $input->width;
                $height = $input->height;
            }

            if (!$input->isValid('html')) {
                $usm_radius = .3;
                $usm_threshold = 3;
                if (max($width, $height) <= 100)
                    $usm_amount = 70;
                elseif (max($width, $height) <= 600)
                    $usm_amount = 35;
                elseif (max($width, $height) <= 1000)
                    $usm_amount = 20;
                else
                    $usm_amount = 0;

                $this->getFrontController()->setParam('noViewRenderer', true);
                $media->output($width, $height, true, $usm_amount, $usm_radius, $usm_threshold);

            }
            else {
                $this->view->imageUrl = '/'.join('/', array(
                    $this->getRequest()->getParam('controller'),
                    $this->getRequest()->getParam('action'),
                    'id', $media->id,
                    'width', $width,
                    'height', $height,
                ));
                $this->view->imageTitle = $media->title;
            }
        }
    }

    public function gearAction()
    {
    }
}
