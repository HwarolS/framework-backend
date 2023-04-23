<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'created_by_id'
    ];

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'label_content_relationships', 'content_id', 'label_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }
}