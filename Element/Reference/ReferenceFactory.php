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

namespace DomainCoder\Metamodel\Code\Element\Reference;

use DomainCoder\Metamodel\Code\Element;

class ReferenceFactory
{
    /**
     * @param $name
     * @param ReferenceableInterface $target
     * @return Element\Reference|mixed
     */
    public function create($name, ReferenceableInterface $target)
    {
        $reference = new Element\Reference($name, $name);

        $temp = $target->getReference();
        if ($temp instanceof ReferenceCollection) {
            foreach ($temp as $reference) {
                $target->add($reference);
            }
        } else {
            $target->add($temp);
        }

        return $reference;
    }
}
