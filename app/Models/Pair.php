<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pair extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function matcher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'matcher_id');
    }

    public function matchee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'matchee_id');
    }
}
