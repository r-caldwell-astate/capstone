<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractFieldValue extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contract_field_value';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'field_value_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'contract_id',
        'version_id',
        'field_id',
        'field_value',
    ];

    /**
     * Defines the relationship that a ContractFieldValue belongs to a Contract.
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * Defines the relationship that a ContractFieldValue belongs to a ContractVersion.
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(ContractVersion::class, 'version_id');
    }

    /**
     * Defines the relationship that a ContractFieldValue belongs to a ContractField.
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(ContractField::class, 'field_id');
    }
}