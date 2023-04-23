<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label_Content_Relationship extends Model
{
    use HasFactory;

    protected $table = 'labels_contents_relationship';

    protected $fillable = [
        'label_id',
        'content_id',
    ];

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }
}