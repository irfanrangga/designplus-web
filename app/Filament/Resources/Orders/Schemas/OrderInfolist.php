<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\PaymentStatus;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Nama Customer')
                    ->icon('heroicon-o-user'),
                TextEntry::make('number'),
                TextEntry::make('total_price')
                    ->money('idr', locale:'id'),
                TextEntry::make('payment_status')
                    ->formatStateUsing( fn ($state) => PaymentStatus::from($state)->label())
                    ->color(fn ($state) => PaymentStatus::from($state)->color())
                    ->badge(),
                TextEntry::make('order_status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
