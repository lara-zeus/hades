---
title: Installation
weight: 1
---

## Installation

You can install @zeus Hades by running the following commands in your Laravel project directory.

```bash
composer require lara-zeus/hades
```

## Usage:

you only need to add one trait to your create page:

```php
use LaraZeus\Hades\Concerns\UseDraftable;

class CreateCar extends CreateRecord
{
    use UseDraftable; // <<< Add this

    protected static string $resource = CarResource::class;
}
```

## customize the actions:

to change the label, color, size or icons for the actions, simply, override the actions:

```php
protected function getFormActions(): array
{
    return [
        ...parent::getFormActions(),
        
        Action::make('saveDraft')
            ->action(fn () => $this->saveDraft())// << dont forget this
            ->color('info'),
        Action::make('restoreDraft')
            ->action(fn () => $this->restoreDraft())// << dont forget this
            ->color('info'),
    ];
}
```

## excluded form Inputs:

you can prevent saving any form input on your class:

```php
public ?array $excludedInputs = ['password'];
```
