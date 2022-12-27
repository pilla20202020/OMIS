@extends('backend.layouts.master')

@section('css')
    <link href="{{asset('css/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> --}}
@endsection


@section('title', 'Calendar')

@section('content')
            <!-- start page title -->
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div id='calendar'></div>

                                <div style='clear:both'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End Page-content -->
    </div>
@endsection

@section('js')
    <!-- plugin js -->
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable:false,
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month'
                },
                events: {
                    url: '{{ route('leave.calendar') }}',
                    type: 'GET',
                    error: function() {
                        alert('there was an error while fetching events!');
                    },
                    success: function(data) {
                        var availableTags = new Object();
                        var Holiday = new Object();
                        @if(isset($absentrequestleaveforcalender))
                            @foreach($absentrequestleaveforcalender as $data)
                                @if(isset($data->user->first_name))
                                    availableTags.title = "{{$data->user->first_name}} {{$data->user->last_name}} ({{$data->leavetype->name}})";
                                @endif
                                availableTags.start = moment("{{$data->start_date}}").format();
                                availableTags.end = moment("{{$data->end_date}}").add(1, 'days');
                                $('#calendar').fullCalendar('renderEvent', availableTags);
                            @endforeach
                        @endif

                        @if(!empty($allholidays))
                            @foreach($allholidays as $data)
                                @if(!empty($data->name))
                                    Holiday.title = "{{$data->name}} (Holiday)";
                                @endif
                                Holiday.start = moment("{{$data->date}}").format();
                                Holiday.end = moment("{{$data->date}}").add(1, 'days');
                                Holiday.color = '#f1556c';
                                $('#calendar').fullCalendar('renderEvent', Holiday);
                            @endforeach
                        @endif

                    },
                    color: 'yellow',   // a non-ajax option
                    textColor: 'black' // a non-ajax option

                },
                selectable:true,
                selectHelper: true,

            });

        });

</script>

@endsection
