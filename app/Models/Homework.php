<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Homework extends Model
{
    protected $table = 'homeworks';

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'implementations');
    }

    public function jiris(): BelongsTo
    {
        return $this->belongsTo(Jiri::class);
    }

    public function projects():HasOne
    {
        return $this->hasOne(Project::class);
    }

    public function implementations(): HasMany
    {
        return $this->hasMany(Implementation::class);
    }
}
