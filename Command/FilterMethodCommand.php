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
use DomainCoder\Metamodel\Code\Element\Annotation;
use DomainCoder\Metamodel\Code\Element\Method;
use DomainCoder\Metamodel\Code\Util\Model;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Functional as F;

class FilterMethodCommand extends BaseCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('filter-method')
            ->setDescription('filter methods.')
            ->addOption(
                'annotation', null,
                InputOption::VALUE_OPTIONAL,
                'annotation', null
            )
            ->addOption(
                'comment', null,
                InputOption::VALUE_OPTIONAL,
                'comment', null
            )
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

        $methods = $model->methodCollection;

        if ($target = $input->getOption('annotation')) {
            $methods = $methods->findByAnnotationName($target);
        }
        if ($keyword = $input->getOption('comment')) {
            $methods = $methods->findByComment($keyword);
        }

        if (count($methods) > 0) {
            $output->writeln('found ' . $methods->count() . ' methods');
            foreach ($methods as $method) {
                /** @var Method $method */
                $output->writeln(' ' . $method->getFQN());

                if ($target = $input->getOption('annotation')) {
                    $annots = $method->annotations->withName($target);
                    foreach ($annots as $anno) {
                        /** @var Annotation $anno */
                        $kvs = F\Flatten($anno->parameters);
                        foreach ($kvs as $key => $value) {
                            $output->writeln('    [' . $key . '] ' . $value);
                        }
                    }
                }
                if ($keyword = $input->getOption('comment')) {
                    $output->writeln('   ' . $method->comment);
                }
            }
        } else {
            $output->writeln('no method found');
        }
    }
}
