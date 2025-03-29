<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class University
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string $description
 * @property string|null $website
 * @property string|null $logo
 * @property int|null $ranking
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Student> $students
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Application> $applications
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'description',
        'website',
        'logo',
        'ranking'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}