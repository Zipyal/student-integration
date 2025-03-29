<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class Student
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $country
 * @property string $phone
 * @property string $status
 * @property int|null $university_id
 * @property string|null $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read University|null $university
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Application> $applications
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
        'phone',
        'status',
        'university_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}