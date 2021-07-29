<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitMember extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone_number', 'gender', 'jenis_debit', 'card_number'];

}

