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

class CommentsParser
{
    /**
     * @var AnnotationsParser
     */
    private $annotationsParser;
    /**
     * @var AnnotationFactory
     */
    private $annotationFactory;
    /**
     * @var CommentFilter
     */
    private $commentFilter;

    public function __construct(AnnotationsParser $annotationsParser, AnnotationFactory $annotationFactory, CommentFilter $commentFilter)
    {
        $this->annotationsParser = $annotationsParser;
        $this->annotationFactory = $annotationFactory;
        $this->commentFilter = $commentFilter;
    }

    /**
     * @param $stmt
     * @param $target
     * @return string|void
     */
    public function parse($stmt, $target)
    {
        if (!isset($stmt['comments'])) {
            return;
        }

        $comment = '';

        foreach ($stmt['comments'] as $commentObj) {
            $text = $commentObj->getText();
            $annotationStmts = $this->annotationsParser->parse($text);
            array_map(function ($stmt) use ($target) {

                $this->annotationFactory->create($stmt->name, $stmt->values, $target);
            }, $annotationStmts);

            $comment .= array_reduce(explode("\n", $text), function ($current, $line) {
                return $current . $this->commentFilter->filter($line);
            }, '');
        }

        if ($comment) {
            $target->comment = $comment;
        }

        return $comment;
    }
}
