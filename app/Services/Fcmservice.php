<?php

namespace App\Services;

use App\Models\MemberDeviceToken;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FcmNotification;

class FcmService
{
    protected $messaging;

    public function __construct()
    {
        $credentialsPath = config('services.firebase.credentials');

        $factory = (new Factory())->withServiceAccount($credentialsPath);

        $this->messaging = $factory->createMessaging();
    }

    /**
     * Kirim notifikasi ke SEMUA device member yang terdaftar.
     *
     * $data bisa dipakai buat bawa info tambahan ke app (misalnya
     * announcement_id) supaya nanti bisa dipakai untuk deep-link
     * saat notifikasi di-tap.
     */
    public function sendToAllMembers(string $title, string $body, array $data = []): void
    {
        $tokens = MemberDeviceToken::pluck('token')->toArray();

        if (empty($tokens)) {
            return;
        }

        // FCM multicast dibatasi maksimal 500 token per request.
        foreach (array_chunk($tokens, 500) as $chunk) {
            try {
                $message = CloudMessage::new()
                    ->withNotification(FcmNotification::create($title, $body))
                    ->withData($data);

                $result = $this->messaging->sendMulticast($message, $chunk);

                // Bersihkan token yang sudah gak valid (uninstall app,
                // dsb) supaya tabel gak numpuk token mati.
                foreach ($result->invalidTokens() as $invalidToken) {
                    MemberDeviceToken::where('token', $invalidToken)->delete();
                }
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim FCM push notification: ' . $e->getMessage());
            }
        }
    }
}
