<?php namespace ChristianEsperar\ProgrammersProverbsApi;

use PHPUnit\Framework\TestCase;

include_once(__DIR__ . '/../src/ProgrammersProverbsApi.php');

class ProgrammersProverbsApiTest extends TestCase
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
