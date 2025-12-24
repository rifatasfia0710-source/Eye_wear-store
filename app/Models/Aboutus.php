<?php

namespace App\Models;
use App\Models\AboutUs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutus extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'about_desc'];
    

public function index()
{
    $aboutuses = AboutUs::all(); // or any query you need
    return view('about.index', compact('aboutuses'));
}

}
