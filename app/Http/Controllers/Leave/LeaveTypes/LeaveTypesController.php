<?php

namespace App\Http\Controllers\Leave\LeaveTypes;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveTypes\LeaveTypesRequest;
use App\Service\LeaveTypes\LeaveTypesService;
use Illuminate\Http\Request;

class LeaveTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $leavetypes;

    public function __construct(LeaveTypesService $leavetypes)
    {
        $this->leavetypes = $leavetypes;
    }

    public function index()
    {
        //
        $leavetypes = $this->leavetypes->paginate();
        return view('backend.leave.leavetypes.index',compact('leavetypes'));
    }

    public function getAllData()
    {
        return $this->leavetypes->getAllData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.leave.leavetypes.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveTypesRequest $request)
    {
        //
        if($leavetypes = $this->leavetypes->create($request->all())) {
            return redirect()->route('leavetypes.index');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $leavetypes = $this->leavetypes->find($id);
        return view('backend.leave.leavetypes.edit',compact('leavetypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeaveTypesRequest $request, $id)
    {
        //
        if($this->leavetypes->update($id,$request->all()))
        {
            return redirect()->route('leavetypes.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if($this->leavetypes->delete($id)) {
            Toastr()->success('Leave Types has been deleted.','Success');
            return redirect()->route('leavetypes.index');
        } else {
            Toastr()->error('There was error while deleting.','Error');
            return redirect()->back();
        }
    }
}
