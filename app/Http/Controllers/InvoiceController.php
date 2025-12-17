<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'payment_method' => 'required',
        ]);

        $paymentMethod = $request->input('payment_method');
        // Catatan: Di production, hitung ulang grand_total di server, jangan ambil mentah dari input user untuk keamanan.
        // Untuk contoh ini kita ambil dari request atau set default dummy.
        $grandTotal = $request->input('grand_total', 195000);
        $orderData = json_decode($request->input('order_json'), true);
        
        // Set waktu expire (24 jam dari sekarang)
        $expiryTime = Carbon::now()->addDay();
        
        // Logika Data Pembayaran
        $paymentData = [];

        switch ($paymentMethod) {
            case 'bca':
                $paymentData = [
                    'title' => 'BCA Virtual Account',
                    'icon' => 'assets/icon_bca.png',
                    'account_number' => '880123456789', // Generate VA dummy
                    'is_qris' => false,
                    'steps' => [
                        'Masukkan Kartu ATM BCA & PIN.',
                        'Pilih menu Transaksi Lainnya > Transfer > ke Rekening BCA Virtual Account.',
                        'Masukkan nomor Virtual Account di atas.',
                        'Pastikan detail pembayaran sudah sesuai.',
                        'Ikuti instruksi selanjutnya untuk menyelesaikan transaksi.'
                    ]
                ];
                break;

            case 'mandiri':
                $paymentData = [
                    'title' => 'Mandiri Virtual Account',
                    'icon' => 'assets/icon_mandiri.png',
                    'account_number' => '900123456789', // Generate VA dummy
                    'is_qris' => false,
                    'steps' => [
                        'Login ke aplikasi Livin by Mandiri.',
                        'Pilih menu Bayar > Buat Pembayaran Baru > Multipayment.',
                        'Pilih Penyedia Jasa "Designplus" dan masukkan No VA.',
                        'Konfirmasi nominal pembayaran.',
                        'Masukkan MPIN untuk memproses.'
                    ]
                ];
                break;

            case 'gopay':
                $paymentData = [
                    'title' => 'GoPay / QRIS',
                    'icon' => 'assets/icon_gopay.png',
                    'account_number' => null,
                    'qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=DesignplusPaymentOrder123', // Dummy QR Generator
                    'is_qris' => true,
                    'steps' => [
                        'Buka aplikasi Gojek atau e-wallet lain yang mendukung QRIS.',
                        'Klik menu Bayar / Scan.',
                        'Arahkan kamera ke kode QR di atas.',
                        'Cek detail pembayaran dan klik Bayar.',
                        'Masukkan PIN Anda.'
                    ]
                ];
                break;
        }

        return view('invoice', compact('paymentData', 'grandTotal', 'expiryTime', 'paymentMethod', 'orderData'));
    }
}