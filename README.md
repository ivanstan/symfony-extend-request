# Symfony extend request

This bundle allows users to annotate the controller method type with class that 
extends `Symfony\Component\HttpFoundation\Request` and implement custom logic inside child class.

## Example

```php
use App\Request\ExtendedRequest;

class ProductsController extends AbstractController {

    #[Route('product/search')]
    public function search(SearchProductsRequest $request): JsonResponse
    {
        return new JsonResponse([
            'name' => $request->getName(),
        ]);
    }
    
}
```

```php
namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

class SearchProductsRequest extends Request
{
    public function getName(): string
    {
        return $this->get('name');
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

## Requests as services
Classes extending `Symfony\Component\HttpFoundation\Request` can now be promoted to fully functional
Symfony services, with all of its dependency injection features. Since request constructor is dedicated for
query params, headers, etc. `Required` attribute is encouraged to inject other services in extended request class, for example:

```php
<?php

namespace App\Request;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Service\Attribute\Required;

class ExtendedRequest extends Request
{
    protected LoggerInterface $logger;

    #[Required]
    public function setLogger(LoggerInterface $logger):void
    {
        $this->logger = $logger;
    }
}

```

This will de-facto work if autowiring is enabled.

## Testing
Run: `composer test`

## Next development steps
- Support request validation in child classes.
