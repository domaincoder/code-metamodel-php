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

use DomainCoder\Metamodel\Code\Util\Model;
use Symfony\Component\Finder\Finder;

class ProjectParser
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function parse($rootPath)
    {
        $finder = new Finder();
        $sources = $finder
            ->files()
            ->name('*.php')
            ->notName('*Test.php')
            ->exclude(['cache', 'logs', 'vendor', 'tests', 'Test'])
            ->in($rootPath);

        foreach ($sources as $file) {
            /** @var \SplFileInfo $file */
            $filePath = $file->getRealPath();
            $content = file_get_contents($filePath);
            $this->parser->parse($content, $filePath);
        }

        /** @var Model $model */
        $p = $this->parser;
        $model = $p();

        return $model;
    }
}