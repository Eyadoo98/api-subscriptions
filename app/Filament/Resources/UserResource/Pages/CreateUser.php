<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\ApiKey;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $model = new (static::getModel());
        $input = $data;

        $model->forceFill($input);
        $model->assignRole('User');
        $model->save();

        ApiKey::query()->create([
            'key' => Str::random(40),
            'user_id' => $model->id,
            'active' => true,
        ]);
        return $model;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
