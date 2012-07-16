<?php
/**
 * File containing the ContentTypeServiceTest class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\API\REST\Common\Tests\Output;

use eZ\Publish\API\REST\Common;

/**
 * Test dummy class
 */
class ValueObject extends \stdClass
{
}

/**
 * Test case for operations in the ContentTypeService using in memory storage.
 *
 * @see eZ\Publish\API\Repository\ContentTypeService
 * @group integration
 */
class VisitorTest extends \PHPUnit_Framework_TestCase
{
    public function testVisitDocument()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $generator
            ->expects( $this->at( 1 ) )
            ->method( 'startDocument' )
            ->with( $data );

        $generator
            ->expects( $this->at( 2 ) )
            ->method( 'endDocument' )
            ->with( $data )
            ->will( $this->returnValue( 'Hello world!' ) );

        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );

        $this->assertEquals(
            new Common\Message( array(), 'Hello world!' ),
            $visitor->visit( $data )
        );
    }

    public function testVisitValueObject()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );

        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );
        $visitor
            ->expects( $this->at( 0 ) )
            ->method( 'visitValueObject' )
            ->with( $data );

        $this->assertEquals(
            new Common\Message( array(), null ),
            $visitor->visit( $data )
        );
    }

    public function testSetHeaders()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );

        $visitor->setHeader( 'Content-Type', 'text/xml' );
        $this->assertEquals(
            new Common\Message( array(
                    'Content-Type' => 'text/xml',
                ),
                null
            ),
            $visitor->visit( $data )
        );
    }

    public function testSetHeadersNoOverwrite()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );

        $visitor->setHeader( 'Content-Type', 'text/xml' );
        $visitor->setHeader( 'Content-Type', 'text/html' );
        $this->assertEquals(
            new Common\Message( array(
                    'Content-Type' => 'text/xml',
                ),
                null
            ),
            $visitor->visit( $data )
        );
    }

    public function testSetHeaderResetAfterVisit()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );

        $visitor->setHeader( 'Content-Type', 'text/xml' );

        $visitor->visit( $data );
        $result = $visitor->visit( $data );

        $this->assertEquals(
            new Common\Message(
                array(),
                null
            ),
            $result
        );
    }

    public function testSetStatusCode()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );

        $visitor->setStatus( 201 );
        $this->assertEquals(
            new Common\Message( array(
                    'Status' => '201 Created',
                ),
                null
            ),
            $visitor->visit( $data )
        );
    }

    public function testSetUnknownStatusCode()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );

        $visitor->setStatus( 2342 );
        $this->assertEquals(
            new Common\Message( array(
                    'Status' => '2342 Unknown',
                ),
                null
            ),
            $visitor->visit( $data )
        );
    }

    public function testSetStatusCodeNoOverride()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = $this->getMock(
            '\\eZ\\Publish\\API\\REST\\Common\\Output\\Visitor',
            array( 'visitValueObject' ),
            array( $generator, array() )
        );

        $visitor->setStatus( 201 );
        $visitor->setStatus( 404 );

        $this->assertEquals(
            new Common\Message( array(
                    'Status' => '201 Created',
                ),
                null
            ),
            $visitor->visit( $data )
        );
    }

    /**
     * @expectedException \eZ\Publish\API\REST\Common\Output\Exceptions\InvalidTypeException
     */
    public function testVisitValueObjectInvalidType()
    {
        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = new Common\Output\Visitor( $generator, array() );

        $visitor->visitValueObject( 42 );
    }

    /**
     * @expectedException \eZ\Publish\API\REST\Common\Output\Exceptions\NoVisitorFoundException
     */
    public function testVisitValueObjectNoMatch()
    {
        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $visitor = new Common\Output\Visitor( $generator, array() );

        $data = new \stdClass();
        $visitor->visitValueObject( $data );
    }

    public function testVisitValueObjectDirectMatch()
    {
        $data = new \stdClass();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $valueObjectVisior = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\ValueObjectVisitor', array(), array(), '', false );

        $visitor = new Common\Output\Visitor( $generator, array(
            '\\stdClass' => $valueObjectVisior,
        ) );

        $valueObjectVisior
            ->expects( $this->at( 0 ) )
            ->method( 'visit' )
            ->with( $visitor, $generator, $data );

        $visitor->visitValueObject( $data );
    }

    public function testVisitValueObjectParentMatch()
    {
        $data = new ValueObject();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $valueObjectVisior = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\ValueObjectVisitor', array(), array(), '', false );

        $visitor = new Common\Output\Visitor( $generator, array(
            '\\stdClass' => $valueObjectVisior,
        ) );

        $valueObjectVisior
            ->expects( $this->at( 0 ) )
            ->method( 'visit' )
            ->with( $visitor, $generator, $data );

        $visitor->visitValueObject( $data );
    }

    public function testVisitValueObjectSecondRuleParentMatch()
    {
        $data = new ValueObject();

        $generator = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\Generator' );
        $valueObjectVisior1 = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\ValueObjectVisitor', array(), array(), '', false );
        $valueObjectVisior2 = $this->getMock( '\\eZ\\Publish\\API\\REST\\Common\\Output\\ValueObjectVisitor', array(), array(), '', false );

        $visitor = new Common\Output\Visitor( $generator, array(
            '\\WontMatch' => $valueObjectVisior1,
            '\\stdClass'  => $valueObjectVisior2,
        ) );

        $valueObjectVisior1
            ->expects( $this->never() )
            ->method( 'visit' );

        $valueObjectVisior2
            ->expects( $this->at( 0 ) )
            ->method( 'visit' )
            ->with( $visitor, $generator, $data );

        $visitor->visitValueObject( $data );
    }
}

