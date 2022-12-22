<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Available_time extends Model
{
    use HasFactory;
    protected $table = "available_times";
    protected $fillable = [
        'user_id',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
    ];

    protected $primaryKey = "id";

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
