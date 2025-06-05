<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    //assignable attributes
    protected $fillable = [
        'name',
        'email',
        'position',
        'company_id',
        'manager_id',
        'country',
        'state',
        'city',
    ];

    //Relations

    /**
     * 1. Relationship: One to One.
     */

    public function company(){
        return $this->belongsTo(Company::class);
    }

    /**
     * 2. Relationship: One to One(One employee has One manager).
     */

    public function manager(){
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     *3. Relationship: One to Many(One manager has many subordinates).
     */
    public function subordinates(){
        return $this->hasMany(Employee::class, 'manager_id');
    }
}
