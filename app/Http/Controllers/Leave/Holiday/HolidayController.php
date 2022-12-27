<?php

namespace App\Http\Controllers\Leave\Holiday;

use App\Http\Controllers\Controller;
use App\Http\Requests\Holiday\HolidayRequest;
use App\Service\Holiday\HolidayService;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $holiday;

    public function __construct(HolidayService $holiday)
    {
        $this->holiday = $holiday;
    }
    public function index()
    {
        //
        $holidays = $this->holiday->paginate();
        return view('backend.leave.holiday.index',compact('holidays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllData()
    {
        return $this->holiday->getAllData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.leave.holiday.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayRequest $request)
    {
        //
        $allholiday = $this->holiday->getAllHoliday();
        $previousholiday = $allholiday->where('date', '=',$request->date)->first();
        if(isset($previousholiday))  {
            Toastr()->error('In the Requested date, There is Already Holiday Declared','Sorry');
            return redirect()->back();
        }

        if($holiday = $this->holiday->create($request->all())) {
            return redirect()->route('holiday.index');

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
        $holiday = $this->holiday->find($id);
        return view('backend.leave.holiday.edit',compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayRequest $request, $id)
    {
        //
        if($this->holiday->update($id,$request->all()))
        {
            return redirect()->route('holiday.index');
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

        if($this->holiday->delete($id)) {
            Toastr()->success('Holiday has been deleted.','Success');
            return redirect()->route('holiday.index');
        } else {
            Toastr()->error('There was error while deleting.','Error');
            return redirect()->back();
        }
    }
}
