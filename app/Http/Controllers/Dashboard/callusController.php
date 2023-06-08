<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class callusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\appSettings  $appSettings
     * @return \Illuminate\Http\Response
     */
    public function show(appSettings $appSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\appSettings  $appSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(appSettings $appSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\appSettings  $appSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, appSettings $appSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\appSettings  $appSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(appSettings $appSettings)
    {
        //
    }
}
