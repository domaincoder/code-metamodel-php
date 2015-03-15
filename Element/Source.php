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

namespace DomainCoder\Metamodel\Code\Element;

class Source
{
    /**
     * @var string
     */
    public $relativePath;

    /**
     * @var string
     */
    public $fileName;

    /**
     * @var int
     */
    public $line;

    /**
     * @var int
     */
    public $col;


    public function __construct($relativePath, $line, $col)
    {
        $this->relativePath = $relativePath;
        $this->fileName = basename($this->relativePath);
        $this->line = $line;
        $this->col = $col;
    }
}