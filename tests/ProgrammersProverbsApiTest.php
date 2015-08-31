<?php
require __DIR__ . '/../src/ProgrammersProverbsApi.php';

class ProgrammersProverbsApiTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->proverb = new ProgrammersProverbsApi();
    }

    public function testGetRandomProverb()
    {
        $proverb = json_decode($this->proverb->getProverb());

        $this->assertEquals(1, count($proverb));
    }

    public function testGetAllProverb()
    {
        $proverb = json_decode($this->proverb->getProverb('all'));

        $this->assertGreaterThan(1, count($proverb));
    }
}