<?php
// app/Http/Requests/HospitalEmailVerificationRequest.php

namespace App\Http\Requests;

use App\Models\Hospital;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HospitalEmailVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Hospital $hospital */
        $hospital = Auth::guard('hospital')->user();

        if (!$hospital) {
            return false;
        }

        if (!hash_equals(
            (string) $hospital->getKey(),
            (string) $this->route('id')
        )) {
            return false;
        }

        if (!hash_equals(
            sha1($hospital->getEmailForVerification()),
            (string) $this->route('hash')
        )) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function fulfill(): void
    {
        /** @var Hospital $hospital */
        $hospital = Auth::guard('hospital')->user();

        if (!$hospital->hasVerifiedEmail()) {
            $hospital->markEmailAsVerified();
            event(new Verified($hospital));
        }
    }
}
