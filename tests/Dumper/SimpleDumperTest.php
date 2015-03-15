<?php
namespace DomainCoder\Metamodel\Code\Dumper;

class SimpleDumperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function instancing()
    {
        $dumper = new SimpleDumper();

        $this->assertThat($dumper, $this->isInstanceOf(SimpleDumper::class));
    }
}
