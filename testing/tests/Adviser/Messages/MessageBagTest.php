<?php namespace Adviser\Messages;

use Mockery;

class MessageBagTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    protected function createMessage($level)
    {
        $message = Mockery::mock("Adviser\Messages\Message");

        $message->shouldReceive("getLevel")->times(3)->andReturn($level);

        return $message;
    }

    /** @test */ public function it_adds_a_message()
    {
        $bag = new MessageBag();

        $this->assertCount(0, $bag->getAll());

        $bag->throwIn($message1 = $this->createMessage(Message::NORMAL));
        $bag->throwIn($this->createMessage(Message::WARNING));
        $bag->throwIn($message3 = $this->createMessage(Message::ERROR));

        $this->assertCount(3, $bag->getAll());

        $this->assertCount(1, $bag->getNormalMessages());
        $this->assertCount(1, $bag->getWarnings());
        $this->assertCount(1, $bag->getErrors());

        $this->assertEquals($bag->first(), $message1);
        $this->assertEquals($bag->last(), $message3);
    }
}
