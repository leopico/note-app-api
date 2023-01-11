<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributeNote extends Model
{
    use HasFactory;
    protected $fillable = ['contributer_id', 'contributed_id', 'note_id'];
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
    public function contributeUser()
    {
        return $this->belongsTo(User::class, 'contributer_id');
    }
    public function receiveUser()
    {
        return $this->belongsTo(User::class, 'contributed_id');
    }
}
