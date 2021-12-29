<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCheckbookRequest;
use App\Models\Checkbook;
use Illuminate\Http\Request;

class CheckbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkbook = Checkbook::first();
        return response($checkbook,200);
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
     * @param  \App\Models\Checkbook  $checkbook
     * @return \Illuminate\Http\Response
     */
    public function show(Checkbook $checkbook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkbook  $checkbook
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkbook $checkbook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkbook  $checkbook
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCheckbookRequest $request, Checkbook $checkbook)
    {
        if($request->validated())
        {
            $updated = $checkbook->update($request->validated());
            if($updated)
            {
                return response(['success' => true],200);
            }
            return response(['success' => false],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkbook  $checkbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkbook $checkbook)
    {
        //
    }
}
