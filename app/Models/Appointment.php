<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = "appointments";
    protected $fillable = [
        'client_id',
        'expert_id',
        'day'
    ];

    protected $primaryKey = "id"; 

    public function users() {
        return $this->belongsTo(User::class);
    }
}
