<?php

namespace Ivanstan\SymfonyExtendRequest\Tests\Request;

use Symfony\Component\HttpFoundation\Request;

class ExtendedRequest extends Request
{
    public function foo(): string
    {
        return $this->get('foo');
    }
}
