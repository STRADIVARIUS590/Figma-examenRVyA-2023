<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'index',
        'x',
        'y',
        'h',
        'w',
        'opacity',
        'border_size',
        'border_opacity',
        'radius_corner',
        'font_size',
        'type',
        'color',
        'border_color',
        'text',
        'visible',
        'draw_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function draw()
    {
        return $this->belongsTo(Draw::class);
    }
}
