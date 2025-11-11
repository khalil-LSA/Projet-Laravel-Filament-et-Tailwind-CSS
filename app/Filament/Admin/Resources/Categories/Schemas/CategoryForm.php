<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations de la catégorie')
                    ->description('Définissez les informations principales de votre catégorie')
                    ->icon('heroicon-o-folder')
                    ->iconColor('primary')
                    ->collapsible()
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom de la catégorie')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                                    ->prefixIcon('heroicon-o-tag')
                                    ->prefixIconColor('primary')
                                    ->placeholder('Ex: Électronique, Mode, Alimentation...')
                                    ->helperText('Nom affiché sur le site')
                                    ->columnSpan(1),
                                
                                TextInput::make('slug')
                                    ->label('URL (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Category::class, ignoreRecord: true)
                                    ->prefixIcon('heroicon-o-link')
                                    ->prefixIconColor('success')
                                    ->helperText('Généré automatiquement')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ]),

                Section::make('Image & Visibilité')
                    ->description('Ajoutez une image représentative et gérez l\'affichage')
                    ->icon('heroicon-o-photo')
                    ->iconColor('info')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image de la catégorie')
                            ->image()
                            ->directory('categories')
                            ->imageEditor()
                            ->downloadable()
                            ->helperText('Image affichée dans la navigation')
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Catégorie active')
                            ->helperText('La catégorie sera visible sur le site')
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
