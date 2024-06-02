<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    use HasFactory;
    protected $fillable = ['company_info_fk' , 'name' , 'designation' , 'contact_number' , 'email_id'];

    // Define the inverse relationship
    public function companyInfo()
    {
        return $this->belongsTo(CompanyInfo::class, 'company_info_fk');
    }
}
