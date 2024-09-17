<?php

namespace LaraZeus\Hades\Concerns;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;

trait UseDraftable
{
    public ?array $formDraft;

    public function mount(): void
    {
        parent::mount();

        $id = $this->form->getModel();

        $this->js('
            let getValues = JSON.parse(window.localStorage.getItem("' . $id . '"));
            $wire.set("formDraft", getValues)
        ');
    }

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

    protected function saveDraft()
    {
        $data = Arr::except($this->form->getRawState(), $this->excludedInputs);

        $id = $this->form->getModel();

        $this->js('
            localStorage.setItem("' . $id . '", JSON.stringify(' . json_encode($data) . '))
        ');

        Notification::make()
            ->title(__('Draft saved successfully'))
            ->success()
            ->send();
    }

    protected function restoreDraft()
    {
        $id = $this->form->getModel();
        $this->js('
            $wire.set(
                "form-".' . $id . ',
                JSON.parse(window.localStorage.getItem("' . $id . '"))
             )
        ');

        $this->form->fill($this->formDraft ?? []);

        Notification::make()
            ->title(__('Draft restored successfully'))
            ->success()
            ->send();
    }
}
