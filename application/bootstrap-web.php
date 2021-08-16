<?php
try {
    // get/set the global configuration
    require_once (dirname(__FILE__) . '/global.php');

    Zend_Loader::loadClass('Zend_Cache');

            /*
            '^/$' => array('cache' => true),         // cache the whole IndexController
            '^/index/' => array('cache' => true),    // cache the whole IndexController
            '^/article/' => array('cache' => false), // we don't cache the ArticleController...
            '^/article/view/' => array(              // ...but we cache the "view" action of
                'cache' => true,                     // this ArticleController
                'cache_with_post_variables' => true,    // and we cache even there are some variables in $_POST
                'make_id_with_post_variables' => true,   // (but the cache will be dependent of the $_POST array)
            )
            */

    $frontendOptions = array(
        'lifetime' => 1800,
        'debug_header' => false,
    		'default_options' => array(
    			'cache' => true,
    			'cache_with_get_variables' => true,
    			'cache_with_post_variables' => true,
    			'cache_with_session_variables' => true,
    			'cache_with_files_variables' => true,
    			'cache_with_cookie_variables' => true,
    			'make_id_with_get_variables' => true,
    			'make_id_with_post_variables' => true,
    			'make_id_with_session_variables' => false,
    			'make_id_with_files_variables' => true,
    			'make_id_with_cookie_variables' => false,
    		),
        'regexps' => array(
            '^/error/' => array('cache' => false),
            '^/$' => array('cache' => true),         // cache the whole IndexController
            '^/index/' => array('cache' => true),    // cache the whole IndexController
            '^/blog/' => array('cache' => true),
            '^/photos/' => array('cache' => true),
            '^/music/' => array('cache' => false),
            '^/music/cover/' => array('cache' => false),
            '^/extras/' => array('cache' => false),
            '^/htpc/' => array('cache' => true),
            '^/network/' => array('cache' => true),
            '^/search/' => array('cache' => false),
            '^/contact/' => array('cache' => false),
            '^/login/' => array('cache' => false),
            '^/test/' => array('cache' => false),
        )
    );

    $backendOptions = array(
        'cache_dir' => Zend_Registry::get('config')->cacheDir, // directory for storing the cache files
    );

    // getting a Zend_Cache_Frontend_Page object
    $cache = Zend_Cache::factory('Page', 'File', $frontendOptions, $backendOptions);

    //$cache->start();
    // if the cache is hit, the result is sent to the browser and the script stop here

    // // some more requirements for the web
    Zend_Loader::loadClass('Zend_Session');
    Zend_Loader::loadClass('Zend_Controller_Action_Helper_ViewRenderer');
    Zend_Loader::loadClass('RRP_Zend_View_XSLT');

    // start the session
    Zend_Session::start();
    $session = new Zend_Session_Namespace();

    // set the default user locale within the session
    if (!isset($session->locale)) {
        Zend_Loader::loadClass('Zend_Locale');
        echo $config->locale->defaultLocale;
        $session->locale = new Zend_Locale($config->locale->defaultLocale);
    }
    Zend_Locale_Format::setOptions(array('locale' => $session->locale));

    // create the string translation object
    $translate = new Zend_Translate('tmx', dirname(__FILE__) . '/' . $config->locale->tmxLanguagesFile, 'en'); //$session->locale);
    Zend_Registry::set('translate', $translate);

    // use XSLT for our 'views'
    $view = new RRP_Zend_View_XSLT();
    $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
    $viewRenderer->setViewSuffix('xsl');
    Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

    // finally, create the Front controller and dispatch the request
    $front = Zend_Controller_Front::getInstance();
    $front->setControllerDirectory('../application/controllers');
    $front->dispatch();
} catch (Exception $exp) {
    header("Content-type: text/html; charset=utf-8");
    echo '<h2>An unexpected error occurred.</h2>';
    echo 'Unexpected Exception: ' . $exp->getMessage() . '<br/>';
    echo '<pre>' . $exp->getTraceAsString() . '</pre>';
}

