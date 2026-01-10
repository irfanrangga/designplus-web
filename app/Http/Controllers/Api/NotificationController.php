<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Filament\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Filament\Notifications\Notification;

class NotificationController extends Controller
{
    public function newChat(Request $request)
    {
        $senderName = $request->input('sender_name');
        $messagePreview = $request->input('message');
        $userId = $request->input('user_id');

        // 1. Cari Siapa Admin yang harus dikirim notifikasi?
        $recipients = User::where('email', 'admin@gmail.com')->get(); 

        // 2. Buat Notifikasi Filament
        foreach ($recipients as $recipient) {
            Notification::make()
                ->title('Pesan Baru dari ' . $senderName)
                ->body($messagePreview)
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('info')
                ->actions([
                    // Tombol untuk langsung buka halaman chat user tersebut
                    Action::make('view')
                        ->label('Balas')
                        ->url('/admin/users/' . $userId . '/edit?activeRelationManager=0'),
                ])
                ->sendToDatabase($recipient);
        }

        return response()->json(['status' => 'success']);
    }
}
