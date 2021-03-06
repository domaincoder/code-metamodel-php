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

namespace DomainCoder\Metamodel\Code\Util;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function instancing()
    {
        $model = new Model();

        $this->assertThat($model, $this->isInstanceOf(Model::class));
    }
}
