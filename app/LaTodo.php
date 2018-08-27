<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaTodo extends Model
{
    //table
    protected $table = 'la_todo';

    // trait : SoftDelete doesn't use anymore  refer: https://stackoverflow.com/questions/24949655/what-causes-the-error-not-found-softdeletingtrait-class
    //use SoftDeletingTrait;
    //protected $dates = ['deleted_at'];
    //change namespace refer : https://stackoverflow.com/questions/38518175/laravel-5-2-soft-delete-does-not-work

    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    


}
