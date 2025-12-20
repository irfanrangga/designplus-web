<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('harga')
                    ->required()
                    ->numeric(),
                TextInput::make('kategori')
                    ->required(),
                TextInput::make('file')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
            ]);
    }
}
