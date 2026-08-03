<?php

namespace App\Http\Controllers;

class QrCodeController extends Controller
{
    // Menampilkan QR Code yang mengarah ke formulir buku tamu publik. QR ini yang dicetak di meja resepsionis.
    public function show()
    {
        $url = route('guest.form');

        return view('kunjungan.qrcode', compact('url'));
    }
}
