<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOffice extends Model
{
    use HasFactory;
    protected $fillable = ["name", "address", "company_id"];
}
