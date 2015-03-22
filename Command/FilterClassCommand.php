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
use DomainCoder\Metamodel\Code\Element\ClassModel;
use DomainCoder\Metamodel\Code\Util\Model;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Functional as F;

class FilterClassCommand extends BaseCommand
{
    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('filter-class')
            ->setDescription('filter classes.')
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

        $classes = $model->classCollection;

        if ($target = $input->getOption('annotation')) {
            $classes = $classes->withAnnotationName($target);
        }
        if ($keyword = $input->getOption('comment')) {
            $classes = $classes->withComment($keyword);
        }

        if (count($classes) > 0) {
            $output->writeln('found ' . $classes->count() . ' classes');
            foreach ($classes as $class) {
                /** @var ClassModel $class */
                $output->writeln(' ' . $class->getFQCN());

                if ($target = $input->getOption('annotation')) {
                    $annots = $class->annotations->withName($target);
                    foreach ($annots as $anno) {
                        /** @var Annotation $anno */
                        $kvs = F\Flatten($anno->parameters);
                        foreach ($kvs as $key => $value) {
                            $output->writeln('    [' . $key . '] ' . $value);
                        }
                    }
                }
                if ($keyword = $input->getOption('comment')) {
                    $output->writeln('   ' . $class->comment);
                }
            }
        } else {
            $output->writeln('no class found');
        }
    }
}
