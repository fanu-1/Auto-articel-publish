<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\View\View;

class EntityController extends Controller
{
    public function index(): View
    {
        return view('admin.entities.index', [
            'entities' => Entity::latest()->paginate(15),
        ]);
    }
}
