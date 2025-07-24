<?php

namespace Pengxul\Supports\Tests\Stubs;

use ArrayAccess;
use JsonSerializable as JsonSerializableInterface;
use Pengxul\Supports\Traits\Accessable;
use Pengxul\Supports\Traits\Arrayable;
use Pengxul\Supports\Traits\Serializable;

class TraitStub  implements JsonSerializableInterface, ArrayAccess, \Serializable
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
