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

namespace DomainCoder\Metamodel\Code\Command;

use DomainCoder\Metamodel\Code\Command\Exception\CacheNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class BaseCommand extends Command
{
    protected function configure()
    {
        $this
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'root directory path to read'
            )
        ;
    }

    /**
     * @param $path
     * @return mixed
     */
    protected function loadFromCache($path)
    {
        $cachePath = $this->cacheFilePath($path);

        if (!file_exists($cachePath)) {
            throw new CacheNotFoundException();
        }

        return unserialize(file_get_contents($cachePath));
    }

    /**
     * @param $path
     * @param $data
     */
    protected function writeCache($path, $data)
    {
        $cachePath = $this->cacheFilePath($path);

        file_put_contents($cachePath, serialize($data));
    }

    /**
     * @param $path
     * @return string
     */
    protected function cacheFilePath($path)
    {
        $cacheDir = __DIR__.'/../var/cache/';
        $cachename = md5(realpath($path));
        return $cacheDir.$cachename;
    }
}