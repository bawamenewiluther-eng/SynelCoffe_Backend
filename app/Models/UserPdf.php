<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class UserPdf extends Model {
    protected $fillable = ['user_id', 'file_path', 'title'];
}