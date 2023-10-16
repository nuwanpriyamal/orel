<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Location;
use App\Models\Assign;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class BusAssignController extends Controller
{
       /**
     * Display a Bus listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:assign-list|assign-create|assign-edit|assign-delete', ['only' => ['index','show']]);
         $this->middleware('permission:assign-create', ['only' => ['create','store']]);
         $this->middleware('permission:assign-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:assign-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $assigns = Assign::latest()->with('bus', 'locationStart', 'locationEnd')
        ->paginate(10);

        return view('assign.index', compact('assigns'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $location = Location::pluck('name','id')->all();
        $bus = Bus::pluck('name','id')->all();
        return view('assign.create',compact('location','bus'));
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
            'bus_id' => 'required', 
            'location_id_from'=>'required',
            'location_id_end'=>'required',
            'assign_date'=>'required',
            'assign_by'=>'required'

        ]);
        $existingAssignments = Assign::where('bus_id', $request->bus_id)
        ->where('assign_date', $request->assign_date)
        ->count();

    if ($existingAssignments > 0) {
        return redirect()->route('assign.create')
            ->with('error', 'Can\'t create because the bus is already assigned on this date.');
    }

        Assign::create($request->all());
    
        return redirect()->route('assign.index')
                        ->with('success','Bus asigned successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Assign  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Assign $assign): View
    {
        return view('assign.show',compact('assign'));
    }
    

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assign  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $assign = Assign::with('bus', 'locationStart','locationEnd')->find($id);
       
        $location = Location::pluck('name','id')->all();
        $bus = Bus::pluck('name','id')->all();
       
        $selectedbus = $assign->bus->pluck('name','name')->all();
        $selectedfromlocation = $assign['locationStart']->pluck('name','name')->all();
        $selectedtolocation =  $assign['locationStart']->pluck('name','name')->all();
        return view('assign.edit',compact('assign','location','bus','selectedbus','selectedfromlocation','selectedtolocation'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assign  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assign $assign): RedirectResponse
    {
        request()->validate([
            'bus_id' => 'required', 
            'location_id_from'=>'required',
            'location_id_end'=>'required',
            'assign_date'=>'required',
            'assign_by'=>'required'

        ]);
        $assign->update($request->all());
    
        return redirect()->route('assign.index')
                        ->with('success','Bus assign changed successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assign  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assign $assign): RedirectResponse
    {
        
        $assign->delete();
    
        return redirect()->route('assign.index')
                        ->with('success','Bus assigned removed successfully');
    }
}
