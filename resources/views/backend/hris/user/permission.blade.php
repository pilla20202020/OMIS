@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">Create | Edit User Special Permission</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('config.dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section>

            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('hris.user.permission', [$user_id]) }}" method="post">
                @csrf
                <input type="hidden" name="role_id" value="{{ $role->role_id }}">
                <div class="card-header">
                    <div class="form-group col-md-6">
                        <label for="role_type">role Name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name"
                            value="{{ $role->role_name }}" placeholder="Enter role Name" disabled>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($groupPermissions as $chunk)
                        <div class="row">
                            @foreach ($chunk as $title => $group)
                                {{-- {{dd($title,$group)}} --}}
                                @php
                                    $permissionGroup = $group
                                        ->where('group_name', $group->group_name)
                                        ->where('is_default', 'NO')
                                        ->select('name')
                                        ->pluck('name')
                                        ->toArray();
                                    // dd($rolePermissions);
                                    $result = array_intersect($permissionGroup, $rolePermissions);
                                @endphp
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input"
                                            data-checkbox-group="{{ Str::slug($group->group_name) }}" data-role="selectall"
                                            {{ $result == $permissionGroup ? 'disabled' : '' }}>
                                        <label class="form-check-label h5 font-weight-bold text-danger"
                                            for="permission">{{ ucfirst($group->group_name) }}</label>

                                    </div>

                                    <div style="margin-left: 1rem">
                                        @foreach ($group->where('group_name', $group->group_name)->where('is_default', 'NO')->get() as $permission)
                                            <div class="form-group form-check">

                                                <input type="checkbox" class="form-check-input"
                                                    name="permissions[{{ $permission->name }}]"
                                                    value="{{ $permission->name }}"
                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked disabled' : '' }}
                                                    {{ in_array($permission->name, $userPermission) ? 'checked' : '' }}
                                                    data-checkbox-group="{{ Str::slug($group->group_name) }}"
                                                    data-role="select">
                                                <label class="form-check-label"
                                                    for="{{ $permission->name }}">{{ $permission->showing_name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('js')
    <script>
        // $(document).ready(function() {
        $("[data-role=selectall]").change(function() {
            var $thisgroup = $("[data-checkbox-group=" + $(this).data('checkbox-group') + "][data-role=select]");
            if (this.checked) {
                $thisgroup.each(function() {
                    this.checked = true;
                })
            } else {
                $thisgroup.each(function() {
                    this.checked = false;
                })
            }
        });

        $("[data-checkbox-group]").change(function() {
            var $thisgroup = $("[data-checkbox-group=" + $(this).data('checkbox-group') + "][data-role=select]");
            var $thisselectall = $("[data-checkbox-group=" + $(this).data('checkbox-group') +
                "][data-role=selectall]");
            if ($(this).is(":checked")) {
                var isAllChecked = 0;
                $thisgroup.each(function() {
                    if (!this.checked)
                        isAllChecked = 1;
                });
                if (isAllChecked == 0) {
                    $thisselectall.prop("checked", true);
                }
            } else {
                $thisselectall.prop("checked", false);
            }
        });

        $('.card-body').on('click', function(e) {
            $('[data-toggle="popover"]').each(function() {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover')
                    .has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });

        $("[data-checkbox-group][data-role=select]").trigger('change');

        // });
    </script>
@endsection
