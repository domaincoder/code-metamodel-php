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

use DomainCoder\Metamodel\Code\Element\Annotation\AnnotationFactory;
use DomainCoder\Metamodel\Code\Element\ClassModel;
use DomainCoder\Metamodel\Code\Element\ClassModel\ClassFactory;
use DomainCoder\Metamodel\Code\Util\Model;

class ClassParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClassParser
     */
    private $parser;

    /**
     * @var ClassFactory
     */
    private $classFactory;

    /**
     * @var AnnotationFactory
     */
    private $annotationFactory;

    /**
     * @var AnnotationsParser
     */
    private $annotationsParser;

    /**
     * @var PropertyAnnotationsParser
     */
    private $propertyAnnotationParser;

    /**
     * @var PropertyParser
     */
    private $propertyParser;

    /**
     * @var MethodParser
     */
    private $methodParser;

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
        $this->classFactory = new ClassFactory($model);
        $this->commentFilter = new CommentFilter();
        $this->annotationFactory = \Phake::mock(AnnotationFactory::class);
        $this->annotationsParser = \Phake::mock(AnnotationsParser::class);
        $this->propertyAnnotationParser = \Phake::mock(PropertyAnnotationsParser::class);
        $this->propertyParser = \Phake::mock(PropertyParser::class);
        $this->methodParser = \Phake::mock(MethodParser::class);
        $this->commentsParser = new CommentsParser($this->annotationsParser, $this->annotationFactory, $this->commentFilter);

        $this->parser = new ClassParser(
            $this->classFactory,
            $this->propertyAnnotationParser,
            $this->propertyParser,
            $this->methodParser,
            $this->commentsParser
        );
    }

    /**
     * @test
     */
    public function parseNormal()
    {
        \Phake::when($this->annotationsParser)->parse(\Phake::anyParameters())->thenReturn([]);

        $stmts = include __DIR__.'/../fixtures/1/Model/Product.php.class.cache';

        $class = $this->parser->parse($stmts, '', '');

        $this->assertThat($class, $this->isInstanceOf(ClassModel::class));
        $this->assertThat($class->name, $this->equalTo('Product'));
    }

    /**
     * @test
     */
    public function parseClassComment()
    {
        \Phake::when($this->annotationsParser)->parse(\Phake::anyParameters())->thenReturn([]);

        $stmts = include __DIR__.'/../fixtures/1/Model/Product.php.class.cache';

        $class = $this->parser->parse($stmts, '', '');

        $this->assertThat($class->comment, $this->equalTo('商品エンティティ'));
    }
}
