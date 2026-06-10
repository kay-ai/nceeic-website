<?php

namespace App\Livewire\Portal;

use App\Models\GrantApplication;
use App\Services\ScoringService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StepTwo extends Component
{
    // ── A. Hospital Information ───────────────────────────────
    public string $hospital_name       = '';
    public string $hospital_type       = '';
    public string $year_established    = '';
    public string $ownership_type      = '';
    public string $facility_ownership  = '';
    public string $state               = '';
    public string $lga                 = '';
    public string $address             = '';
    public int    $number_of_beds      = 0;
    public int    $number_of_icu_beds  = 0;
    public int    $number_of_active_ors = 0;

    // ── B. Revenue Information ────────────────────────────────
    public float  $total_revenue            = 0;
    public float  $revenue_from_cash        = 0;
    public float  $revenue_from_insurance   = 0;

    // ── C. Energy Consumption ─────────────────────────────────
    public string $grid_connectivity             = '';
    public float  $monthly_diesel_consumption    = 0;
    public float  $monthly_energy_bill           = 0;
    public float  $monthly_energy_consumption_kwh = 0;

    // ── D. Management & Compliance ────────────────────────────
    public string $iso_compliance         = 'none';
    public string $management_practices   = '';
    public string $maintenance_policies   = '';

    // ── E. Financial Capacity ─────────────────────────────────
    public float  $cofinancing_commitment_pct = 0;
    public string $cofinancing_source         = '';
    public bool   $has_maintenance_reserve    = false;
    public float  $maintenance_reserve_amount = 0;

    // ── F. Additional ─────────────────────────────────────────
    public string $additional_comments = '';

    // UI
    public int    $currentSection = 1; // 1-6 for the 6 sections A-F
    public bool   $saving         = false;

    protected function rules(): array
    {
        return [
            // A
            'hospital_name'         => 'required|string',
            'hospital_type'         => 'required|string',
            'year_established'      => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'ownership_type'        => 'required|in:public,private',
            'facility_ownership'    => 'required|in:owned,leased',
            'state'                 => 'required|string',
            'lga'                   => 'required|string',
            'address'               => 'required|string',
            'number_of_beds'        => 'required|integer|min:1',
            'number_of_icu_beds'    => 'required|integer|min:0',
            'number_of_active_ors'  => 'required|integer|min:0',
            // B
            'total_revenue'           => 'required|numeric|min:0',
            'revenue_from_cash'       => 'required|numeric|min:0',
            'revenue_from_insurance'  => 'required|numeric|min:0',
            // C
            'grid_connectivity'               => 'required|in:connected,not_connected,partial',
            'monthly_diesel_consumption'      => 'required|numeric|min:0',
            'monthly_energy_bill'             => 'required|numeric|min:0',
            'monthly_energy_consumption_kwh'  => 'required|numeric|min:0',
            // D
            'iso_compliance'        => 'required|in:full,partial,none',
            'management_practices'  => 'required|string|min:20',
            'maintenance_policies'  => 'required|string|min:20',
            // E
            'cofinancing_commitment_pct' => 'required|numeric|min:0|max:100',
            'cofinancing_source'         => 'required|string',
            'has_maintenance_reserve'    => 'boolean',
            'maintenance_reserve_amount' => 'nullable|numeric|min:0',
        ];
    }

    public function mount(): void
    {
        $hospital = Auth::guard('hospital')->user();

        // Guard: must be eligible
        if (!$hospital->is_eligible) {
            $this->redirect(route('portal.apply'));
            return;
        }

        // Pre-fill from hospital account
        $this->hospital_name    = $hospital->hospital_name;
        $this->ownership_type   = $hospital->ownership_type;
        $this->number_of_beds   = $hospital->number_of_beds;

        // If they have a draft application, restore it
        if ($app = $hospital->application) {
            $this->fill($app->only([
                'hospital_name', 'hospital_type', 'year_established', 'ownership_type',
                'facility_ownership', 'state', 'lga', 'address',
                'number_of_beds', 'number_of_icu_beds', 'number_of_active_ors',
                'total_revenue', 'revenue_from_cash', 'revenue_from_insurance',
                'grid_connectivity', 'monthly_diesel_consumption', 'monthly_energy_bill',
                'monthly_energy_consumption_kwh', 'iso_compliance', 'management_practices',
                'maintenance_policies', 'cofinancing_commitment_pct', 'cofinancing_source',
                'has_maintenance_reserve', 'maintenance_reserve_amount', 'additional_comments',
            ]));
        }
    }

    public function saveDraft(): void
    {
        $this->saving = true;
        $this->upsertApplication('draft');
        $this->saving = false;
        session()->flash('draft_saved', 'Draft saved successfully.');
    }

    public function submit(): void
    {
        $this->validate();

        $application = $this->upsertApplication('submitted');
        $application->submitted_at = now();
        $application->save();

        // Score immediately
        $scoringService = app(ScoringService::class);
        $scoringService->score($application);

        // Update hospital step
        $hospital = Auth::guard('hospital')->user();
        $hospital->update(['application_step' => $application->is_qualified ? 'step3' : 'submitted']);

        if ($application->is_qualified) {
            $this->redirect(route('portal.apply.step3'));
        } else {
            $this->redirect(route('portal.disqualified'));
        }
    }

    private function upsertApplication(string $status): GrantApplication
    {
        $hospital = Auth::guard('hospital')->user();

        $insurancePct = $this->total_revenue > 0
            ? round(($this->revenue_from_insurance / $this->total_revenue) * 100, 2)
            : 0;

        return GrantApplication::updateOrCreate(
            ['hospital_id' => $hospital->id],
            [
                'application_id'               => GrantApplication::generateApplicationId(),
                'hospital_name'                => $this->hospital_name,
                'hospital_type'                => $this->hospital_type,
                'year_established'             => $this->year_established,
                'ownership_type'               => $this->ownership_type,
                'facility_ownership'           => $this->facility_ownership,
                'state'                        => $this->state,
                'lga'                          => $this->lga,
                'address'                      => $this->address,
                'number_of_beds'               => $this->number_of_beds,
                'number_of_icu_beds'           => $this->number_of_icu_beds,
                'number_of_active_ors'         => $this->number_of_active_ors,
                'total_revenue'                => $this->total_revenue,
                'revenue_from_cash'            => $this->revenue_from_cash,
                'revenue_from_insurance'       => $this->revenue_from_insurance,
                'insurance_revenue_pct'        => $insurancePct,
                'grid_connectivity'            => $this->grid_connectivity,
                'monthly_diesel_consumption'   => $this->monthly_diesel_consumption,
                'monthly_energy_bill'          => $this->monthly_energy_bill,
                'monthly_energy_consumption_kwh' => $this->monthly_energy_consumption_kwh,
                'iso_compliance'               => $this->iso_compliance,
                'management_practices'         => $this->management_practices,
                'maintenance_policies'         => $this->maintenance_policies,
                'cofinancing_commitment_pct'   => $this->cofinancing_commitment_pct,
                'cofinancing_source'           => $this->cofinancing_source,
                'has_maintenance_reserve'      => $this->has_maintenance_reserve,
                'maintenance_reserve_amount'   => $this->maintenance_reserve_amount,
                'additional_comments'          => $this->additional_comments,
                'status'                       => $status,
            ]
        );
    }

    public function render()
    {
        $nigerianStates = [
            'Abia','Adamawa','Akwa Ibom','Anambra','Bauchi','Bayelsa','Benue',
            'Borno','Cross River','Delta','Ebonyi','Edo','Ekiti','Enugu','FCT',
            'Gombe','Imo','Jigawa','Kaduna','Kano','Katsina','Kebbi','Kogi',
            'Kwara','Lagos','Nasarawa','Niger','Ogun','Ondo','Osun','Oyo',
            'Plateau','Rivers','Sokoto','Taraba','Yobe','Zamfara',
        ];

        return view('livewire.portal.step-two', compact('nigerianStates'))
            ->layout('layouts.portal');
    }
}
