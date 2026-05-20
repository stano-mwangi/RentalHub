<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function homeAdmin()
    {
        $admin = Auth::user();
        $properties = Property::where('user_id', $admin->id)->latest()->paginate(10);
        $stats = [
            'total' => $properties->total(),
            'vacant' => $properties->where('status', 'vacant')->count(),
            'occupied' => $properties->where('status', 'occupied')->count(),
        ];
        return view('admin.adminhome', compact('admin', 'properties', 'stats'));
    }
}
