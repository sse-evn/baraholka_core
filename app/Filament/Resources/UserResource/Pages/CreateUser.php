<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $user = parent::handleRecordCreation($data);

        if ($data['role'] === 'seller') {
            \App\Models\Seller::create([
                'user_id' => $user->id,
                'shop_name' => $data['shop_name'] ?? '',
                'contact_email' => $data['contact_email'] ?? '',
                'phone' => $data['phone'] ?? '',
            ]);
        }

        return $user;
    }
}
