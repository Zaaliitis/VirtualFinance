<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    public static function generateQRCode(): string

    {
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $user = auth()->user();
        $otpSecret = $user->otp_secret;
        if (empty($otpSecret)) {
            $otpSecret = (new \PragmaRX\Google2FAQRCode\Google2FA)->generateSecretKey();
            $user->otp_secret = $otpSecret;
            $user->save();
        }

        return $google2fa->getQRCodeInline('VirtualFinance Transaction', $user->email, $otpSecret);
    }
    public function verifySecurityKey(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $otpCode = $request->input('otp_secret');
        $otpSecret = $user->otp_secret;


        if ((new \PragmaRX\Google2FA\Google2FA)->verifyKey($otpSecret, $otpCode)) {
            $user->otp_secret_verified = true;
            $user->save();

            $message = ['type' => 'success', 'text' => 'Security key verified successfully.'];
            return redirect()->back()->with('message', $message);
        } else {
            $message = ['type' => 'error', 'text' => 'Invalid security key.'];
            return redirect()->back()->with('message', $message);
        }
    }
}
