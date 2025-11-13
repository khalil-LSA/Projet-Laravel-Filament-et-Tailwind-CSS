<?php

namespace App\Filament\Admin\Resources\Brands\Schemas;

use App\Models\Brand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations de la marque')
                    ->description('Définissez l\'identité de votre marque')
                    ->icon('heroicon-o-building-office')
                    ->iconColor('primary')
                    ->collapsible()
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom de la marque')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                                    ->prefixIcon('heroicon-o-building-storefront')
                                    ->prefixIconColor('primary')
                                    ->placeholder('Ex: Apple, Samsung, Nike...')
                                    ->helperText('Nom officiel de la marque')
                                    ->columnSpan(1),
                                
                                TextInput::make('slug')
                                    ->label('URL (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Brand::class, ignoreRecord: true)
                                    ->prefixIcon('heroicon-o-link')
                                    ->prefixIconColor('success')
                                    ->helperText('Généré automatiquement')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ]),

                Section::make('Logo & Visibilité')
                    ->description('Ajoutez le logo de la marque et gérez sa visibilité')
                    ->icon('heroicon-o-photo')
                    ->iconColor('info')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('image')
                            ->label('Logo de la marque')
                            ->image()
                            ->disk('public')
                            ->directory('brands')
                            ->imageEditor()
                            ->downloadable()
                            ->helperText('Logo affiché sur les fiches produits')
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Marque active')
                            ->helperText('La marque sera visible sur le site')
                            ->required()
                            ->default(true)
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->onIcon('heroicon-o-check-circle')
                            ->offIcon('heroicon-o-x-circle'),
                    ]),
            ]);
    }
}
