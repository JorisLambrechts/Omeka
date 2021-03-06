<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2009
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 */

/**
 * Retrieve the list of all available metadata for a specific file.
 *
 * @package Omeka
 * @copyright Roy Rosenzweig Center for History and New Media, 2009
 */
class Omeka_View_Helper_FileMetadataList extends Omeka_View_Helper_RecordMetadataList
{
    const MIME_TYPE_SET_NAME = 'MIME Type Metadata';

    /**
     * Because of some quirks in the schema, we can't count on these to be
     * retrieved correctly for files.
     *
     * @var array
     */
    protected $_fileMimeTypeElementSets = array('Omeka Image File', 'Omeka Video File');

    public function fileMetadataList(File $file, array $options = array())
    {
        return $this->recordMetadataList($file, $options);
    }

    protected function _getElementsBySet()
    {
        $elementsBySet = parent::_getElementsBySet();

        // Don't display Omeka Image File or Omeka Video File sets by themselves.
        $elementsBySet = array_diff_key($elementsBySet, array_flip($this->_fileMimeTypeElementSets));

        // Add in a special 'MIME Type' metadata element set.
        // @todo Come up with a better name for this.
        $elementsBySet[self::MIME_TYPE_SET_NAME] = $this->_record->getMimeTypeElements();

        return $elementsBySet;
    }
}
