<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'question_id', 'option_id', 'comment', 'user_id'
    ];

    protected $casts = ['option_id'];

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function options()
    {
        return $this->belongsToMany(Option::class)->withTimestamps();
    }
    // Uma questão pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}