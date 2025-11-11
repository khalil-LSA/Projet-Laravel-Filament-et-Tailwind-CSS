<?php

namespace App\Filament\Admin\Resources\Categories\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(15)
            ->paginationPageOptions([10, 15, 25, 50, 100])
            ->striped()
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl('/images/placeholder.png')
                    ->extraImgAttributes(['class' => 'ring-2 ring-info-500 shadow-lg']),
                
                TextColumn::make('name')
                    ->label('Nom de la catégorie')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg')
                    ->icon('heroicon-o-folder')
                    ->iconColor('info')
                    ->description(fn ($record) => $record->products()->count() . ' produit(s)')
                    ->tooltip('Cliquez pour voir les détails'),
                
                TextColumn::make('slug')
                    ->label('URL (Slug)')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('URL copiée!')
                    ->copyMessageDuration(1500)
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-o-link')
                    ->toggleable(isToggledHiddenByDefault: false),
                
                IconColumn::make('is_active')
                    ->label('Statut')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->size('xl')
                    ->alignCenter(),
                
                TextColumn::make('products_count')
                    ->label('Produits')
                    ->counts('products')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-shopping-bag')
                    ->alignCenter()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->iconColor('success')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->icon('heroicon-o-clock')
                    ->iconColor('gray')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                // Filtre pour les catégories actives
                Filter::make('is_active')
                    ->label('Catégories actives')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->indicator('Actives'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Voir')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->modalHeading('Détails de la catégorie')
                        ->modalWidth('3xl')
                        ->modalContent(view('filament.resources.category-view-modal')),
                    EditAction::make()
                        ->label('Modifier')
                        ->icon('heroicon-o-pencil')
                        ->color('primary'),
                    DeleteAction::make()
                        ->label('Supprimer')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Supprimer la catégorie')
                        ->modalDescription('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.')
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
