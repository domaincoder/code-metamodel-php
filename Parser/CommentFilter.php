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

class CommentFilter
{
    /**
     * @param $text
     * @return string
     */
    public function filter($text)
    {
        if (preg_match('/@.+/', $text)) {
            return '';
        }
        $text = str_replace(['/**','*/',"\n","\r"], '', $text);
        $text = substr($text, strpos($text, '*') + 1);

        return trim($text);
    }
}
