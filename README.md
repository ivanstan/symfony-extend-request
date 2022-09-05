# Symfony extend request

This bundle allows users to annotate the controller method type with class that 
extends `Symfony\Component\HttpFoundation\Request` and implement custom logic inside child class.

## Example

```php
namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

class ExtendedRequest extends Request
{
    public function foo(): string
    {
        return $this->get('foo');
    }
}
```

```php
use App\Request\ExtendedRequest;

class ExampleController extends AbstractController {

    public function someMethod(ExtendedRequest $request): JsonResponse
    {
        return new JsonResponse([
            'foo' => $request->foo(),
        ]);
    }
    
}
```

## Installation
```bash
composer require ivanstan/symfony-extend-request
```
Add to your project's `bundle.php`:
```php
<?php

return [
    Ivanstan\SymfonyExtendRequest\SymfonyExtendRequestBundle::class => ['all' => true],
];
```

## Next development steps
- Add ability to inject services to extended request class using `#[Required]` attribute.
- Support request validation in child classes.
