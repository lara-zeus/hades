## Lara Zeus Hades (`lara-zeus/hades`)

Allows users to save and restore Filament form progress as browser `localStorage` drafts.

### Key Classes & Traits
- Trait: `LaraZeus\Hades\Concerns\UseDraftable`
- ServiceProvider: `LaraZeus\Hades\HadesServiceProvider` (package name: `zeus-hades`)
- No Filament `Plugin` class, config file, or database migrations.

### Rules & Anti-Patterns
- **Do not register as a panel plugin**: There is no `Plugin` class; apply `UseDraftable` directly to Filament page classes (such as `CreateRecord`).
- **Declare `$excludedInputs`**: `UseDraftable::saveDraft()` passes `$this->excludedInputs` to `Arr::except()`, and the trait does not define this property itself. Always declare `public ?array $excludedInputs = [];` (or include sensitive fields like `['password']`) on the page class.
- **Preserve action callbacks when customizing**: If overriding `getFormActions()`, wire `Action::make('saveDraft')->action(fn () => $this->saveDraft())` and `Action::make('restoreDraft')->action(fn () => $this->restoreDraft())`.
- **Client-side storage only**: Drafts are stored in `window.localStorage` keyed by `$this->form->getModel()`; do not expect server-side draft persistence or database tables.
