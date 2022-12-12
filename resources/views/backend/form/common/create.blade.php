@extends('backend.layouts.master')

@section('content')
    <!-- Main content -->
    {{-- <section class="content"> --}}
    {{-- <div class="container-fluid"> --}}



    <div class="saveDataWrap">
        <button id="saveData" type="button">Save To Database</button>
    </div>
    <div id="build-wrap" style="margin-left: 18%;">
    </div>


    {{-- </div> --}}
    {{-- </section> --}}
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="https://cdn.form.io/formiojs/formio.full.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"> --}}
    <style>
        body {
            padding: 0;
            margin: 10px 0;
            background-color: #f2f2f2;
        }

        .saveDataWrap {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
@stop

@section('js')
    {{-- <script src="https://cdn.form.io/formiojs/formio.full.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>

    <script>
        let storeUrl = "{{ route('form.builder.store') }}";
        let token = "{{ csrf_token() }}";

        // Formio.builder(document.getElementById('builder'));
        jQuery(($) => {
            const fbEditor = document.getElementById("build-wrap");
            // const formBuilder = $(fbEditor).formBuilder();

            var options = {
                defaultFields: [{
                        "type": "text",
                        "required": "true",
                        "label": "Form Name",
                        "description": "Form Name",
                        "placeholder": "Enter Form Name",
                        "className": "form-control",
                        "name": "FormName",
                        "access": "false",
                        "value": "Leave Request Application",
                        "subtype": "text"
                    },
                    {
                        "type": "date",
                        "required": "false",
                        "label": "Last Valid Date",
                        "placeholder": "Enter Last Valid Date",
                        "className": "form-control",
                        "name": "LastValidDate",
                        "access": "false",
                        "value": "2025-01-01"
                    },
                    {
                        "type": "select",
                        "required": "true",
                        "label": "Select Employee",
                        "className": "form-control",
                        "name": "EmployeeId",
                        "access": "false",
                        "multiple": "false",
                        "values": [{
                                "label": "Option 1",
                                "value": "option-1",
                                "selected": "true"
                            },
                            {
                                "label": "Option 2",
                                "value": "option-2",
                                "selected": "false"
                            }
                        ]
                    },
                    {
                        "type": "text",
                        "required": "false",
                        "label": "Reporting To",
                        "placeholder": "Reporting To",
                        "className": "form-control",
                        "name": "ReportingTo",
                        "access": "false",
                        "subtype": "text"
                    }
                ]
            };
            const formBuilder = $(fbEditor).formBuilder(options);

            document.getElementById("saveData").addEventListener("click", () => {
                console.log("external save clicked");
                const result = formBuilder.actions.save();
                console.log("result:", result);

                $.ajax({
                    type: "POST",
                    url: storeUrl,
                    data: {
                        result: result,
                        _token: token
                    },
                    dataType: "json",
                    success: (res) => {
                        if (res.status) {

                        }
                    },
                    error: function(errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: ''
                        })
                    }
                });
            });
        });
    </script>

    {{-- <script src="{{ asset('js/backend/config/user_index.js') }}"></script> --}}

@stop
