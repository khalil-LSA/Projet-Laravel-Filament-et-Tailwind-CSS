<?php

namespace App\Filament\Admin\Resources\Brands\Schemas;

use App\Models\Brand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated()
                    ->unique(Brand::class, ignoreRecord: true),
                FileUpload::make('image')
                    ->image()
                    ->directory('brands'),
                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}
