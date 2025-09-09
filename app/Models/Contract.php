<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * We must specify this because our table name 'contract' is singular,
     * and Laravel's default is the plural 'contracts'.
     *
     * @var string
     */
    protected $table = 'contract';

    /**
     * The primary key associated with the table.
     * We must specify this because our primary key is 'contract_id', not 'id'.
     *
     * @var string
     */
    protected $primaryKey = 'contract_id';

    /**
     * The attributes that are mass assignable. This is a security feature
     * to protect against unwanted data being saved.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'recipient_name',
        'recipient_email',
        'sent_date',
        'signed_date',
        'user_id',
        'status_id',
    ];

    /**
     * Defines the relationship that a Contract belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Defines the relationship that a Contract belongs to a ContractStatus.
     */
    public function status(): BelongsTo
    {
        // Note: We will create the ContractStatus model next.
        return $this->belongsTo(ContractStatus::class, 'status_id');
    }

    /**
     * Defines the relationship that a Contract has many ContractVersions.
     */
    public function versions(): HasMany
    {
        // Note: We will create the ContractVersion model next.
        return $this->hasMany(ContractVersion::class, 'contract_id');
    }
}