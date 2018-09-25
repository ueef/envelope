<?php
declare(strict_types=1);

namespace Ueef\Envelope\Envelopes;

use Ueef\Envelope\Exceptions\UndefinedTypeException;
use Ueef\Envelope\Exceptions\WrongFormatException;
use Ueef\Envelope\Interfaces\EnvelopeInterface;
use Ueef\Packable\Interfaces\PackableInterface;

class MapEnvelope implements EnvelopeInterface
{
    /** @var PackableInterface[] */
    private $map = [];

    public function __construct(array $map)
    {
        foreach ($map as $key => $proto) {
            $this->register($key, $proto);
        }
    }

    public function pack(PackableInterface $item): array
    {
        $key = '';
        foreach ($this->map as $_key => $proto) {
            if ($proto instanceof $item) {
                $key = $_key;
            }
        }
        if (!$key) {
            throw new UndefinedTypeException(["key for \"%s\" is not defined", get_class($item)]);
        }

        return [$key, $item->pack()];
    }

    public function unpack(array $packed): PackableInterface
    {
        $key = array_shift($packed);
        if (!is_string($key)) {
            throw new WrongFormatException(["unexpected \"%s\", expecting \"string\"", gettype($key)]);
        }
        if (!key_exists($key, $this->map)) {
            throw new UndefinedTypeException(["type \"%s\" is not defined", $key]);
        }

        $data = array_shift($packed);
        if (!is_array($data)) {
            throw new WrongFormatException(["unexpected \"%s\", expecting \"array\"", gettype($data)]);
        }

        $item = clone $this->map[$key];
        $item->assign($data);

        return $item;
    }

    public function register(string $key, PackableInterface $proto)
    {
        $this->map[$key] = $proto;
    }
}