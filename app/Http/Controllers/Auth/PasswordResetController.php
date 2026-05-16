<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Mail\PasswordResetOtpEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Show email request form
    public function showRequestForm()
    {
        return view('auth.password.request-reset');
    }

    // Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        // Check if user is not an admin/staff
        $user = User::where('email', $request->email)->first();
        if (in_array($user->role, ['admin', 'super_admin', 'inventory_manager', 'delivery_agent', 'delivery'])) {
            return back()->withErrors(['email' => 'Password reset is not available for staff accounts. Please contact your administrator.']);
        }

        // Delete old OTPs for this email
        PasswordResetOtp::where('email', $request->email)->delete();

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP with 10-minute expiration
        PasswordResetOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP email
        try {
            Mail::to($request->email)->send(new PasswordResetOtpEmail($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        return redirect()->route('password.verify.form')->with([
            'email' => $request->email,
            'success' => 'OTP has been sent to your email address.',
        ]);
    }

    // Show OTP verification form
    public function showVerifyForm()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.password.verify-otp');
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }

        if ($otpRecord->isExpired()) {
            $otpRecord->delete();
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // OTP is valid, redirect to password reset form
        return redirect()->route('password.reset.form')->with([
            'email' => $request->email,
            'otp_verified' => true,
        ]);
    }

    // Show password reset form
    public function showResetForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.password.reset-password');
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify OTP record still exists
        $otpRecord = PasswordResetOtp::where('email', $request->email)->first();
        if (!$otpRecord) {
            return redirect()->route('password.request')->withErrors(['email' => 'Session expired. Please start again.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete OTP record
        $otpRecord->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully. You can now login with your new password.');
    }
}
