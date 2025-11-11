<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations de l\'Utilisateur')
                    ->description('Profil et coordonnées')
                    ->icon('heroicon-o-user-circle')
                    ->iconColor('primary')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nom complet')
                            ->icon('heroicon-o-user')
                            ->iconColor('primary')
                            ->size('xl')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Nom copié!')
                            ->columnSpanFull(),
                        
                        TextEntry::make('email')
                            ->label('Adresse email')
                            ->icon('heroicon-o-envelope')
                            ->iconColor('info')
                            ->copyable()
                            ->copyMessage('Email copié!')
                            ->badge()
                            ->color('info'),
                        
                        TextEntry::make('email_verified_at')
                            ->label('Email vérifié')
                            ->icon('heroicon-o-check-badge')
                            ->dateTime('d/m/Y à H:i')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger')
                            ->placeholder('Non vérifié'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Grid::make(2)
                    ->schema([
                        Section::make('Statistiques')
                            ->icon('heroicon-o-chart-bar')
                            ->iconColor('success')
                            ->schema([
                                TextEntry::make('orders_count')
                                    ->label('Nombre de commandes')
                                    ->state(fn ($record) => $record?->orders()->count() ?? 0)
                                    ->icon('heroicon-o-shopping-cart')
                                    ->badge()
                                    ->color('success')
                                    ->size('lg'),
                            ]),

                        Section::make('Dates')
                            ->icon('heroicon-o-clock')
                            ->iconColor('gray')
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Inscrit le')
                                    ->dateTime('d/m/Y à H:i')
                                    ->icon('heroicon-o-calendar-days')
                                    ->color('success'),
                                
                                TextEntry::make('updated_at')
                                    ->label('Dernière activité')
                                    ->dateTime('d/m/Y à H:i')
                                    ->icon('heroicon-o-clock')
                                    ->color('gray')
                                    ->since(),
                            ]),
                    ]),
            ]);
    }
}
