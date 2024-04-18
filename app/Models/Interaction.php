<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function interactor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'interactor_id');
    }
}
