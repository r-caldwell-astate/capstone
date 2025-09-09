<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractField extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contract_field';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'field_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'field_name',
    ];

    /**
     * Defines the relationship that a ContractField has many ContractFieldValues.
     */
    public function values(): HasMany
    {
        // Note: We will create the ContractFieldValue model next.
        return $this->hasMany(ContractFieldValue::class, 'field_id');
    }
}