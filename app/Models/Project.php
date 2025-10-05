<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function jiris(): BelongsToMany
    {
        return $this->belongsToMany(Jiri::class, 'homeworks');
    }

    public function homeworks():HasOne
    {
        return $this->hasOne(Homework::class);
    }
}
