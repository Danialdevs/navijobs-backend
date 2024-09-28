<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'company_office_id',
        'service_id',
        'address',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function applicationPrices()
    {
        return $this->hasMany(ApplicationPrice::class);
    }

    // Relationship with ApplicationWorker
    public function assignedWorker()
    {
        return $this->hasOne(ApplicationWorker::class);
    }

    // Define the relationship to the Service model
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
