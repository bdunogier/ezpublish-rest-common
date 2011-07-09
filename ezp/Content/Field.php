<?php
/**
 * File containing the ezp\Content\Field class.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 * @package ezp
 * @subpackage content
 */

/**
 * This class represents a Content's field
 *
 * @package ezp
 * @subpackage content
 */
namespace ezp\Content;
class Field extends AbstractField
{
    /**
     * @var array Readable of properties on this object
     */
    protected $readableProperties = array(
        'id' => false,
        'data_text' => false,
        'data_int' => false,
        'data_float' => false,
        'fieldTypeString' => true,
    );

    /**
     * @var array Dynamic properties on this object
     */
    protected $dynamicProperties = array(
        'type' => true,
        'version' => false,
        'contentTypeField' => false,
    );

    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var int
     */
    protected $contentId = 0;

    /**
     * @var string
     */
    protected $data_text = '';

    /**
     * @var int
     */
    protected $data_int = 0;

    /**
     * @var float
     */
    protected $data_float = 0.0;

    /**
     * @var string
     */
    protected $languageCode = '';

    /**
     * @var string
     */
    protected $fieldTypeString = '';

    /**
     * @var int
     */
    //protected $contentobject_id = 0;

    /**
     * @var Version
     */
    protected $version;

    /**
     * Return content version object
     *
     * @return Version
     */
    protected function getVersion()
    {
        return $this->version;
    }

    /**
     * @var type\Field
     */
    protected $contentTypeField;

    /**
     * Return content type object
     *
     * @return type\Field
     */
    protected function getContentTypeField()
    {
        return $this->contentTypeField;
    }

    /**
     * Constructor, sets up properties
     *
     * @param Version $contentVersion
     * @param type\Field $contentTypeField
     */
    public function __construct( Version $contentVersion, type\Field $contentTypeField )
    {
        $this->version = $contentVersion;
        $this->contentTypeField = $contentTypeField;
        $this->fieldTypeString = $contentTypeField->fieldTypeString;
    }

    /**
     * Initialize field type class
     *
     * @throws \RuntimeException If $className is not instanceof Abstracts\FieldType
     * @param string $className
     * @return Abstracts\FieldType
     */
    protected function initType( $className )
    {
        $type = new $className( $this->getContentTypeField()->getType() );
        if ( !$type instanceof AbstractFieldType )
            throw new \RuntimeException( "Field type value '{$className}' does not implement ezp\\Content\\AbstractFieldType" );
        if ( $this->version )
            $this->toType( $type );
        else
            $this->fromType( $type );
        return $type;
    }

    /**
     * Called when subject has been updated
     *
     * @param \ezp\Base\Interfaces\Observable $subject
     * @param string $event
     * @return ContentField
     */
    public function update( \ezp\Base\Interfaces\Observable $subject, $event = 'update' )
    {
        if ( $subject instanceof Version )
        {
            return $this->notify( $event );
        }
        return parent::update( $subject, $event );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return  $this->fieldTypeString;
    }
}
?>