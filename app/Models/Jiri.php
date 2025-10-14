<?php

namespace App\Models;

use App\Enums\ContactRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jiri extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'description', 'user_id'];

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'attendances');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function evaluators(): BelongsToMany
    {
        return $this->contacts()->wherePivot('role', '=', ContactRoles::Evaluators->value);
    }

    public function evaluated(): BelongsToMany
    {
        return $this->contacts()->wherePivot('role', '=', ContactRoles::Evaluated->value);
    }

    public function projects():BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'homeworks');
    }

    public function homeworks():HasMany
    {
        return $this->hasMany(Homework::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
