@section('css')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet"
          href="{{ asset('resources/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862')}}"/>
@endsection
@csrf
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-underline">
                <div class="card-head">
                    <header class="ml-3 mt-2">{!! $header !!}</header>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="specialization" class="col-form-label pt-0">Select Employee</label>
                                <div class="">
                                    <select data-placeholder="Select Leave Type" class="tail-select form-control select2" name="user_id">
                                        @foreach($users as $user_data)
                                            <option value="{{ $user_data->id }}" @if(\Auth::user()->id == $user_data->id) selected @endif>{{ucfirst($user_data->first_name.' '.$user_data->last_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endrole

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">From*</label>
                                <div class="">
                                    <input class="form-control start_date" type="date" min="{{ date('Y-m-d') }}" required name="start_date" value="{{ old('start_date', isset($leaverequest->start_date) ? $leaverequest->start_date : '') }}" placeholder="Enter Starting Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">To*</label>
                                <div class="">
                                    <input class="form-control end_date" type="date" min="{{ date('Y-m-d') }}" required name="end_date" value="{{ old('end_date', isset($leaverequest->end_date) ? $leaverequest->end_date : '') }}" placeholder="Enter Ending Date">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Leave Type (Annual/Sick) </label>
                                <div class="">
                                    <select data-placeholder="Select Leave Type" class="tail-select w-full form-control category_id" name="leave_type" required>
                                        @foreach($leavetypes as $leave_type)
                                                <option value="{{ $leave_type->id }}">{{ucfirst($leave_type->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Type (Full-Time/Half) </label>
                                <div class="">
                                    <select data-placeholder="Select Leave Type" class="tail-select w-full form-control type" name="type">
                                        <option value="full">Full</option>
                                        <option value="half">Half</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Remarks</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Description">{{old('description',isset($leaverequest->description) ? $leaverequest->description : '')}}</textarea>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 justify-content-center">
                        <div class="form-group">
                            <div>
                                <a class="btn btn-light" href="{{ route('leaverequest.index') }}">
                                    Back
                                </a>
                                <input type="submit" name="pageSubmit" class="btn btn-success" value="Submit">
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row d-none" id="bg1">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Total Number Of Days </label>
                                <input class="form-control total_number_of_days" type="text">
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" >
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <h6 class="pl-1 text-center">Allowed Leave</h6>
                                @foreach ($remaining_days as $key => $item)
                                    @if($item > 0)
                                        <h6 class="pl-1 text-center">{{$key}} : {{$item}} Days</h6>
                                    @else
                                        <h6 class="pl-1 text-center">Sick Leave : <span style="color: red">{{$item}} Days</span></h6>
                                    @endif
                                @endforeach
                        </div>
                    </div>
                </div>
                <hr>

            </div>
        </div>

    </div>
</div>


@section('js')
    <script type="text/javascript">
        $(function(){
           $('.select2').select2();
        });
    </script>
@endsection
