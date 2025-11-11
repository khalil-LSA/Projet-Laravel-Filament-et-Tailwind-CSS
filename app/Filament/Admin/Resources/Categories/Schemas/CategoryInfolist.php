<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations de la Catégorie')
                    ->description('Détails de la catégorie')
                    ->icon('heroicon-o-folder')
                    ->iconColor('info')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Image')
                                    ->circular()
                                    ->size(120)
                                    ->defaultImageUrl('/images/placeholder.png')
                                    ->columnSpan(1),
                                
                                Grid::make(1)
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Nom de la catégorie')
                                            ->icon('heroicon-o-tag')
                                            ->iconColor('info')
                                            ->size('xl')
                                            ->weight(FontWeight::Bold)
                                            ->copyable()
                                            ->copyMessage('Nom copié!'),
                                        
                                        TextEntry::make('slug')
                                            ->label('Slug')
                                            ->icon('heroicon-o-link')
                                            ->badge()
                                            ->color('gray')
                                            ->copyable()
                                            ->copyMessage('Slug copié!'),
                                        
                                        TextEntry::make('products_count')
                                            ->label('Nombre de produits')
                                            ->state(fn ($record) => $record?->products()->count() ?? 0)
                                            ->icon('heroicon-o-shopping-bag')
                                            ->badge()
                                            ->color('success'),
                                    ])
                                    ->columnSpan(2),
                            ]),
                    ])
                    ->collapsible(),

                Grid::make(2)
                    ->schema([
                        Section::make('Statut')
                            ->icon('heroicon-o-signal')
                            ->iconColor('success')
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label('Catégorie active')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ]),

                        Section::make('Dates')
                            ->icon('heroicon-o-clock')
                            ->iconColor('gray')
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Créé le')
                                    ->dateTime('d/m/Y à H:i')
                                    ->icon('heroicon-o-calendar-days')
                                    ->color('success'),
                                
                                TextEntry::make('updated_at')
                                    ->label('Modifié le')
                                    ->dateTime('d/m/Y à H:i')
                                    ->icon('heroicon-o-pencil-square')
                                    ->color('gray')
                                    ->since(),
                            ]),
                    ]),
            ]);
    }
}
