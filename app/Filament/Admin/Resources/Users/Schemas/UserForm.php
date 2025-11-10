<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->seconds(false)
                    ->nullable()
                    ->helperText('Date et heure de vérification de l\'email'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->visibleOn('create'),
            ]);
    }
}
