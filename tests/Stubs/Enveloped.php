<?php
declare(strict_types=1);

namespace Ueef\Envelope\Tests\Stubs;

use Ueef\Packable\Traits\PackableTrait;
use Ueef\Packable\Interfaces\PackableInterface;

class Enveloped implements PackableInterface {
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
}
