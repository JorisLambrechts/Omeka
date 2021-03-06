<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 * @access private
 */
 
/**
 * Generates the omeka-xml output for a collection.
 *
 * @internal This implements Omeka internals and is not part of the public API.
 * @access private
 * @package Omeka
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 */
class Output_CollectionOmekaXml extends Omeka_Output_OmekaXml_AbstractOmekaXml
{
    /**
     * Create a node representing a collection.
     *
     * @return void
     */
    protected function _buildNode()
    {
        // collection
        $collectionElement = $this->_createElement('collection', null, $this->_record->id);
        
        $collectionElement->setAttribute('public', $this->_record->public);
        $collectionElement->setAttribute('featured', $this->_record->featured);
        
        $this->_buildItemContainerForCollection($this->_record, $collectionElement);
        
        $this->_node = $collectionElement;
    }
}
