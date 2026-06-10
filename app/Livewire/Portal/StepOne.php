<?php

namespace App\Livewire\Portal;

use App\Models\Hospital;
use App\Notifications\HospitalDisqualified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class StepOne extends Component
{
    // Account fields
    public string $hospital_name        = '';
    public string $cac_number           = '';
    public string $email                = '';
    public string $phone                = '';
    public string $password             = '';
    public string $password_confirmation = '';

    // Pre-eligibility fields
    public string $ownership_type          = '';
    public int    $number_of_beds          = 0;
    public float  $insurance_revenue_pct   = 0;

    // UI state
    public bool   $submitted        = false;
    public array  $ineligibleReasons = [];

    protected function rules(): array
    {
        return [
            'hospital_name'           => 'required|string|min:3|max:255',
            'cac_number'              => 'required|string|unique:hospitals,cac_number',
            'email'                   => 'required|email|unique:hospitals,email',
            'phone'                   => 'required|string|min:10|max:20',
            'password'                => 'required|string|min:8|confirmed',
            'ownership_type'          => 'required|in:public,private',
            'number_of_beds'          => 'required|integer|min:1',
            'insurance_revenue_pct'   => 'required|numeric|min:0|max:100',
        ];
    }

    protected array $messages = [
        'cac_number.unique'  => 'A hospital with this CAC number already exists.',
        'email.unique'       => 'An account with this email already exists. Please log in.',
        'password.confirmed' => 'Passwords do not match.',
    ];

    public function submit(): void
    {
        $this->validate();

        // Check pre-eligibility
        $reasons = [];
        if ($this->number_of_beds < 50) {
            $reasons[] = 'Hospital must have a minimum of 50 beds. You entered ' . $this->number_of_beds . '.';
        }
        if ($this->insurance_revenue_pct < 20) {
            $reasons[] = 'At least 20% of revenue must come from health insurance. You entered ' . $this->insurance_revenue_pct . '%.';
        }

        $isEligible = empty($reasons);

        // Create the hospital account regardless (so they can log back in)
        $hospital = Hospital::create([
            'hospital_name'          => $this->hospital_name,
            'cac_number'             => $this->cac_number,
            'email'                  => $this->email,
            'phone'                  => $this->phone,
            'password'               => Hash::make($this->password),
            'ownership_type'         => $this->ownership_type,
            'number_of_beds'         => $this->number_of_beds,
            'insurance_revenue_pct'  => $this->insurance_revenue_pct,
            'is_eligible'            => $isEligible,
            'ineligibility_reasons'  => $reasons,
            'application_step'       => $isEligible ? 'step2' : 'step1',
        ]);

        Auth::guard('hospital')->login($hospital);

        $hospital->sendEmailVerificationNotification();

        if (!$isEligible) {
            $this->ineligibleReasons = $reasons;
            $this->submitted = true;

            $hospital->notify(new HospitalDisqualified($hospital, $reasons));

            return;
        }

        // Redirect to Step 2
        $this->redirect(route('portal.apply.step2'));
    }

    public function render()
    {
        return view('livewire.portal.step-one')
            ->layout('layouts.portal');
    }
}
