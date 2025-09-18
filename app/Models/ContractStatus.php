<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractStatus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contract_status';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'status_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status_name',
    ];

    /**
     * A status has many contracts (FK: contracts.status_id → contract_status.status_id).
     */
    public function contracts(): HasMany
    {
        // Explicit local key helps with non-standard PK names
        return $this->hasMany(Contract::class, 'status_id', 'status_id');
    }
}