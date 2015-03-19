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

namespace DomainCoder\Metamodel\Code;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new Command\ParseCommand();
        $defaultCommands[] = new Command\DumpCommand();
        $defaultCommands[] = new Command\FilterMethodCommand();
        $defaultCommands[] = new Command\FilterClassCommand();
        $defaultCommands[] = new Command\FilterPropertyCommand();

        return $defaultCommands;
    }
}
