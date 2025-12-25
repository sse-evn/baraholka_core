<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($this->record->role === 'seller' && $this->record->seller) {
            $data['shop_name'] = $this->record->seller->shop_name;
            $data['contact_email'] = $this->record->seller->contact_email;
            $data['phone'] = $this->record->seller->phone;
        }

        return $data;
    }

protected function handleRecordSaved(): void
{
    parent::handleRecordSaved();

    $data = $this->form->getState();

    if ($data['role'] === 'seller') {
        \App\Models\Seller::updateOrCreate(
            ['user_id' => $this->record->id],
            [
                'shop_name' => $data['shop_name'] ?? '',
                'contact_email' => $data['contact_email'] ?? '',
                'phone' => $data['phone'] ?? '',
            ]
        );
    } else {
        $this->record->seller?->delete();
    }
}

}
