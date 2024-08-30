<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'book_master';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function publisher()
    {
        return $this->belongsTo(PublisherModel::class, 'publisher_id');
    }

    public function writer()
    {
        return $this->belongsTo(WriterModel::class, 'writer_id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function user_updated()
    {
        return $this->belongsTo(User::class, 'user_updated');
    }
}
