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

use Herrera\Annotations\Convert\ToArray;
use Herrera\Annotations\Tokenizer;
use Herrera\Annotations\Tokens;

class AnnotationsParser
{
    /**
     * @var Tokenizer
     */
    private $annotationTokenizer;

    /**
     * @var ToArray
     */
    private $annotationToArray;

    public function __construct()
    {
        $this->annotationTokenizer = new Tokenizer();
        $this->annotationTokenizer->ignore(['SuppressWarnings']);
        $this->annotationToArray = new ToArray();
    }

    /**
     * @param $comment
     * @return mixed
     */
    public function parse($comment)
    {
        return $this->annotationToArray->convert(
            new Tokens($this->annotationTokenizer->parse($comment))
        );
    }
}