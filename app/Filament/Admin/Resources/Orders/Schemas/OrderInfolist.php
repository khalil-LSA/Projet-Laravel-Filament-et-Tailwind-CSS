<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations de la Commande')
                    ->description('Détails généraux')
                    ->icon('heroicon-o-shopping-cart')
                    ->iconColor('primary')
                    ->schema([
                        TextEntry::make('id')
                            ->label('Numéro de commande')
                            ->formatStateUsing(fn ($state) => '#' . str_pad($state, 6, '0', STR_PAD_LEFT))
                            ->icon('heroicon-o-hashtag')
                            ->size('xl')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->badge()
                            ->color('primary'),
                        
                        TextEntry::make('user.name')
                            ->label('Client')
                            ->icon('heroicon-o-user')
                            ->iconColor('info')
                            ->badge()
                            ->color('info')
                            ->default('Client supprimé'),
                        
                        TextEntry::make('status')
                            ->label('Statut de la commande')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'new' => 'info',
                                'processing' => 'info',
                                'shipped' => 'primary',
                                'delivered' => 'success',
                                'canceled' => 'danger',
                            })
                            ->icon(fn (string $state): string => match ($state) {
                                'new' => 'heroicon-o-sparkles',
                                'processing' => 'heroicon-o-arrow-path',
                                'shipped' => 'heroicon-o-truck',
                                'delivered' => 'heroicon-o-check-badge',
                                'canceled' => 'heroicon-o-x-circle',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'new' => 'Nouvelle',
                                'processing' => 'En traitement',
                                'shipped' => 'Expédiée',
                                'delivered' => 'Livrée',
                                'canceled' => 'Annulée',
                                default => $state,
                            }),
                        
                        TextEntry::make('items_count')
                            ->label('Nombre d\'articles')
                            ->state(fn ($record) => $record?->items()->count() ?? 0)
                            ->icon('heroicon-o-squares-2x2')
                            ->badge()
                            ->color('success'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Grid::make(2)
                    ->schema([
                        Section::make('Informations Financières')
                            ->icon('heroicon-o-currency-dollar')
                            ->iconColor('success')
                            ->schema([
                                TextEntry::make('grand_total')
                                    ->label('Montant total')
                                    ->numeric(decimalPlaces: 0, thousandsSeparator: ' ')
                                    ->suffix(' FCFA')
                                    ->size('xl')
                                    ->weight(FontWeight::Bold)
                                    ->color('success')
                                    ->icon('heroicon-o-banknotes'),
                                
                                TextEntry::make('shipping_amount')
                                    ->label('Frais de livraison')
                                    ->numeric(decimalPlaces: 0, thousandsSeparator: ' ')
                                    ->suffix(' FCFA')
                                    ->icon('heroicon-o-truck')
                                    ->default('0'),
                                
                                TextEntry::make('payment_method')
                                    ->label('Méthode de paiement')
                                    ->icon('heroicon-o-credit-card')
                                    ->badge()
                                    ->color('info')
                                    ->default('Non spécifié'),
                                
                                TextEntry::make('payment_status')
                                    ->label('Statut du paiement')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        'paid' => 'success',
                                        'pending' => 'info',
                                        'failed' => 'danger',
                                        default => 'gray',
                                    })
                                    ->icon(fn ($state) => match ($state) {
                                        'paid' => 'heroicon-o-check-circle',
                                        'pending' => 'heroicon-o-clock',
                                        'failed' => 'heroicon-o-x-circle',
                                        default => 'heroicon-o-question-mark-circle',
                                    })
                                    ->formatStateUsing(fn ($state) => match ($state) {
                                        'paid' => 'Payé',
                                        'pending' => 'En attente',
                                        'failed' => 'Échoué',
                                        default => $state ?? 'Non spécifié',
                                    }),
                            ])
                            ->columns(2),

                        Section::make('Informations de Livraison')
                            ->icon('heroicon-o-truck')
                            ->iconColor('info')
                            ->schema([
                                TextEntry::make('shipping_method')
                                    ->label('Méthode de livraison')
                                    ->icon('heroicon-o-cube')
                                    ->badge()
                                    ->color('info')
                                    ->default('Non spécifié'),
                                
                                TextEntry::make('currency')
                                    ->label('Devise')
                                    ->icon('heroicon-o-banknotes')
                                    ->badge()
                                    ->color('gray')
                                    ->default('CFA'),
                            ]),
                    ]),

                Section::make('Notes')
                    ->description('Informations additionnelles')
                    ->icon('heroicon-o-document-text')
                    ->iconColor('gray')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('')
                            ->markdown()
                            ->placeholder('Aucune note')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Dates')
                    ->icon('heroicon-o-clock')
                    ->iconColor('gray')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Commande passée le')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-calendar-days')
                            ->color('success'),
                        
                        TextEntry::make('updated_at')
                            ->label('Dernière modification')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-pencil-square')
                            ->color('gray')
                            ->since(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
