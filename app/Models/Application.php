<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}