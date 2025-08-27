<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $guarded = ["id","created_at","updated_at"];
    protected function casts(): array
    {
        return [
            'token' => 'encrypted',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
