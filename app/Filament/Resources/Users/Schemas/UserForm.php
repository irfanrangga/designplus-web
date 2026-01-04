<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Cek unik kecuali user ini sendiri
                
                // Input Password dengan logika khusus (Hash)
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Otomatis hash saat save
                    ->dehydrated(fn ($state) => filled($state)) // Hanya update jika diisi
                    ->required(fn (string $context): bool => $context === 'create') // Wajib hanya saat create
                    ->maxLength(255),
            ]);
    }
}
