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
use DomainCoder\Metamodel\Code\Dumper\SimpleDumper;
use DomainCoder\Metamodel\Code\Util\Model;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends BaseCommand
{
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('dump')
            ->setDescription('Dump metamodel.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @codeCoverageIgnore
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        try {
            /** @var Model $model */
            $model = $this->loadFromCache($path);
        } catch (CacheNotFoundException $e) {
            $output->writeln('<error>Model cache doesn\'t exist. Run parse command before any operation.</error>');
            return;
        }

        $dumper = new SimpleDumper();
        $output->write($dumper->dump($model->classCollection));
    }
}
