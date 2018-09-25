<?php
declare(strict_types=1);

namespace Ueef\Envelope\Interfaces;

use Ueef\Packable\Interfaces\PackableInterface;

interface EnvelopeInterface
{
    public function pack(PackableInterface $item): array;
    public function unpack(array $packed);
}