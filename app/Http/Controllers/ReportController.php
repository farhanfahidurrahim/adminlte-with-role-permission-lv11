<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexX()
    {
        return view('reports.indexc');
    }

    public function index()
    {
        return view('reports.indexg');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
