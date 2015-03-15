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
use DomainCoder\Metamodel\Code\Element\ClassModel\ClassFactory;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Interface_;

class ClassParser
{
    /**
     * @var ClassFactory
     */
    private $classFactory;
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

    public function __construct(ClassFactory $classFactory, PropertyAnnotationsParser $propertyAnnotationParser, PropertyParser $propertyParser, MethodParser $methodParser, CommentsParser $commentsParser)
    {
        $this->classFactory = $classFactory;
        $this->propertyAnnotationParser = $propertyAnnotationParser;
        $this->propertyParser = $propertyParser;
        $this->methodParser = $methodParser;
        $this->commentsParser = $commentsParser;
    }

    /**
     * @param $stmt
     * @return bool
     */
    public function match($stmt)
    {
        return ($stmt instanceof Class_) ||
        ($stmt instanceof Interface_);
    }

    /**
     * @param $classStmt
     * @param $namespace
     * @return Element\ClassModel
     */
    public function parse($classStmt, $namespace, $source)
    {
        $attrs = $classStmt->getAttributes();

        $class = $this->classFactory->create($classStmt->name);
        $class->setNamespace($namespace);
        $class->setSource($source, $attrs['startLine'], 0);

        // annotation
        $this->commentsParser->parse($attrs, $class);

        // property
        $properties = array_filter($classStmt->stmts, function ($stmt) {
            return $this->propertyParser->match($stmt);
        });
        array_map(function ($propertiesStmt) use ($class) {
            array_map(function ($propertyStmt) use ($class, $propertiesStmt) {
                $prop = $this->propertyParser->parse($propertyStmt, $class);
                $this->propertyAnnotationParser->parse($propertiesStmt, $prop, $class);
            }, $propertiesStmt->props);
        }, $properties);

        // method
        $methods = array_filter($classStmt->stmts, function ($stmt) {
            return $this->methodParser->match($stmt);
        });
        array_map(function ($methodStmt) use ($class) {
            $this->methodParser->parse($methodStmt, $class);
        }, $methods);

        return $class;
    }
}