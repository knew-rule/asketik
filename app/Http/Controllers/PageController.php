<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('ui.page.about', [
            'active' => 'About',
            'subPageTitle' => 'WE SALE FRESH COFFEE',
            'pageTitle' => 'About us'
        ]);
    }

    public function contact()
    {
        return view('ui.page.contact', [
            'active' => 'Contact',
            'subPageTitle' => 'GET 24/7 SUPPORT',
            'pageTitle' => 'Contact us'
        ]);
    }


    public function error()
    {
        return view('ui.page.404', [
            'active' => '404',
            'subPageTitle' => 'ERROR PAGE',
            'pageTitle' => '404 - Not Found'
        ]);
    }
}
