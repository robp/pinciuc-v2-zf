<?php
/** Zend_Controller_Action */
Zend_Loader::loadClass('Zend_Controller_Action');
Zend_Loader::loadClass('Db_Mysql');
Zend_Loader::loadClass('XML_Serializer');

class BaseController extends Zend_Controller_Action
{
    //private $db;
    protected $_xmlSerializer;
    protected $_flashMessenger;
    protected $_currentMessages = array(
        'info'  => array(),
        'error' => array(),
    );

    public function init()
    {
        // create the XML serializer
        //
        // An array of serializer options
        $serializer_options = array(
            XML_SERIALIZER_OPTION_XML_ENCODING => 'utf-8',
            XML_SERIALIZER_OPTION_INDENT => '  ',
            XML_SERIALIZER_OPTION_DEFAULT_TAG => 'value'
        );
        $this->_xmlSerializer = &new XML_Serializer($serializer_options);
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
    }

    public function postDispatch()
    {
        // variables needed for all views get assigned here
        $this->view->currentYear = date('Y');

        // assign messages to the view
        $messages = array();

        if (count($this->_currentMessages['info'])) {
            $messages['info'] = $this->_currentMessages['info'];
        }
        $this->_flashMessenger->setNamespace('info');
        if ($this->_flashMessenger->hasMessages()) {
            $messages['info'] = $this->_flashMessenger->getMessages();
        }

        if (count($this->_currentMessages['error'])) {
            $messages['error'] = $this->_currentMessages['error'];
        }
        $this->_flashMessenger->setNamespace('error');
        if ($this->_flashMessenger->hasMessages()) {
            $messages['error'] = $this->_flashMessenger->getMessages();
        }

        if (count($messages)) {
            $this->_xmlSerializer->setOption(XML_SERIALIZER_OPTION_ROOT_NAME, 'messages');
            $this->_xmlSerializer->serialize($messages);

            $fragment = $this->view->dom->createDocumentFragment();
            $fragment->appendXML($this->_xmlSerializer->getSerializedData());

            $this->view->dom->appendChild($fragment);
        }
    }

    function simplexmlAppend(SimpleXMLElement $parent, SimpleXMLElement $new_child){
        $node1 = dom_import_simplexml($parent);
        $dom_sxe = dom_import_simplexml($new_child);
        $node2 = $node1->ownerDocument->importNode($dom_sxe, true);
        $node1->appendChild($node2);
    }

    function tryCache($cacheName, $lifetime) {
        Zend_Loader::loadClass('Zend_Cache');

        $frontendOptions = array(
            'lifetime' => $lifetime,
            'automatic_serialization' => true,
        );

        $backendOptions = array(
            'cache_dir' => Zend_Registry::get('config')->cacheDir, // directory for storing the cache files
        );

        try {
            $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        } catch (Zend_Cache_Exception $e) {
            echo "Exception caught creating cache: {$e->getMessage()}\n";
            exit();
        }

        return $cache->load($cacheName);
    }

    function saveCache($data, $cacheName, $lifetime) {
        Zend_Loader::loadClass('Zend_Cache');

        $frontendOptions = array(
            'lifetime' => $lifetime,
            'automatic_serialization' => true,
        );

        $backendOptions = array(
            'cache_dir' => Zend_Registry::get('config')->cacheDir, // directory for storing the cache files
        );

        try {
            $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        } catch (Zend_Cache_Exception $e) {
            echo "Exception caught creating cache: {$e->getMessage()}\n";
            exit();
        }

        $cache->save($data, $cacheName);

        // for some reason, $data gets corrupted when we save, so load it after saving
        return $cache->load($cacheName);
    }
}
