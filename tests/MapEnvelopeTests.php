<?php
declare(strict_types=1);

namespace Ueef\Envelope\Tests;

use Ueef\Envelope\Tests\Stubs\Enveloped;
use Ueef\Envelope\Envelopes\MapEnvelope;

class MapEnvelopeTests extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $proto = new Enveloped();
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
}