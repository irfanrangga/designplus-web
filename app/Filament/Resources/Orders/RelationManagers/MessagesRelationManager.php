<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('message')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('message')
        // Gunakan Split & Stack untuk membuat layout bebas (bukan baris kolom biasa)
        ->columns([
            Stack::make([
                Split::make([
                    // Tampilkan Nama Pengirim
                    TextColumn::make('sender_name')
                        ->state(fn ($record) => $record->is_admin_reply ? 'Admin Support' : $record->user->name)
                        ->weight('bold')
                        ->color(fn ($record) => $record->is_admin_reply ? 'primary' : 'success'), // Beda warna nama
                    
                    // Tampilkan Waktu
                    TextColumn::make('created_at')
                        ->since()
                        ->color('gray')
                        ->alignRight(),
                ]),
                
                // Tampilkan Isi Pesan
                TextColumn::make('message')
                    ->extraAttributes(fn ($record) => [
                        'class' => $record->is_admin_reply 
                            ? 'bg-blue-50 p-3 rounded-lg mt-1'  // Style bubble chat Admin
                            : 'bg-gray-50 p-3 rounded-lg mt-1', // Style bubble chat User
                    ])
                    ->html(),
            ])->space(3), // Jarak antar chat
        ])
        ->contentGrid([
            'md' => 1, // Tampilkan 1 kolom ke bawah (seperti list)
        ])
        ->headerActions([
            CreateAction::make()
                ->label('Balas Pesan')
                ->mutateFormDataUsing(function (array $data) {
                    $data['is_admin_reply'] = true; // Otomatis set ini pesan admin
                    $data['user_id'] = Auth::id(); // Atau null, tergantung logic Anda
                    return $data;
                }),
        ])
        ->poll('5s'); // AUTO REFRESH SETIAP 5 DETIK (Penting untuk Chat)
    }
}
