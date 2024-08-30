<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publisher_master';
    protected $guarded = [];

    public function book()
    {
        return $this->hasMany(BookModel::class);
    }
}
