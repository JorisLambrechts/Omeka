<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 */

/**
 * 
 *
 * @package Omeka
 * @copyright Center for History and New Media, 2007-2010
 */
class Omeka_Test_Resource_DbTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->app = new Zend_Application('foobar');
        $this->bootstrap = new Zend_Application_Bootstrap_Bootstrap($this->app);
        // This is something crazy that we need so that the bootstrap can resolve
        // plugin resource names from class names.
        $this->bootstrap->setOptions(array(
            'pluginpaths' => 
                array('Omeka_Test_Resource' => 'Omeka/Test/Resource')
        ));
        $this->configResource = new Omeka_Test_Resource_Config();
        $this->bootstrap->registerPluginResource($this->configResource);
        $this->dbResource = new Omeka_Test_Resource_Db();
        $this->bootstrap->registerPluginResource($this->dbResource);
    }
        
    public function testSetsAdapterParamsFromTestConfig()
    {        
        $this->db = $this->dbResource->init();
        $this->assertThat($this->db, $this->isInstanceOf('Omeka_Db'));
        
        $this->assertTrue(Zend_Registry::isRegistered('test_config'),
            "There should be a registry entry called 'test_config'.");
        $testConfig = Zend_Registry::get('test_config');
        $dbConfig = $this->db->getAdapter()->getConfig();        
        $this->assertEquals($testConfig->db->username, $dbConfig['username']);
        $this->assertEquals($testConfig->db->password, $dbConfig['password']);
        $this->assertEquals($testConfig->db->dbname,   $dbConfig['dbname']);
        $this->assertEquals($testConfig->db->host,     $dbConfig['host']);
    }
        
    public function testCanDisableInstallation()
    {
        $this->dbResource->setInstall(false);
        $this->db = $this->dbResource->init();
        $this->assertEquals(array(),
                            $this->db->fetchAll("SHOW TABLES"),
                            "No tables should have been created.");
    }
    
    public function testWipesAllTablesWithPrefix()
    {
        $this->bootstrap->bootstrap('Config');
        $this->dbResource->useTestConfig();
        $this->db = $this->dbResource->getDb();
        $this->db->query("CREATE TABLE `{$this->db->prefix}foobar` (`id` int(11))");
        $this->assertNotEquals(array(),
                               $this->db->fetchAll("SHOW TABLES LIKE '{$this->db->prefix}foobar'"),
                               "There should be a '{$this->db->prefix}foobar' table in the database.");
        $this->db = $this->dbResource->init();
        $this->assertEquals(array(),
                            $this->db->fetchAll("SHOW TABLES LIKE '{$this->db->prefix}foobar'"),
                            "The '{$this->db->prefix}foobar' table should have been wiped during resource initialization.");
    }
    
    public function testInstallsOmekaDatabase()
    {
        $db = $this->dbResource->init();
        $rawData = $db->fetchAll("SHOW TABLES");
        $actualTables = array();
        foreach ($rawData as $segment) {
            $actualTables[] = current($segment);
        }
        $expectedTables = array(
          'omeka_collections',
          'omeka_data_types',
          'omeka_element_sets',
          'omeka_element_texts',
          'omeka_elements',
          'omeka_entities',
          'omeka_entities_relations',
          'omeka_entity_relationships',
          'omeka_files',
          'omeka_item_types',
          'omeka_item_types_elements',
          'omeka_items',
          'omeka_mime_element_set_lookup',
          'omeka_options',
          'omeka_plugins',
          'omeka_processes',
          'omeka_record_types',
          'omeka_schema_migrations',
          'omeka_taggings',
          'omeka_tags',
          'omeka_users',
          'omeka_users_activations',
        );
        $this->assertEquals($expectedTables, $actualTables);
    }
    
    public function tearDown()
    {
        if (isset($this->db)) {
            $dbHelper = new Omeka_Test_DbHelper($this->db->getAdapter());
        } else if (isset($this->dbAdapter)) {
            $dbHelper = new Omeka_Test_DbHelper($this->dbAdapter);
        }
        if (isset($dbHelper)) {
            $dbHelper->dropTables();
        }
    }
}
