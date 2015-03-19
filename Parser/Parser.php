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
use DomainCoder\Metamodel\Code\Util\Model;
use PhpParser\Lexer as PhpLexer;
use PhpParser\Parser as PhpParser;
use PhpParser\Error as PhpParserError;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;

class Parser
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @var \PhpParser\Parser
     */
    private $parser;

    /**
     * @var NodeTraverser
     */
    private $traverser;

    /**
     * @var NamespaceParser
     */
    private $namespaceParser;

    public function __construct()
    {
        $this->model = new Model();

        // initialize PhpParser
        $this->parser = new PhpParser(new PhpLexer());
        $this->traverser = new NodeTraverser();
        $this->traverser->addVisitor(new NameResolver());

        $annotationsParser = new AnnotationsParser();

        // factories
        $classFactory = new Element\ClassModel\ClassFactory($this->model);
        $methodFactory = new Element\Method\MethodFactory($this->model);
        $propertyFactory = new Element\Property\PropertyFactory($this->model);
        $annotationFactory = new Element\Annotation\AnnotationFactory();
        $referenceFactory = new Element\Reference\ReferenceFactory();

        // child parsers
        $commentFilter = new CommentFilter();

        $commentsParser = new CommentsParser(
            $annotationsParser,
            $annotationFactory,
            $commentFilter
        );

        $propertyAnnotationParser = new PropertyAnnotationsParser(
            $referenceFactory,
            $commentsParser
        );

        $propertyParser = new PropertyParser(
            $propertyFactory
        );

        $methodParser = new MethodParser(
            $methodFactory,
            $commentsParser,
            $commentFilter
        );

        $classParser = new ClassParser(
            $classFactory,
            $propertyAnnotationParser,
            $propertyParser,
            $methodParser,
            $commentsParser
        );

        $this->namespaceParser = new NamespaceParser(
            $classParser,
            $referenceFactory
        );
    }

    /**
     * @param $code
     * @param $sourcePath
     * @return Model
     */
    public function parse($code, $sourcePath)
    {
        try {
            $stmts = $this->parser->parse($code);
            $stmts = $this->traverser->traverse($stmts);

            if ($this->namespaceParser->match($stmts)) {
                $this->namespaceParser->parse($stmts, $sourcePath);
            }
        } catch (PhpParserError $e) {
            throw new ParseException('Parse Error: '. $e->getMessage());
        }

        return $this->model;
    }

    /**
     * @return Model
     */
    public function __invoke()
    {
        return $this->model;
    }
}
