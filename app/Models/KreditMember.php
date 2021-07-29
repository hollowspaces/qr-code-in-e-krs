<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KreditMember extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'address', 'phone_number', 'gender', 'jenis_kredit', 'card_number'];

}

