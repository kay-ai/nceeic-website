<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationDocument extends Model
{
    protected $fillable = [
        'application_id', 'document_type', 'original_filename',
        'stored_path', 'mime_type', 'file_size',
        'verification_status', 'rejection_reason',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(GrantApplication::class, 'application_id');
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

    public function getDocumentTypeLabelAttribute(): string
    {
        return match($this->document_type) {
            'financial_statements'       => 'Financial Statements (Last 3 Years)',
            'energy_consumption_report'  => 'Energy Consumption Report',
            'fuel_expenditure_report'    => 'Fuel Expenditure Report',
            'iso_certification'          => 'ISO Certification Evidence',
            'management_certifications'  => 'Management Certifications',
            'cofinancing_proof'          => 'Co-financing Proof',
            default                      => ucwords(str_replace('_', ' ', $this->document_type)),
        };
    }
}
