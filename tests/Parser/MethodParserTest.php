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
use DomainCoder\Metamodel\Code\Element\Method;
use DomainCoder\Metamodel\Code\Element\Method\MethodFactory;
use DomainCoder\Metamodel\Code\Util\Model;

class MethodParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommentFilter
     */
    private $commentFilter;

    /**
     * @var CommentsParser
     */
    private $commentsParser;

    /**
     * @var MethodParser
     */
    private $parser;

    /**
     * @var ClassModel
     */
    private $class;

    /**
     * @var MethodFactory
     */
    private $methodFactory;

    /**
     * @var AnnotationFactory
     */
    private $annotationFactory;

    /**
     * @var AnnotationsParser
     */
    private $annotationsParser;

    protected function setUp()
    {
        $model = new Model();
        $this->methodFactory = new MethodFactory($model);
        $this->class = new ClassModel('test', 'test');

        $this->commentFilter = new CommentFilter();
        $this->annotationsParser = \Phake::mock(AnnotationsParser::class);
        $this->annotationFactory = \Phake::mock(AnnotationFactory::class);
        $this->commentsParser = new CommentsParser($this->annotationsParser, $this->annotationFactory, $this->commentFilter);

        $this->parser = new MethodParser(
            $this->methodFactory,
            $this->commentsParser,
            $this->commentFilter
        );
    }

    /**
     * @test
     */
    public function parseNormal()
    {
        \Phake::when($this->annotationsParser)->parse(\Phake::anyParameters())->thenReturn([]);
        $stmts = include __DIR__.'/../fixtures/1/Model/Product.php.method.cache';

        $method = $this->parser->parse($stmts, $this->class);

        $this->assertThat($method, $this->isInstanceOf(Method::class));
        $this->assertThat($method->name, $this->equalTo('setUpdatedAt'));
    }

    /**
     * @test
     */
    public function parseMethodComment()
    {
        \Phake::when($this->annotationsParser)->parse(\Phake::anyParameters())->thenReturn([]);
        $stmts = include __DIR__.'/../fixtures/1/Model/Product.php.method.cache';

        $method = $this->parser->parse($stmts, $this->class);

        $this->assertThat($method->comment, $this->equalTo('Sets updated datetimedetailed description here'));
    }
}
