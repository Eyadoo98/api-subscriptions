<?php

namespace App\Filament\Resources;

use App\Enums\privateClinic;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\ApiKey;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->required(),
                    Forms\Components\TextInput::make('password')
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                        ->password()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))//before insert password to db make it hash
                        ->dehydrated(fn($state) => filled($state)),//if password not update dont insert into db
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('apiKeys.key')->getStateUsing(function ($record) {//for get api key
                    $apiKeyNumber = ApiKey::query()->where('user_id', $record->id)->get()->pluck('key')->last();
                    $apiKey = ApiKey::query()->where('user_id', $record->id)->where('key', $apiKeyNumber)->first();
                    return $apiKey->key;
                }),
                TextColumn::make('status')
                    ->getStateUsing(function ($record) {
                        $apiKeyNumber = ApiKey::query()->where('user_id', $record->id)->get()->pluck('key')->last();
                        $apiKey = ApiKey::query()->where('user_id', $record->id)->where('key', $apiKeyNumber)->first();
                        if ($apiKey->active == true) {
                            return 'Active';
                        } else {
                            return 'Inactive';
                        }
                    })
                    ->badge()
                    ->color(function ($record) {
                        $apiKeyNumber = ApiKey::query()->where('user_id', $record->id)->get()->pluck('key')->last();
                        $apiKey = ApiKey::query()->where('user_id', $record->id)->where('key', $apiKeyNumber)->first();
                        if ($apiKey->active == true) {
                            return 'success';
                        } else {
                            return 'danger';
                        }
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Change Api Key')
                    ->action(function (User $user) {
                        $apiKeyNumber = ApiKey::query()->where('user_id', $user->id)->get()->pluck('key')->last();
                        $apiKey = ApiKey::query()->where('user_id', $user->id)->where('key', $apiKeyNumber)->first();
                        $apiKey->active = false;
                        $apiKey->save();
                        $newApiKey = ApiKey::query()->create([
                            'user_id' => $user->id, // foreign key reference to users table
                            'key' => Str::random(40), // Generate a random string as the API key
                            'active' => true,
                        ]);
                        if ($apiKey->key == $newApiKey->key) {
                            Notification::make()
                                ->title('Api Key Not Updated Because It Is Same As Previous One')
                                ->danger()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Api Key Updated Successfully')
                                ->success()
                                ->send();
                        }
                    })
                    ->color('success')
                    ->icon('heroicon-o-arrow-path'),

                Tables\Actions\Action::make('Disable')
                    ->action(function (User $user) {
                        $apiKeyNumber = ApiKey::query()->where('user_id', $user->id)->get()->pluck('key')->last();
                        $apiKey = ApiKey::query()->where('user_id', $user->id)->where('key', $apiKeyNumber)->first();
                        $apiKey->active = false;
                        $apiKey->save();
                        Notification::make()
                            ->title('Api Key Disabled Successfully')
                            ->danger()
                            ->send();
                    })
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(function (User $user) {
                        $apiKeyNumber = ApiKey::query()->where('user_id', $user->id)->get()->pluck('key')->last();
                        $apiKey = ApiKey::query()->where('user_id', $user->id)->where('key', $apiKeyNumber)->first();
                        if ($apiKey->active == true) {
                            return true;
                        } else {
                            return false;
                        }
                    }),
                Tables\Actions\Action::make('Enable')
                    ->action(function (User $user) {
                        $apiKeyNumber = ApiKey::query()->where('user_id', $user->id)->get()->pluck('key')->last();
                        $apiKey = ApiKey::query()->where('user_id', $user->id)->where('key', $apiKeyNumber)->first();
                        $apiKey->active = true;
                        $apiKey->save();
                        Notification::make()
                            ->title('Api Key Enabled Successfully')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-check-circle')
                    ->visible(function (User $user) {
                        $apiKeyNumber = ApiKey::query()->where('user_id', $user->id)->get()->pluck('key')->last();
                        $apiKey = ApiKey::query()->where('user_id', $user->id)->where('key', $apiKeyNumber)->first();
                        if ($apiKey->active == false) {
                            return true;
                        } else {
                            return false;
                        }
                    }),
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder //for hide admin from table
    {
        $role = auth()->user()->hasRole('Admin');
        if ($role) {
            return parent::getEloquentQuery()->where('name', '!=', 'Admin');
        }
        return parent::getEloquentQuery()->where('name', auth()->user()->name);
    }
}
