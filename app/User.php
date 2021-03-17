<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
   // specify fillables
   protected $fillable = ['name','email','phone', 'is_admin','password'];
}
