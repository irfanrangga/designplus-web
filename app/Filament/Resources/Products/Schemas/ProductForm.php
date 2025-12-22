<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Ramsey\Collection\Set;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->placeholder('Contoh: Kaos Polos')
                    ->required(),
                TextInput::make('harga')
                    ->placeholder('Contoh: 50000')
                    ->prefix('Rp')
                    ->required()
                    ->numeric(),
                Select::make('kategori')
                    ->label('Pilih Kategori')
                    ->options(array_combine(array_keys(Product::Bahan), array_keys(Product::Bahan)))
                    ->live()
                    ->searchable()
                    ->required(),
                TextInput::make('bahan')
                    ->placeholder('Contoh: Cotton Combed 24s, Polyester, Dri-Fit')
                    ->required(),
                TextInput::make('warna')
                    ->placeholder('Contoh: Hitam, Merah, Biru')
                    ->required(),
                TextInput::make('file')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->maxValue(5),
            ]);
    }
}
