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

use DomainCoder\Metamodel\Code\Element\Reference\ReferenceFactory;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;

class NamespaceParser
{
    /**
     * @var ClassParser
     */
    private $classParser;
    /**
     * @var ReferenceFactory
     */
    private $referenceFactory;

    public function __construct(ClassParser $classParser, ReferenceFactory $referenceFactory)
    {
        $this->classParser = $classParser;
        $this->referenceFactory = $referenceFactory;
    }

    /**
     * @param array $stmts
     * @return bool
     */
    public function match($stmts)
    {
        return $stmts[0] instanceof Namespace_;
    }

    /**
     * @param array $stmts
     * @param $sourcePath
     * @return string
     */
    public function parse($stmts, $sourcePath)
    {
        $namespace = (string)$stmts[0]->name;

        $classStmts = array_filter($stmts[0]->stmts, function (Stmt $stmt) {
            return $this->classParser->match($stmt);
        });

        if ($classStmts) {
            // class
            $classStmt = array_pop($classStmts);
            $class = $this->classParser->parse($classStmt, $namespace, $sourcePath);

            // use
            $useStmts = array_filter($stmts[0]->stmts, function ($element) {
                return $element instanceof Use_;
            });

            array_map(function (Stmt $useStmt) use ($class) {
                array_map(function (Stmt $oneUseStmt) use ($class) {
                    $this->referenceFactory->create((string)$oneUseStmt->name, $class);
                }, $useStmt->uses);
            }, $useStmts);
        }

        return $namespace;
    }
}
