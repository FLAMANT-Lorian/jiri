<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Implementation extends Model
{
    public function contacts(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function homeworks(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
