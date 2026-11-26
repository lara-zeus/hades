---
name: zeus-hades
description: Add localStorage Save Draft and Restore Draft actions to Filament forms using Lara Zeus Hades.
---

# Lara Zeus Hades

## Overview & Requirements
`lara-zeus/hades` adds "Save Draft" and "Restore Draft" form actions to Filament resource pages, persisting form state in the browser's `localStorage` with support for excluding sensitive fields.

- **Package**: `lara-zeus/hades` (Free / MIT)
- **Requirements**: PHP `^8.1`, `lara-zeus/filament-plugin-tools` `^3.0`

## Installation
```bash
composer require lara-zeus/hades
```

## Configuration & Migrations
None. `HadesServiceProvider` registers only the package name (`zeus-hades`). There are no config files, views, or migrations.

## Filament Panel Registration
None. Hades does not provide a `Plugin` class; use the `UseDraftable` trait directly on Filament resource pages.

## Core Usage

### Enable Drafts on a Resource Page
Add `LaraZeus\Hades\Concerns\UseDraftable` to your Filament `CreateRecord` (or form page) class and declare `$excludedInputs`:

```php
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Hades\Concerns\UseDraftable;

class CreateCar extends CreateRecord
{
    use UseDraftable;

    protected static string $resource = CarResource::class;

    public ?array $excludedInputs = ['password'];
}
```

### Customize Draft Actions
Override `getFormActions()` on the page to customize labels, colors, or icons while keeping the `saveDraft()` and `restoreDraft()` calls:

```php
use Filament\Actions\Action;

protected function getFormActions(): array
{
    return [
        ...parent::getFormActions(),
        Action::make('saveDraft')
            ->action(fn () => $this->saveDraft())
            ->color('info'),
        Action::make('restoreDraft')
            ->action(fn () => $this->restoreDraft())
            ->color('info'),
    ];
}
```

## Common Pitfalls & Anti-Patterns
- **Missing `$excludedInputs` property**: `UseDraftable::saveDraft()` calls `Arr::except($this->form->getRawState(), $this->excludedInputs)`. Define `public ?array $excludedInputs = [];` on the page class to avoid an undefined property error.
- **Overriding `mount()` without calling `parent::mount()`**: `UseDraftable::mount()` calls `parent::mount()` and loads `$this->formDraft` from `localStorage`; overriding `mount()` without calling the trait/parent logic breaks draft hydration.
- **Sensitive fields**: Always list fields like `password` or tokens in `$excludedInputs` so they are not written to `localStorage`.
