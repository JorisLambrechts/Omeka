<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 * @access private
 */

/**
 * An application resource for class autoloaders.
 *
 * Autoloading is also currently handled by Zend_Loader_Autoloader's fallback loader.
 *
 * @internal This implements Omeka internals and is not part of the public API.
 * @access private
 * @package Omeka
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 */
class Omeka_Application_Resource_Autoloader extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Register autoloaders. 
     *
     * Set up autoloading of the following class types from the following
     * directories:
     * - {@link Omeka_Form}: forms/
     *
     * @todo [2.0] Add a namespace for models (Omeka_File or Omeka_Model_File?)
     * @return void
     */
    public function init()
    {
        new Zend_Loader_Autoloader_Resource(array(
            'basePath' => APP_DIR, 
            'namespace' => 'Omeka', 
            'resourceTypes' => array(
                'form' => array(
                    'path' => 'forms/', 
                    'namespace' => 'Form', 
                ),
                'view_helper' => array(
                    'path' => 'views/helpers', 
                    'namespace' => 'View_Helper', 
                ), 
                'action_helper' => array(
                    'path' => 'controllers/helpers', 
                    'namespace' => 'Controller_Action_Helper', 
                ), 
            )
        ));
    }
}
