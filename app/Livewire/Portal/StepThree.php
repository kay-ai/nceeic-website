<?php

namespace App\Livewire\Portal;

use App\Models\ApplicationDocument;
use App\Models\GrantApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class StepThree extends Component
{
    use WithFileUploads;

    public ?GrantApplication $application = null;

    // File upload properties — one per document type
    public $financial_statements       = null;
    public $energy_consumption_report  = null;
    public $fuel_expenditure_report    = null;
    public $iso_certification          = null;
    public $management_certifications  = null;
    public $cofinancing_proof          = null;

    // Confirmation checkbox
    public bool $confirmed = false;

    protected function rules(): array
    {
        return [
            'financial_statements'      => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'energy_consumption_report' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'fuel_expenditure_report'   => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'iso_certification'         => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'management_certifications' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'cofinancing_proof'         => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'confirmed'                 => 'accepted',
        ];
    }

    protected array $messages = [
        'confirmed.accepted'                      => 'You must confirm all information is accurate.',
        'financial_statements.required'           => 'Financial statements are required.',
        'energy_consumption_report.required'      => 'Energy consumption report is required.',
        'fuel_expenditure_report.required'        => 'Fuel expenditure report is required.',
        'cofinancing_proof.required'              => 'Co-financing proof is required.',
        '*.max'                                   => 'File size must not exceed 10MB.',
        '*.mimes'                                 => 'Only PDF, Word, and Excel files are accepted.',
    ];

    public function mount(): void
    {
        $hospital = Auth::guard('hospital')->user();

        // Guard: must have passed scoring
        $this->application = $hospital->application;

        if (!$this->application || !$this->application->is_qualified) {
            $this->redirect(route('portal.apply'));
            return;
        }
    }

    public function submit(): void
    {
        $this->validate();

        $documents = [
            'financial_statements',
            'energy_consumption_report',
            'fuel_expenditure_report',
            'iso_certification',
            'management_certifications',
            'cofinancing_proof',
        ];

        foreach ($documents as $type) {
            if ($this->{$type}) {
                $file = $this->{$type};
                $path = $file->store('grant-documents/' . $this->application->id, 'private');

                ApplicationDocument::updateOrCreate(
                    [
                        'application_id' => $this->application->id,
                        'document_type'  => $type,
                    ],
                    [
                        'original_filename'   => $file->getClientOriginalName(),
                        'stored_path'         => $path,
                        'mime_type'           => $file->getMimeType(),
                        'file_size'           => $file->getSize(),
                        'verification_status' => 'pending',
                    ]
                );
            }
        }

        // Update application status
        $this->application->update([
            'status'         => 'submitted',
            'submitted_at'   => now(),
        ]);

        // Update hospital step
        Auth::guard('hospital')->user()->update(['application_step' => 'submitted']);

        $this->redirect(route('portal.dashboard'));
    }

    public function render()
    {
        $uploadedDocs = $this->application
            ? $this->application->documents->keyBy('document_type')
            : collect();

        return view('livewire.portal.step-three', compact('uploadedDocs'))
            ->layout('layouts.portal');
    }
}
