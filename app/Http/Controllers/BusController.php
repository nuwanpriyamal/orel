<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class BusController extends Controller
{
       /**
     * Display a Bus listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:bus-list|bus-create|bus-edit|bus-delete', ['only' => ['index','show']]);
         $this->middleware('permission:bus-create', ['only' => ['create','store']]);
         $this->middleware('permission:bus-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bus-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $buses = Bus::latest()->paginate(5);
        return view('bus.index',compact('buses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('bus.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        Bus::create($request->all());
    
        return redirect()->route('bus.index')
                        ->with('success','Bus added successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $bus): View
    {
        return view('bus.show',compact('buses'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $bus): View
    {
        return view('bus.edit',compact('bus'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bus $bus): RedirectResponse
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $bus->update($request->all());
    
        return redirect()->route('bus.index')
                        ->with('success','Bus updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus $bus): RedirectResponse
    {
        $bus->delete();
    
        return redirect()->route('bus.index')
                        ->with('success','Bus deleted successfully');
    }
}
