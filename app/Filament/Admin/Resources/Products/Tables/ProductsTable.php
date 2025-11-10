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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(15)
            ->paginationPageOptions([10, 15, 25, 50])
            ->columns([
                TextColumn::make('name')
                    ->label('Produit')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 25) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->label('Marque')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Prix')
                    ->suffix(' CFA')
                    ->sortable()
                    ->alignEnd(),
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
                IconColumn::make('in_stock')
                    ->label('Stock')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
                IconColumn::make('is_featured')
                    ->label('Vedette')
                    ->boolean()
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('on_sale')
                    ->label('Promo')
                    ->boolean()
                    ->trueColor('info')
                    ->falseColor('gray')
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
                // Filtre par catégorie
                SelectFilter::make('category_id')
                    ->label('Catégorie')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->indicator('Catégorie'),

                // Filtre par marque
                SelectFilter::make('brand_id')
                    ->label('Marque')
                    ->options(Brand::all()->pluck('name', 'id'))
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
                        ->color('warning'),
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
