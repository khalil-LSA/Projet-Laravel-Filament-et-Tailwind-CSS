<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations personnelles')
                    ->description('Identité et coordonnées de l\'utilisateur')
                    ->icon('heroicon-o-user')
                    ->iconColor('primary')
                    ->collapsible()
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom complet')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-user-circle')
                                    ->prefixIconColor('primary')
                                    ->placeholder('Ex: Jean Dupont')
                                    ->helperText('Nom affiché dans le système')
                                    ->columnSpan(1),
                                
                                TextInput::make('email')
                                    ->label('Adresse e-mail')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-envelope')
                                    ->prefixIconColor('info')
                                    ->placeholder('exemple@domaine.com')
                                    ->helperText('Adresse e-mail unique')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),

                        DateTimePicker::make('email_verified_at')
                            ->label('E-mail vérifié le')
                            ->seconds(false)
                            ->nullable()
                            ->prefixIcon('heroicon-o-check-badge')
                            ->prefixIconColor('success')
                            ->helperText('Date et heure de vérification de l\'e-mail'),
                    ]),

                Section::make('Sécurité')
                    ->description('Définissez le mot de passe de l\'utilisateur')
                    ->icon('heroicon-o-lock-closed')
                    ->iconColor('danger')
                    ->collapsible()
                    ->visibleOn('create')
                    ->schema([
                        TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->required()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                            ->prefixIcon('heroicon-o-key')
                            ->prefixIconColor('danger')
                            ->helperText('Minimum 8 caractères recommandés')
                            ->minLength(8),
                    ]),
            ]);
    }
}
