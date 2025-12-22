<?php

namespace App\Filament\Resources\OrderItems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_id')
                    ->required()
                    ->numeric(),
                TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                TextInput::make('product_name')
                    ->required(),
                TextInput::make('product_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('bahan')
                    ->required(),
                TextInput::make('warna')
                    ->default(null),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('custom_file')
                    ->default(null),
                Textarea::make('note')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
