<?php
/** BaseController */
Zend_Loader::loadClass('BaseController');

class SearchController extends BaseController
{

    public function indexAction()
    {
        Zend_Loader::loadClass('Zend_Filter_Input');
        Zend_Loader::loadClass('Zend_Cache');

        // Filter and validate our input
        $filters = array(
            'query' => array(
                'StringTrim',
                'StripTags',
            ),
        );
        $validators = array(
            'query' => array(
                'presence' => 'required',
                'NotEmpty',
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        $redirector = $this->_helper->getHelper('Redirector');
        $redirector->goto('search', 'search', null, array('query' => $input->getUnescaped('query')));
    }

    public function searchAction()
    {
        Zend_Loader::loadClass('Zend_Filter_Input');
        Zend_Loader::loadClass('Zend_Cache');

        $dom = &$this->view->dom;

        // Filter and validate our input
        $filters = array(
            'query' => array(
                'StringTrim',
                'StripTags',
            ),
            'page'      => 'Digits',
        );
        $validators = array(
            'query' => array(
                'presence' => 'required',
                'NotEmpty',
            ),
            'page' => array(
                'Digits',
                array('GreaterThan', 0),
                'default' => 1,
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            $usingCache = true;
            $cacheName  = 'googleSearch_' . preg_replace('/[^a-zA-Z0-9\_]/', '_', str_replace(' ', '_', strtolower($input->query))) . '_page' . $input->page;
            $cacheLife  = 1200; // cache lifetime of 20 minutes

            if (!$searchResults = $this->tryCache($cacheName, $cacheLife)) {
                // cache miss
                Zend_Loader::loadClass('RRP_Google_Search');
                $usingCache = false;

                $resultsPerPage = Zend_Registry::get('config')->search->google->resultsPerPage;

                $start = ($input->page - 1) * $resultsPerPage;

                $googleSearch = new RRP_Google_Search(
                    Zend_Registry::get('config')->search->google->key,
                    Zend_Registry::get('config')->search->google->site
                );

                if (!$googleSearch->search($input->getUnescaped('query'), null, $start, $resultsPerPage, $searchResults))
                    $this->_currentMessages['error']['searchFailed'] = array('searchFailed' => "Sorry, connection to Google failed after retrying {$googleSearch->attempts} times.");
                else
                    $searchResults = $this->saveCache($searchResults, $cacheName, $cacheLife);
            }

            if ($searchResults->endIndex) {
                $domSearchResults = $dom->createElement('searchResults');

                // list results
                foreach($searchResults->resultElements as $result) {
                    $domResult = $dom->createElement('result');

                    // Make URLs more friendly for user by removing http:// and highlighting where necessary
                    $result->URL    = str_replace('&', '&amp;', str_replace('&amp;', '&', $result->URL));
                    $friendlyUrl    = $result->URL;
                    $friendlyUrl    = str_replace("http://", "", $friendlyUrl);
                    //$friendlyUrl    = str_replace($input->query, "<strong>{$input->query}</strong>", $friendlyUrl);

                    /*
                    if ($result->snippet)
                        $result->snippet = preg_replace('/&amp;(\#?[0-9]+|[a-z]+);/', '&$1;', str_replace('&', '&amp;', $result->snippet) );
                    */

                    $title = $dom->createElement('title');
                    $titleCdata = $dom->createCDATASection($result->title);
                    $title->appendChild($titleCdata);
                    $domResult->appendChild($title);
                    $domResult->appendChild($dom->createElement('url', $result->URL));
                    $snippet = $dom->createElement('snippet');
                    $snippetCdata = $dom->createCDATASection(strip_tags($result->snippet, '<b>'));
                    $snippet->appendChild($snippetCdata);
                    $domResult->appendChild($snippet);
                    $domResult->appendChild($dom->createElement('cachedSize', $result->cachedSize));
                    $domSearchResults->appendChild($domResult);
                }

                $this->view->dom->appendChild($domSearchResults);
            }

            $this->view->query          = $input->getUnescaped('query');
            $this->view->resultsCount   = $searchResults->estimatedTotalResultsCount;
            $this->view->searchTime     = $usingCache ? 'cached' : round($searchResults->searchTime, 2);
            $this->view->startIndex     = $searchResults->startIndex;
            $this->view->endIndex       = $searchResults->endIndex;
            $this->view->page           = $input->page;
        }
    }
}