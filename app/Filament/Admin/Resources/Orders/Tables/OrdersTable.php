<?php

namespace App\Filament\Admin\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(15)
            ->paginationPageOptions([10, 15, 25, 50, 100])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('N° Commande')
                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 6, '0', STR_PAD_LEFT))
                    ->weight('bold')
                    ->size('lg')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-hashtag')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->iconColor('info')
                    ->description(fn ($record) => $record->user->email ?? 'N/A')
                    ->tooltip('Voir le profil du client'),
                
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'canceled' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'new' => 'heroicon-o-sparkles',
                        'processing' => 'heroicon-o-clock',
                        'shipped' => 'heroicon-o-truck',
                        'delivered' => 'heroicon-o-check-circle',
                        'canceled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Nouvelle',
                        'processing' => 'En traitement',
                        'shipped' => 'Expédiée',
                        'delivered' => 'Livrée',
                        'canceled' => 'Annulée',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('grand_total')
                    ->label('Montant total')
                    ->numeric(decimalPlaces: 0, thousandsSeparator: ' ')
                    ->weight('bold')
                    ->size('lg')
                    ->color('success')
                    ->icon('heroicon-o-currency-dollar')
                    ->sortable()
                    ->alignEnd(),
                
                TextColumn::make('payment_method')
                    ->label('Mode de paiement')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-credit-card')
                    ->formatStateUsing(fn ($state) => $state ? ucfirst($state) : 'N/A')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                TextColumn::make('payment_status')
                    ->label('Paiement')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'info',
                        'failed', 'canceled', 'unpaid' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn ($state) => $state === 'paid' ? 'heroicon-o-check-badge' : 'heroicon-o-clock')
                    ->formatStateUsing(fn ($state) => $state ? ucfirst($state) : 'En attente')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                TextColumn::make('items_count')
                    ->label('Articles')
                    ->counts('items')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-shopping-bag')
                    ->alignCenter()
                    ->sortable()
                    ->tooltip('Nombre d\'articles'),
                
                TextColumn::make('shipping_method')
                    ->label('Livraison')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-o-truck')
                    ->formatStateUsing(fn ($state) => $state ? ucfirst($state) : 'N/A')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->label('Commandé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->iconColor('success')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Mis à jour')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->icon('heroicon-o-clock')
                    ->iconColor('gray')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Voir')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->modalHeading('Détails de la commande')
                        ->modalWidth('3xl'),
                    EditAction::make()
                        ->label('Modifier')
                        ->icon('heroicon-o-pencil')
                        ->color('primary'),
                    DeleteAction::make()
                        ->label('Supprimer')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Supprimer la commande')
                        ->modalDescription('Êtes-vous sûr de vouloir supprimer cette commande ? Cette action est irréversible.')
                        ->modalSubmitActionLabel('Oui, supprimer'),
                ])
                ->label('Actions')
                ->icon('heroicon-o-ellipsis-vertical')
                ->size('sm')
                ->color('gray')
                ->button(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
