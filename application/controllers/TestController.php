<?php
/** BaseController */
Zend_Loader::loadClass('BaseController');

class TestController extends BaseController
{

    public function feedAction()
    {
        Zend_Loader::loadClass('Zend_Feed_Rss');
        Zend_Loader::loadClass('Zend_Cache');

        $cacheName = 'myGamespotBlogFeed';
        $cacheLife = 1200; // cache lifetime of 20 minutes
        $feedUrl   = 'http://rss.gamespot.com/' . Zend_Registry::get('config')->blogs->gamespot->username . '/blog_contributions.xml';

        if (!$feedXml = $this->tryCache($cacheName, $cacheLife)) {
            // cache miss
            try {
                $feed = new Zend_Feed_Rss($feedUrl);
            } catch (Zend_Feed_Exception $e) {
                echo "Exception caught importing feed: {$e->getMessage()}\n";
                exit();
            }

            $feedXml = "<$cacheName>" . $feed->saveXmlFragment() . "</$cacheName>";
            $feedXml = $this->saveCache($feedXml, $cacheName, $cacheLife);
        }

        $this->view->xml .= $feedXml;
        //Zend_Debug::dump($this->view->xml);
    }

    public function blogAction()
    {
        Zend_Loader::loadClass('Zend_Gdata');
        Zend_Loader::loadClass('Zend_Gdata_Query');
        Zend_Loader::loadClass('Zend_Cache');

        $cacheName = 'myBloggerBlog';
        $cacheLife = 1200; // cache lifetime of 20 minutes

        $gdClient = new Zend_Gdata();


//        $query = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . Zend_Registry::get('config')->blogger->userId . '/blogs');
//        $feed = $gdClient->getFeed($query);

        $query = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . Zend_Registry::get('config')->blogger->conduitBlogId . '/posts/default');
        $conduit = $gdClient->getFeed($query);

        //Zend_Debug::dump($feed);

        $this->printFeed($conduit);
        exit();

/*
        if (!$feed = $cache->load($cacheName)) {
            // cache miss
            try {
                $feed = new Zend_Feed_Rss($feedUrl);
            } catch (Zend_Feed_Exception $e) {
                echo "Exception caught importing feed: {$e->getMessage()}\n";
                exit();
            }
            $cache->save($feed, $cacheName);
            // for some reason, $feed gets corrupted when we save, so load it after saving
            $feed = $cache->load($cacheName);
        }

        $this->view->xml .= "<$cacheName>" . $feed->saveXmlFragment() . "</$cacheName>";
        //Zend_Debug::dump($this->view->xml);
*/
    }

    public function printFeed($feed)
    {
        $i = 0;
        foreach($feed->entries as $entry) {
            $idText = split('-', $entry->id->text);
            $blogId = $idText[2];
            echo $i .' ' . $blogId . ' ' . $entry->title->text . '<br/>';
            echo $entry->content->text . '<br/><br/>';
            $i++;
        }
    }

    public function cacheAction()
    {
        $number = rand(1,10);
        $this->view->number = $number;
    }
}
