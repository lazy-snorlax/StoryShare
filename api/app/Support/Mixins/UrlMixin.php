<?php

namespace App\Support\Mixins;

use Closure;
use App\Models\Company;
use Illuminate\Http\Request;

class UrlMixin
{
    /**
     * Generate a URL to the frontend application with an optional path.
     *
     * @return \Closure
     */
    public function app(): Closure
    {
        return function (string $path = null): string {
            /** @var \Illuminate\Routing\UrlGenerator $this */
            return $this->to(trim(config('app.js_app_url'), '/').'/'.trim($path, '/'));
        };
    }

    /**
     * Generates a signed URL to the frontend application.
     *
     * @return \Closure
     */
    public function appSigned(): Closure
    {
        return function (string $path, array $signatureParameters, $expires = null, bool $public = false): string {
            /** @var \Illuminate\Routing\UrlGenerator $this */
            $signature = $this->appSignature($signatureParameters, $expires);

            if ($expires) {
                $expires = sprintf('?expires=%s', $this->availableAt($expires));
            }

            return $this->app($path).'/'.$signature.$expires;
        };
    }

    /**
     * Generates a signature for the given parameters and expiration time.
     *
     * @return \Closure
     */
    public function appSignature(): Closure
    {
        return function (array $signatureParameters, $expires = null): string {
            /** @var \Illuminate\Routing\UrlGenerator $this */
            if ($expires) {
                $signatureParameters = $signatureParameters + ['expires' => $this->availableAt($expires)];

                $expires = sprintf('&expires=%s', $this->availableAt($expires));
            }

            ksort($signatureParameters);

            return hash_hmac('sha256', implode('.', $signatureParameters), call_user_func($this->keyResolver));
        };
    }

    /**
     * Determines if the request has a valid signature for the given parameters.
     *
     * @return \Closure
     */
    public function hasValidAppSignature(): Closure
    {
        return function (Request $request, array $signatureParameters): bool {
            if ($expires = $request->get('expires')) {
                $signatureParameters = $signatureParameters + compact('expires');
            }

            ksort($signatureParameters);

            $signature = hash_hmac('sha256', implode('.', $signatureParameters), call_user_func($this->keyResolver));

            return hash_equals($signature, (string) $request->get('signature', '')) &&
                !($expires && now()->getTimestamp() > $expires);
        };
    }
}
