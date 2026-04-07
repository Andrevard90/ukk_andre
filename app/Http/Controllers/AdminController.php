<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $data = Aspirasi::with('user','kategori')->get();
        return view('admin.dashboard', compact('data'));
    }

    public function update(Request $r, $id){
        $a = Aspirasi::find($id);
        $a->status = $r->status;
        $a->feedback = $r->feedback;
        $a->save();

        return back();
    }
}