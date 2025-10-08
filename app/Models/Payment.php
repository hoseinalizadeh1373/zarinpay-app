<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'item','name','phone','amount','authority','ref_id','status','meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];
}
