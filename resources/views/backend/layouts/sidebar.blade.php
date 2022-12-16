<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Company</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div> --}}
            <div class="info">
                <a href="#" class="d-block">Hello, {{ auth()->user()->full_name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../../index.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index3.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('config.dashboard.index') }}"
                        class="nav-link @if (Request::is('dashboard/*')) active @endif">
                        <p>
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (isset(auth()->user()->company_id))
                    <li class="nav-item @if (Request::is('form/application*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (Request::is('form/application*')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Form Application
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @php
                                $formApplications = \App\Models\Form\FormDetail::where('company_id', auth()->user()->company_id)->get();
                            @endphp
                            @foreach ($formApplications as $item)
                                <li class="nav-item">
                                    <a href="{{ route('form.application.index', [$item->form_name]) }}"
                                        class="nav-link @if (Request::is('form/application/' . $item->form_name)) active @endif">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ $item->form_name }}
                                        </p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @if (isset(auth()->user()->company_id))
                    <li class="nav-item @if (Request::is('form/builder*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (Request::is('form/builder*')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Form Builder
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @php
                                $formApplications = \App\Models\Form\FormDetail::where('company_id', auth()->user()->company_id)->get();
                            @endphp
                            @foreach ($formApplications as $item)
                                <li class="nav-item">
                                    <a href="{{ route('form.builder.index', [$item->form_name]) }}"
                                        class="nav-link @if (Request::is('hris/builder/' . $item->form_name)) active @endif">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            {{ $item->form_name }}
                                        </p>
                                    </a>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <a href="{{ route('form.builder.create') }}"
                                    class="nav-link @if (Request::is('form/builder/common')) active @endif">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Common Form Builder
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif



                @if (auth()->user()->user_type == 'SUPER ADMIN' && !isset(auth()->user()->company_id))
                    <li class="nav-item @if (Request::is('config/*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (Request::is('config/*')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Config
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('config.feature.index') }}"
                                    class="nav-link @if (Request::is('config/feature/*')) active @endif">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Features
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('config.company.index') }}"
                                    class="nav-link @if (Request::is('config/company/*')) active @endif">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Companies
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('config.user.index') }}"
                                    class="nav-link @if (Request::is('config/user/*')) active @endif">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a href="{{ route('config.route.index') }}"
                                    class="nav-link @if (Request::is('config/route/*')) active @endif">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Routes Details
                                    </p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('config.permission.index') }}"
                                    class="nav-link @if (Request::is('config/permission/*')) active @endif">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Permissions
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item @if (Request::is('hris/*')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if (Request::is('hris/*')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            HRIS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(in_array('hris.branch.view',$permissions))
                          <li class="nav-item">
                              <a href="{{ route('hris.branch.index') }}"
                                  class="nav-link @if (Request::is('hris/branch/*')) active @endif">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>
                                      Branch
                                  </p>
                              </a>
                          </li>
                        @endif
                        @if(in_array('hris.department.view',$permissions))
                          <li class="nav-item">
                              <a href="{{ route('hris.department.index') }}"
                                  class="nav-link @if (Request::is('hris/department/*')) active @endif">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>
                                      Department
                                  </p>
                              </a>
                          </li>
                        @endif
                        @if(in_array('hris.department.view',$permissions))
                          <li class="nav-item">
                              <a href="{{ route('hris.designation.index') }}"
                                  class="nav-link @if (Request::is('hris/designation/*')) active @endif">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>
                                      Designation
                                  </p>
                              </a>
                          </li>
                        @endif
                        @if(in_array('hris.shift.view',$permissions))
                          <li class="nav-item">
                              <a href="{{ route('hris.shift.index') }}"
                                  class="nav-link @if (Request::is('hris/shift/*')) active @endif">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>
                                      Shift
                                  </p>
                              </a>
                          </li>
                        @endif
                        @if(in_array('hris.role.view',$permissions))
                          <li class="nav-item">
                              <a href="{{ route('hris.role.index') }}"
                                  class="nav-link @if (Request::is('hris/role/*')) active @endif">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>
                                      Role
                                  </p>
                              </a>
                          </li>
                        @endif
                        @if(in_array('hris.user.view',$permissions))
                          <li class="nav-item">
                              <a href="{{ route('hris.user.index') }}"
                                  class="nav-link @if (Request::is('hris/user/*')) active @endif">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>
                                      User
                                  </p>
                              </a>
                          </li>
                        @endif
                        @if(in_array('hris.employee.view',$permissions))
                          <li class="nav-item">
                              <a href="{{ route('hris.employee.index') }}"
                                  class="nav-link @if (Request::is('hris/employee/*')) active @endif">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>
                                      Onboarding Employee
                                  </p>
                              </a>
                          </li>
                        @endif

                        {{-- <li class="nav-item">
                            <a href="{{ route('hris.onboarding-employee.index') }}"
                                class="nav-link @if (Request::is('hris/onboarding-employee/*')) active @endif">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                  Onboarding Employee
                                </p>
                            </a>
                        </li> --}}

                    </ul>
                </li>

                <li class="nav-item @if (Request::is('payroll/*')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if (Request::is('payroll/*')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Payroll
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                      @if(in_array('hris.leave-type.view',$permissions))
                        <li class="nav-item">
                            <a href="{{ route('payroll.leave-type.index') }}"
                                class="nav-link @if (Request::is('payroll/leave-type/index*')) active @endif">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Leave Type
                                </p>
                            </a>
                        </li>
                      @endif
                        <li class="nav-item">
                            <a href="{{ route('payroll.attendance.index') }}?dept=All&shift=All&date={{ date('Y-m-d') }}"
                                class="nav-link @if (Request::is('payroll/attendance/index*')) active @endif">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Daily Attendance
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payroll.attendance.report.view') }}?start_date={{ date('Y-m-01') }}&end_date={{ date('Y-m-t') }}"
                                class="nav-link @if (Request::is('payroll/attendance/report*')) active @endif">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Attendance Report
                                </p>
                            </a>
                            {{--  </li>
                      <li class="nav-item">
                          <a href="{{ route('hris.shift.index') }}"
                              class="nav-link @if (Request::is('hris/shift/*')) active @endif">
                              <i class="nav-icon fas fa-th"></i>
                              <p>
                                  Shift
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('hris.role.index') }}"
                              class="nav-link @if (Request::is('hris/role/*')) active @endif">
                              <i class="nav-icon fas fa-th"></i>
                              <p>
                                  Role
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('hris.user.index') }}"
                              class="nav-link @if (Request::is('hris/user/*')) active @endif">
                              <i class="nav-icon fas fa-th"></i>
                              <p>
                                  User
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('hris.employee.index') }}"
                              class="nav-link @if (Request::is('hris/employee/*')) active @endif">
                              <i class="nav-icon fas fa-th"></i>
                              <p>
                                  Employee
                              </p>
                          </a>
                      </li> --}}

                            {{-- <li class="nav-item">
                          <a href="{{ route('hris.onboarding-employee.index') }}"
                              class="nav-link @if (Request::is('hris/onboarding-employee/*')) active @endif">
                              <i class="nav-icon fas fa-th"></i>
                              <p>
                                Onboarding Employee
                              </p>
                          </a>
                      </li> --}}

                    </ul>
                </li>

                {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Layout Options
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">6</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../layout/top-nav.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Top Navigation</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../layout/top-nav-sidebar.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Top Navigation + Sidebar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../layout/boxed.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Boxed</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../layout/fixed-sidebar.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Fixed Sidebar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../layout/fixed-sidebar-custom.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Fixed Sidebar <small>+ Custom Area</small></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../layout/fixed-topnav.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Fixed Navbar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../layout/fixed-footer.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Fixed Footer</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../layout/collapsed-sidebar.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Collapsed Sidebar</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Charts
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../charts/chartjs.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ChartJS</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../charts/flot.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Flot</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../charts/inline.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inline</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../charts/uplot.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>uPlot</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
              UI Elements
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../UI/general.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>General</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../UI/icons.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Icons</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../UI/buttons.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Buttons</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../UI/sliders.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sliders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../UI/modals.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Modals & Alerts</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../UI/navbar.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Navbar & Tabs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../UI/timeline.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Timeline</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../UI/ribbons.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ribbons</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Forms
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../forms/general.html" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>General Elements</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../forms/advanced.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Advanced Elements</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../forms/editors.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Editors</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../forms/validation.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Validation</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Tables
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../tables/simple.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Simple Tables</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../tables/data.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>DataTables</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../tables/jsgrid.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>jsGrid</p>
              </a>
            </li>
          </ul>
        </li> --}}
                <li class="nav-item">
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->