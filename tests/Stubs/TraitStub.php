<?php

namespace Pengxul\Supports\Tests\Stubs;

use ArrayAccess;
use JsonSerializable as JsonSerializableInterface;
use Serializable as SerializableInterface;
use Pengxul\Supports\Traits\Accessable;
use Pengxul\Supports\Traits\Arrayable;
use Pengxul\Supports\Traits\Serializable;

class TraitStub  implements JsonSerializableInterface, SerializableInterface, ArrayAccess
{
    use Accessable;
    use Arrayable;
    use Serializable;

    private $name = 'yansongda';

    private $fooBar = 'name';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): TraitStub
    {
        $this->name = $name;
        return $this;
    }
}
