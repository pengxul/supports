<?php

declare(strict_types=1);

namespace Pengxul\Supports\Tests\Stubs;

use Pengxul\Supports\Pipeline;

class FooPipeline extends Pipeline
{
    protected function handleCarry($carry)
    {
        $carry = parent::handleCarry($carry);
        if (is_int($carry)) {
            $carry += 2;
        }
        return $carry;
    }
}
