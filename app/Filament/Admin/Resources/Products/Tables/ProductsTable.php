<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use App\Models\Brand;
use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(15)
            ->paginationPageOptions([10, 15, 25, 50, 100])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('images')
                    ->label('Image')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(1)
                    ->height(50)
                    ->width(50)
                    ->defaultImageUrl(asset('images/placeholder.png'))
                    ->extraImgAttributes(['class' => 'ring-2 ring-primary-500 shadow-lg']),
                TextColumn::make('name')
                    ->label('Produit')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg')
                    ->icon('heroicon-o-shopping-bag')
                    ->iconColor('primary')
                    ->limit(30)
                    ->wrap()
                    ->description(fn ($record) => 'Réf: ' . $record->slug)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-tag'),
                TextColumn::make('brand.name')
                    ->label('Marque')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-building-office'),
                TextColumn::make('price')
                    ->label('Prix')
                    ->numeric(decimalPlaces: 0, thousandsSeparator: ' ')
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold')
                    ->size('lg')
                    ->color('success')
                    ->icon('heroicon-o-currency-dollar')
                    ->tooltip('Prix en CFA'),
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->size('lg'),
                IconColumn::make('in_stock')
                    ->label('Stock')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->size('lg'),
                IconColumn::make('is_featured')
                    ->label('Vedette')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('primary')
                    ->falseColor('gray')
                    ->size('lg')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('on_sale')
                    ->label('Promo')
                    ->boolean()
                    ->trueIcon('heroicon-o-bolt')
                    ->falseIcon('heroicon-o-bolt-slash')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->size('lg')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filtre par catégorie (relation)
                SelectFilter::make('category')
                    ->label('Catégorie')
                    ->relationship('category', 'name')
                    ->indicator('Catégorie'),

                // Filtre par marque (relation)
                SelectFilter::make('brand')
                    ->label('Marque')
                    ->relationship('brand', 'name')
                    ->indicator('Marque'),

                // Filtre pour les produits actifs
                Filter::make('is_active')
                    ->label('Produits actifs')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->indicator('Actifs'),

                // Filtre pour les produits vedettes
                Filter::make('is_featured')
                    ->label('Produits vedettes')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true))
                    ->indicator('Vedettes'),

                // Filtre pour les produits en stock
                Filter::make('in_stock')
                    ->label('En stock')
                    ->query(fn (Builder $query): Builder => $query->where('in_stock', true))
                    ->indicator('En stock'),

                // Filtre pour les produits en promotion
                Filter::make('on_sale')
                    ->label('En promotion')
                    ->query(fn (Builder $query): Builder => $query->where('on_sale', true))
                    ->indicator('En promotion'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Voir')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->modalHeading('Détails du produit')
                        ->modalWidth('4xl')
                        ->modalContent(view('filament.resources.product-view-modal')),
                    EditAction::make()
                        ->label('Modifier')
                        ->icon('heroicon-o-pencil')
                        ->color('primary'),
                    DeleteAction::make()
                        ->label('Supprimer')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Supprimer le produit')
                        ->modalDescription('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')
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
