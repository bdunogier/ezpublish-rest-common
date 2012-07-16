<?php
/**
 * File containing the XML generator class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\API\REST\Common\Output\Generator;
use eZ\Publish\API\REST\Common\Output\Generator;

/**
 * Xml generator
 */
class Xml extends Generator
{
    /**
     * XMLWriter
     *
     * @var \XMLWriter
     */
    protected $xmlWriter;

    /**
     * Start document
     *
     * @param mixed $data
     */
    public function startDocument( $data )
    {
        $this->checkStartDocument( $data );

        $this->xmlWriter = new \XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->setIndent( true );
        $this->xmlWriter->startDocument( '1.0', 'UTF-8' );
    }

    /**
     * End document
     *
     * Returns the generated document as a string.
     *
     * @param mixed $data
     * @return string
     */
    public function endDocument( $data )
    {
        $this->checkEndDocument( $data );

        $this->xmlWriter->endDocument();
        return $this->xmlWriter->outputMemory();
    }

    /**
     * Start element
     *
     * @param string $name
     * @param string $mediaTypeName
     */
    public function startElement( $name, $mediaTypeName = null )
    {
        $this->checkStartElement( $name );

        $mediaTypeName = $mediaTypeName ?: $name;

        $this->xmlWriter->startElement( $name );

        $this->startAttribute( "media-type", $this->getMediaType( $mediaTypeName ) );
        $this->endAttribute( "media-type" );
    }

    /**
     * End element
     *
     * @param string $name
     */
    public function endElement( $name )
    {
        $this->checkEndElement( $name );

        $this->xmlWriter->endElement();
    }

    /**
     * Start value element
     *
     * @param string $name
     * @param string $value
     */
    public function startValueElement( $name, $value )
    {
        $this->checkStartValueElement( $name );

        $this->xmlWriter->startElement( $name );
        $this->xmlWriter->text( $value );
    }

    /**
     * End value element
     *
     * @param string $name
     */
    public function endValueElement( $name )
    {
        $this->checkEndValueElement( $name );

        $this->xmlWriter->endElement();
    }

    /**
     * Start list
     *
     * @param string $name
     */
    public function startList( $name )
    {
        $this->checkStartList( $name );
    }

    /**
     * End list
     *
     * @param string $name
     */
    public function endList( $name )
    {
        $this->checkEndList( $name );
    }

    /**
     * Start attribute
     *
     * @param string $name
     * @param string $value
     */
    public function startAttribute( $name, $value )
    {
        $this->checkStartAttribute( $name );

        $this->xmlWriter->startAttribute( $name );
        $this->xmlWriter->text( $value );
    }

    /**
     * End attribute
     *
     * @param string $name
     */
    public function endAttribute( $name )
    {
        $this->checkEndAttribute( $name );

        $this->xmlWriter->endAttribute();
    }

    /**
     * Get media type
     *
     * @param string $name
     * @return string
     */
    public function getMediaType( $name )
    {
        return $this->generateMediaType( $name, 'xml' );
    }
}

