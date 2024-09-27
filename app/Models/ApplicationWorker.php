<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationWorker extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'application_id'];

    // Define the relationship to the User (worker)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
