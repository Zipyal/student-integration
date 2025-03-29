<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Application
 *
 * @property int $id
 * @property int $student_id
 * @property int $university_id
 * @property string $status
 * @property string|null $documents_path
 * @property string|null $comments
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Student $student
 * @property-read University $university
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'university_id',
        'status',
        'documents_path',
        'comments'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}