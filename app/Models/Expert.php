<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Expert extends Model
{
    use HasFactory;
    protected $table = "experts";
    protected $fillable = [
        'price',
        'image_url',
        'phone',
        'address',
        'details',
        'rating',
        'category_id',
        'user_id',
    ];

    protected $primaryKey = "id";

    public function users() {
        return $this->belongsTo(User::class);
    }

    // public function categories() {
    //     return $this->hasMany(Category::class);
    // }

}
