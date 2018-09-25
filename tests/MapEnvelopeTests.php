<?php
declare(strict_types=1);

use Ueef\Packable\Traits\PackableTrait;
use Ueef\Envelope\Envelopes\MapEnvelope;
use Ueef\Packable\Interfaces\PackableInterface;

class MapEnvelopeTests extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $proto = $this->makeTestClass();
        $envelope = new MapEnvelope([
            'test' => $proto,
        ]);

        $item = new $proto(1,2,3);
        $packed = $envelope->pack($item);
        $item1 = $envelope->unpack($packed);
        $packed1 = $envelope->pack($item1);

        $this->assertEquals($item, $item1);
        $this->assertEquals($packed, $packed1);
    }

    private function makeTestClass(): PackableInterface
    {
        return new class implements PackableInterface {
            use PackableTrait;

            private $a;
            private $b;
            private $c;

            public function __construct($a = 0, $b = 0, $c = 0)
            {
                $this->a = $a;
                $this->b = $b;
                $this->c = $c;
            }
        };
    }
}