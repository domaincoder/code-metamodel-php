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

use DomainCoder\Metamodel\Code\Util\Model;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    protected function setUp()
    {
        $model = new Model();
        $this->parser = new Parser();
    }

    /**
     * @test
     */
    public function parseNormal()
    {
        $path = __DIR__.'/../fixtures/1/Model/Product.php';
        $code = file_get_contents($path);

        $model = $this->parser->parse($code, $path);

        $this->assertThat($model, $this->isInstanceOf(Model::class));
    }

    /**
     * @test
     * @expectedException \DomainCoder\Metamodel\Code\Parser\ParseException
     */
    public function parseError()
    {
        $code = '<?php $aaa=-=';
        $this->parser->parse($code, '');
    }

    /**
     * @test
     */
    public function invokeResult()
    {
        $parser = $this->parser;
        $result = $parser();

        $this->assertThat($result, $this->isInstanceOf(Model::class));
    }
}
