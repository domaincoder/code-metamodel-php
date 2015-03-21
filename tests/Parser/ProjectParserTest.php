<?php

namespace DomainCoder\Metamodel\Code\Parser;


class ProjectParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProjectParser
     */
    private $projectParser;

    /**
     * @var Parser
     */
    private $parser;

    protected function setUp()
    {
        $this->parser = \Phake::mock(Parser::class);
        $this->projectParser = new ProjectParser($this->parser);
    }

    /**
     * @test
     */
    public function parseNormal()
    {
        \Phake::when($this->parser)->parse(\Phake::anyParameters())->thenReturn(null);

        $path = __DIR__.'/../fixtures/1';

        $this->projectParser->parse($path);

        \Phake::verify($this->parser, \Phake::times(3))->parse(\Phake::anyParameters());
    }
}
