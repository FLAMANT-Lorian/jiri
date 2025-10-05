<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    public function jiris(): BelongsTo
    {
        return $this->belongsTo(Jiri::class);
    }

    public function contacts(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
