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

use DomainCoder\Metamodel\Code\Parser\Parser;
use DomainCoder\Metamodel\Code\Parser\ProjectParser;
use DomainCoder\Metamodel\Code\Util\Model;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCommand extends BaseCommand
{
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('parse')
            ->setDescription('Load metamodel from PHP source codes.')
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

        $projectParser = new ProjectParser(new Parser());
        /** @var Model $model */
        $model = $projectParser->parse($path);

        $this->writeCache($path, $model);

        $output->writeln('<info>Cache created Successfully!</info>');
    }
}
