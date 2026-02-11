<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
  protected $fillable = [
    'client_id',
    'title',
    'description',
    'trade',
    'budget',
    'location',
    'status'
];

}
