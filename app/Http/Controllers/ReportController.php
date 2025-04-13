<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function reportA()
    {
        //  
        $datas = [];
        return view("report.reportA", compact('datas'));
    }
}
