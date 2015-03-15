<?php
/*
 * Copyright (c) 2015 GOTO Hidenori <hidenorigoto@gmail.com>,
 * All rights reserved.
 *
 * This file is part of CodeMetamodel-PHP.
 *
 * This program and the accompanying materials are made available under
 * the terms of the BSD 2-Clause License which accompanies this
 * distribution, and is available at http://opensource.org/licenses/BSD-2-Clause
 */

namespace DomainCoder\Metamodel\Code\Parser;

use DomainCoder\Metamodel\Code\Element\Annotation;
use DomainCoder\Metamodel\Code\Element\Annotation\AnnotationFactory;
use DomainCoder\Metamodel\Code\Element\ClassModel;
use DomainCoder\Metamodel\Code\Element\Property;
use DomainCoder\Metamodel\Code\Element\Reference\ReferenceFactory;
use DomainCoder\Metamodel\Code\Util\Model;

class PropertyAnnotationsParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationsParser
     */
    public $annotationsParser;

    /**
     * @var PropertyAnnotationsParser
     */
    private $parser;

    /**
     * @var AnnotationFactory
     */
    private $annotationFactory;

    /**
     * @var ReferenceFactory
     */
    private $referenceFactory;

    /**
     * @var ClassModel
     */
    private $class;

    /**
     * @var Property
     */
    private $property;

    /**
     * @var CommentsParser
     */
    private $commentsParser;

    /**
     * @var CommentFilter
     */
    private $commentFilter;

    protected function setUp()
    {
        $model = new Model();
        $this->commentFilter = new CommentFilter();
        $this->annotationFactory = new AnnotationFactory();
        $this->referenceFactory = \Phake::mock(ReferenceFactory::class);
        $this->annotationsParser = \Phake::mock(AnnotationsParser::class);
        $this->commentsParser = \Phake::mock(CommentsParser::class);

        $this->class = new ClassModel('test', 'test');
        $this->property = new Property('test', 'test', null, null, $this->class);

        $this->parser = new PropertyAnnotationsParser(
            $model,
            $this->referenceFactory,
            $this->commentsParser
        );
    }

    /**
     * @test
     */
    public function parseNormal()
    {
        \Phake::when($this->commentsParser)->parse(\Phake::anyParameters())->thenReturn(null);

        $stmts = include __DIR__.'/../fixtures/1/Model/Product.php.property_base.cache';

        $this->parser->parse($stmts, $this->property, $this->class);

        \Phake::verify($this->commentsParser)->parse(\Phake::anyParameters());
    }
}
