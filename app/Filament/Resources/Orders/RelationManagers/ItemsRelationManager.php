<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Forms;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Item Pesanan';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                // 1. Nama Produk
                TextColumn::make('product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->note),

                // 2. Detail Varian (Bahan & Warna)
                TextColumn::make('bahan')
                    ->label('Bahan')
                    ->toggleable(),
                
                TextColumn::make('warna')
                    ->label('Warna')
                    ->badge()
                    ->color('info'),

                // 3. File Custom (Menampilkan Gambar atau Link)
                ImageColumn::make('custom_file')
                    ->label('File Custom')
                    ->disk('public')
                    ->visibility('public')
                    ->square()
                    ->toggleable()
                    // ->state(function ($record) {
                    //     return Str::replace('custom_uploads/', '', $record->custom_file);
                    // })
                    ->defaultImageUrl(url('/images/placeholder.png')), // Gambar default jika null

                // 4. Harga Satuan
                TextColumn::make('product_price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id'),

                // 5. Quantity
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->alignCenter(),

                // 6. Subtotal
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR', locale: 'id')
                    ->weight('bold'),
            ])
            ->filters([
                //
            ]);
    }
}
