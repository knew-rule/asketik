<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            $usertype = Auth()->user()->usertype;
            if ($usertype === 'customer' || $usertype === 'admin' || $usertype === 'superadmin') {
                return view('ui.dashboard.index', [
                    'pageTitle' => 'Dashboard']);
            } else {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }
        } else {
            return view('ui.dashboard.index', [
                'pageTitle' => 'Dashboard']);
        }
    }

    public function post()
    {
        return view("post");
    }
}