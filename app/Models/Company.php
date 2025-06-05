<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use hasFactory;

    //assignable attributes.
    protected $fillable = ['name', 'location'];

    //Relations:

     /**
     * Get all employees that belong to this company.
     * 
     * Relationship: One to Many.
     */
    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
