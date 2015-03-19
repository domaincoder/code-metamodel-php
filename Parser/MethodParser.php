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

use DomainCoder\Metamodel\Code\Element;
use DomainCoder\Metamodel\Code\Element\Method\MethodFactory;
use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;

class MethodParser
{
    /**
     * @var CommentFilter
     */
    public $commentFilter;
    /**
     * @var MethodFactory
     */
    private $methodFactory;
    /**
     * @var CommentsParser
     */
    private $commentsParser;

    public function __construct(MethodFactory $methodFactory, CommentsParser $commentsParser, CommentFilter $commentFilter)
    {
        $this->methodFactory = $methodFactory;
        $this->commentFilter = $commentFilter;
        $this->commentsParser = $commentsParser;
    }

    /**
     * @param Stmt $stmt
     * @return bool
     */
    public function match(Stmt $stmt)
    {
        return $stmt instanceof ClassMethod;
    }

    /**
     * @param Stmt $methodStmt
     * @param Element\ClassModel $class
     * @return Element\Method
     */
    public function parse(Stmt $methodStmt, Element\ClassModel $class)
    {
        $method = $this->methodFactory->create($methodStmt->name, $class);

        // annotation
        $attrs = $methodStmt->getAttributes();
        $this->commentsParser->parse($attrs, $method);

        return $method;
    }
}
