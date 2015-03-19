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
    public static $STANDARD_ANNOTATIONS = ['@var', '@param', '@return'];

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
     * @param array $stmt
     * @param $target
     * @return void
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
            array_map(function (\stdClass $stmt) use ($target) {
                $this->annotationFactory->create($stmt->name, $stmt->values, $target);
            }, $annotationStmts);

            $comment .= array_reduce(explode("\n", $text), function ($current, $line) use ($target) {
                if ($this->containsStandardAnnotation($line)) {
                    $anno = $this->extractStandardAnnotations($line);
                    if (count($anno) > 0) {
                        $this->annotationFactory->create($anno[0]['name'], $anno[0]['parameter'], $target);
                    }
                    return $current;
                } else {
                    return $current . $this->commentFilter->filter($line);
                }
            }, '');
        }

        if ($comment) {
            $target->comment = $comment;
        }
    }

    /**
     * @param $text
     * @return bool
     */
    private function containsStandardAnnotation($text)
    {
        return preg_match('/' . implode('|', self::$STANDARD_ANNOTATIONS) . '/', $text);
    }

    /**
     * @param $text
     * @return mixed
     */
    private function extractStandardAnnotations($text)
    {
        preg_match_all('/(' . implode('|', self::$STANDARD_ANNOTATIONS) . ')(\s*)([^@\s*]*)/', $text, $matches, PREG_SET_ORDER);

        $ret = [];
        foreach ($matches as $match) {
            if (is_array($match)) {
                $param = trim($match[3]);
                if ($param) {
                    $ret[] = ['name' => str_replace('@', '', $match[1]), 'parameter' => $match[3]];
                }
            } else {
                $ret[] = ['name' => str_replace('@', '', $match[1]), 'parameter' => null];
            }
        }

        return $ret;
    }
}
