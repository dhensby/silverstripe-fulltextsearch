<?php

class RealSolrTest extends SapphireTest {

    protected $usesDatabase = true;

    protected static $fixture_file = 'RealSolrTest.yml';

    public function setUpOnce() {
        parent::setUpOnce();
        Solr::configure_server(array(
            'host' => defined('SOLR_SERVER') ? SOLR_SERVER : 'localhost',
            'port' => defined('SOLR_PORT') ? SOLR_PORT : 8983,
            'path' => defined('SOLR_PATH') ? SOLR_PATH : '/solr/',
            'version' => defined('SOLR_VERSION') ? SOLR_VERSION : 3,

            'indexstore' => array(
                'mode' => defined('SOLR_MODE') ? SOLR_MODE : 'file',
                'auth' => defined('SOLR_AUTH') ? SOLR_AUTH : null,

                // Allow storing the solr index and config data in an arbitrary location,
                // e.g. outside of the webroot
                'path' => defined('SOLR_INDEXSTORE_PATH') ? SOLR_INDEXSTORE_PATH : BASE_PATH . '/.solr',
                'remotepath' => defined('SOLR_REMOTE_PATH') ? SOLR_REMOTE_PATH : null
            )
        ));

        Config::inst()->update('FullTextSearch', 'indexes', array('RealSolrTest_Index'));

        $configureService = new Solr_Configure();
        $configureService->run(new SS_HTTPRequest('GET', 'dev/tasks/Solr_Configure'));
    }

    public function testIndex() {
        $this->pass();
    }

}

class RealSolrTest_Index extends SolrIndex {

    public function init() {
        $this->addClass('Page');
        $this->addAllFulltextFields();
    }

}
