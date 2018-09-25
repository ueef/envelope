<?php
declare(strict_types=1);

namespace Ueef\Envelope\Envelopes;

use Ueef\Envelope\Exceptions\UndefinedTypeException;
use Ueef\Envelope\Exceptions\WrongFormatException;
use Ueef\Envelope\Interfaces\EnvelopeInterface;
use Ueef\Packable\Interfaces\PackableInterface;

class SimpleEnvelope implements EnvelopeInterface
{
    public function pack(PackableInterface $item): array
    {
        return [get_class($item), $item->pack()];
    }

    public function unpack(array $packed): PackableInterface
    {
        $classname = array_shift($packed);
        if (!is_string($classname)) {
            throw new WrongFormatException(["unexpected \"%s\", expecting \"string\"", gettype($classname)]);
        }
        if (!class_exists($classname)) {
            throw new WrongFormatException(["class \"%s\" not exist", $classname]);
        }

        $data = array_shift($packed);
        if (!is_array($data)) {
            throw new WrongFormatException(["unexpected \"%s\", expecting \"array\"", gettype($data)]);
        }

        $item = new $classname;
        if ($item instanceof PackableInterface) {
            $item->assign($data);
        } else {
            throw new WrongFormatException(["class \"%s\" must implement \"%s\"", $classname, PackableInterface::class]);
        }

        return $item;
    }

    public function register(string $key, PackableInterface $proto)
    {
        $this->map[$key] = $proto;
    }
}