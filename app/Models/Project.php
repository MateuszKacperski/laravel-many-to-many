<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'type_id'];
    public function getFormatedDate($column, $format = 'd-m-Y'){
        return Carbon::create ($this->$column)->format($format);
    }
  
    public function printImage(){
        return asset('storage/' . $this->image);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }
}
