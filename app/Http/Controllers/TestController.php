<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function showMessage() {
        return view('test.show-message');
    }

    public function showName($name) {
        return view('test.show-name', ['name' => $name]);
    }
}
