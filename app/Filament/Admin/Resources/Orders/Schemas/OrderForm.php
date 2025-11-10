<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ========================================
                // SECTION: CLIENT
                // ========================================
                Select::make('user_id')
                    ->label('Client')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()      
                    ->preload()
                    ->prefixIcon('heroicon-o-user')
                    ->columnSpan(2),

                // ========================================
                // SECTION: MONTANTS
                // ========================================
                TextInput::make('grand_total')
                    ->label('Total général')
                    ->numeric()
                    ->prefix('CFA')
                    ->placeholder('0')
                    ->required()
                    ->prefixIcon('heroicon-o-currency-dollar')
                    ->columnSpan(1),

                TextInput::make('shipping_amount')
                    ->label('Frais de livraison')
                    ->numeric()
                    ->prefix('CFA')
                    ->placeholder('0')
                    ->default(0)
                    ->prefixIcon('heroicon-o-truck')
                    ->columnSpan(1),

                TextInput::make('currency')
                    ->label('Devise')
                    ->default('CFA')
                    ->maxLength(10)
                    ->prefixIcon('heroicon-o-banknotes')
                    ->columnSpan(1),

                // ========================================
                // SECTION: PAIEMENT
                // ========================================
                Select::make('payment_method')
                    ->label('Méthode de paiement')
                    ->options([
                        'stripe' => 'Stripe',
                        'cod' => 'Paiement à la livraison',
                        'bank_transfer' => 'Virement bancaire',
                        'mobile_money' => 'Mobile Money',
                    ])
                    ->required()
                    ->prefixIcon('heroicon-o-credit-card')
                    ->columnSpan(1),

                Select::make('payment_status')
                    ->label('Statut du paiement')
                    ->options([
                        'pending' => 'En attente',
                        'paid' => 'Payé',
                        'failed' => 'Échoué',
                        'refunded' => 'Remboursé',
                    ])
                    ->required()
                    ->default('pending')
                    ->prefixIcon('heroicon-o-check-circle')
                    ->columnSpan(1),

                // ========================================
                // SECTION: LIVRAISON
                // ========================================
                Select::make('status')
                    ->label('Statut de la commande')
                    ->options([
                        'new' => 'Nouvelle',
                        'processing' => 'En traitement',
                        'shipped' => 'Expédiée',
                        'delivered' => 'Livrée',
                        'canceled' => 'Annulée',
                    ])
                    ->required()
                    ->default('new')
                    ->prefixIcon('heroicon-o-clipboard-document-list')
                    ->columnSpan(1),

                TextInput::make('shipping_method')
                    ->label('Méthode de livraison')
                    ->maxLength(255)
                    ->placeholder('Ex: Livraison standard, Express, etc.')
                    ->prefixIcon('heroicon-o-truck')
                    ->columnSpan(1),

                // ========================================
                // SECTION: NOTES
                // ========================================
                Textarea::make('notes')
                    ->label('Notes de commande')
                    ->rows(4)
                    ->placeholder('Ajoutez des notes ou instructions spéciales pour cette commande...')
                    ->columnSpanFull(),
            ]);
    }
}
