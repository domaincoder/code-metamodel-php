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

class AnnotationParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationsParser
     */
    private $parser;

    protected function setUp()
    {
        $this->parser = new AnnotationsParser();
    }

    /**
     * @test
     */
    public function parseAnnotation()
    {
        $doc = '/** @var string */';
        $annotationData = $this->parser->parse($doc);
        $this->assertThat($annotationData[0]->name, $this->equalTo('var'));

        $doc = '/** @ORM\Column(name="createdAt") */';
        $annotationData = $this->parser->parse($doc);
        $this->assertThat($annotationData[0]->name, $this->equalTo('ORM\Column'));
        $this->assertThat($annotationData[0]->values, $this->equalTo(['name'=>'createdAt']));
    }
}
