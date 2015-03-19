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

namespace DomainCoder\Metamodel\Code\Dumper;

use DomainCoder\Metamodel\Code\Element\Annotation;
use DomainCoder\Metamodel\Code\Element\ClassModel;
use DomainCoder\Metamodel\Code\Element\ClassModel\ClassCollection;
use DomainCoder\Metamodel\Code\Element\Method;
use DomainCoder\Metamodel\Code\Element\Property;
use DomainCoder\Metamodel\Code\Element\Reference;

class SimpleDumper implements DumperInterface
{
    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function dump(ClassCollection $classes)
    {
        return $classes->reduce('', function (ClassModel $class, $index, $collection, $current) {
            /** @var ClassModel $class */
            return $current . $class->getFQCN() . PHP_EOL
            . $this->dumpClassInfo($class) . PHP_EOL
            . $this->dumpProperties($class) . PHP_EOL
            . $this->dumpMethods($class) . PHP_EOL
            ;
        });
    }

    /**
     * @param ClassModel $class
     * @return mixed|string
     * @codeCoverageIgnore
     */
    protected function dumpClassInfo(ClassModel $class)
    {
        $buf = $class->annotations->reduce('', function (Annotation $annotation, $index, $collection, $current) {
            /** @var Annotation $annotation */
            return $current . '  ' . $annotation->name . PHP_EOL;
        });

        $buf .= $class->references->reduce('', function (Reference $reference, $index, $collection, $current) {
            /** @var Reference $reference */
            return $current . '  use ' . $reference->name . PHP_EOL;
        });

        return $buf;
    }

    /**
     * @param ClassModel $class
     * @return mixed
     * @codeCoverageIgnore
     */
    protected function dumpProperties(ClassModel $class)
    {
        return $class->properties->reduce('', function (Property $property, $index, $collection, $current) {
            /** @var Property $property */
            return $current . '  - ' . $property->name . ' ' . $property->comment . PHP_EOL
            . $this->dumpPropertyInfo($property);
        });
    }

    /**
     * @param Property $property
     * @return mixed|string
     * @codeCoverageIgnore
     */
    protected function dumpPropertyInfo(Property $property)
    {
        $buf = $property->annotations->reduce('', function (Annotation $annotation, $index, $collection, $current) {
            /** @var Annotation $annotation */
            if (is_array($annotation->parameters)) {
                return $current . '      ' . $annotation->name . ' TODO array impl' . PHP_EOL;
            } else {
                return $current . '      ' . $annotation->name . ' ' . $annotation->parameters . PHP_EOL;
            }
        });

        if ($property->reference) {
            $buf .= '      -> ' . $property->reference->name . PHP_EOL;
        }

        return $buf;
    }

    /**
     * @param ClassModel $class
     * @return mixed
     * @codeCoverageIgnore
     */
    protected function dumpMethods(ClassModel $class)
    {
        return $class->methods->reduce('', function (Method $method, $index, $collection, $current) {
            /** @var Method $method */
            return $current . '  # ' . $method->name . '() ' . $method->comment . PHP_EOL
            . $this->dumpMethodInfo($method);
        });
    }

    /**
     * @param Method $method
     * @return mixed
     * @codeCoverageIgnore
     */
    protected function dumpMethodInfo(Method $method)
    {
        $buf = $method->annotations->reduce('', function (Annotation $annotation, $index, $collection, $current) {
            /** @var Annotation $annotation */
            if (is_array($annotation->parameters)) {
                return $current . '      ' . $annotation->name . ' TODO array impl' . PHP_EOL;
            } else {
                return $current . '      ' . $annotation->name . ' ' . $annotation->parameters . PHP_EOL;
            }
        });

        return $buf;
    }
}
