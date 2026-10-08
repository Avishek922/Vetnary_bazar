<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // 1. Default API Rate Limiter
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // 2. Login: Max 5 attempts per minute per email + IP
        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower((string) $request->input('email'));
            $throttleKey = Str::transliterate($email . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey)->response(function (Request $request, array $headers) {
                $seconds = $headers['Retry-After'] ?? 60;
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Too many login attempts. Please try again in {$seconds} seconds."
                    ], 429, $headers);
                }
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => "Too many login attempts. Please try again in {$seconds} seconds."]);
            });
        });

        // 3. Register: Max 5 attempts per minute per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function (Request $request, array $headers) {
                $seconds = $headers['Retry-After'] ?? 60;
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Too many registration attempts. Please try again in {$seconds} seconds."
                    ], 429, $headers);
                }
                return back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors(['email' => "Too many registration attempts from this IP. Please try again in {$seconds} seconds."]);
            });
        });

        // 4. Password Reset OTP Send: Max 3 OTP requests per minute per email + IP
        RateLimiter::for('otp-send', function (Request $request) {
            $email = Str::lower((string) $request->input('email'));
            $throttleKey = Str::transliterate($email . '|' . $request->ip());

            return Limit::perMinute(3)->by($throttleKey)->response(function (Request $request, array $headers) {
                $seconds = $headers['Retry-After'] ?? 60;
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Too many OTP requests. Please wait {$seconds} seconds before requesting again."
                    ], 429, $headers);
                }
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => "Too many OTP requests. Please wait {$seconds} seconds before requesting again."]);
            });
        });

        // 5. Password Reset OTP Verification: Max 5 attempts per 5 minutes per email + IP
        RateLimiter::for('otp-verify', function (Request $request) {
            $email = Str::lower((string) ($request->input('email') ?: session('email', '')));
            $throttleKey = Str::transliterate($email . '|' . $request->ip());

            return Limit::perMinutes(5, 5)->by($throttleKey)->response(function (Request $request, array $headers) {
                $seconds = $headers['Retry-After'] ?? 300;
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Too many incorrect OTP attempts. Please wait {$seconds} seconds before trying again."
                    ], 429, $headers);
                }
                return back()
                    ->withInput()
                    ->withErrors(['otp' => "Too many incorrect OTP attempts. Please wait {$seconds} seconds before trying again."]);
            });
        });

        // 6. Contact Query Form: Max 3 submissions per minute per IP
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip())->response(function (Request $request, array $headers) {
                $seconds = $headers['Retry-After'] ?? 60;
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Too many messages sent. Please wait {$seconds} seconds before submitting again."
                    ], 429, $headers);
                }
                return back()
                    ->withInput()
                    ->with('error', "Too many messages sent. Please wait {$seconds} seconds before submitting again.");
            });
        });

        // 7. Checkout / Order Placement: Max 5 orders per minute per user/IP
        RateLimiter::for('checkout', function (Request $request) {
            $throttleKey = $request->user()?->id ?: $request->ip();

            return Limit::perMinute(5)->by($throttleKey)->response(function (Request $request, array $headers) {
                $seconds = $headers['Retry-After'] ?? 60;
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Please wait a moment before trying to place an order again."
                    ], 429, $headers);
                }
                return back()
                    ->with('error', "Please wait a moment before trying to place an order again.");
            });
        });

        // 8. Product Reviews: Max 5 reviews per minute per user/IP
        RateLimiter::for('reviews', function (Request $request) {
            $throttleKey = $request->user()?->id ?: $request->ip();

            return Limit::perMinute(5)->by($throttleKey)->response(function (Request $request, array $headers) {
                $seconds = $headers['Retry-After'] ?? 60;
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Too many reviews submitted. Please wait {$seconds} seconds."
                    ], 429, $headers);
                }
                return back()
                    ->with('error', "Too many reviews submitted. Please wait {$seconds} seconds.");
            });
        });
    }
}
