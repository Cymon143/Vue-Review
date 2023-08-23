<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ $school_logo }}" rel="icon">
    <title>{{ config('app.name', 'San Pedro College') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    {{-- <link href="public/css/app.css" rel="stylesheet"> --}}

    <script type="text/javascript">
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            jsPermissions: {!! auth()->check() ? auth()->user()->jsPermissions() : 0 !!}
        }
    </script>
    <style scoped>
        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
                <img src="{{$school_logo}}" alt="school logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">{{ $short_school_name ? $short_school_name->value :'DVO'}}</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{Auth::user()->image ? Auth::user()->image: '/images/default_image.png'}}" alt="school logo" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <span class="font-weight-bold" style="color:rgb(202, 202, 202)">{{ strtoupper(Auth::user()->name) }}</span> <br>
                        <span  style="color:#a5a5a5"><small>{{ strtoupper(Auth::user()->getRoleNames()[0]) }}</small></span>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </router-link>
                        </li>
                        {{-- <li class="nav-item">
                            <router-link to="/profile" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Profile
                                </p>
                            </router-link>
                        </li> --}}
                        @can('access level-subject')
                            <li class="nav-item">
                                <router-link to="/level-subject" class="nav-link">
                                    <i class="nav-icon fas fa-award"></i>
                                    <p>
                                        Level Subjects
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access user')
                            <li class="nav-item">
                                <router-link to="/users" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access permission')
                            <li class="nav-item">
                                <router-link to="/permission" class="nav-link">
                                    <i class="nav-icon fas fa-user-lock"></i>
                                    <p>
                                        Permission
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access role')
                            <li class="nav-item">
                                <router-link to="/role" class="nav-link">
                                    <i class="nav-icon fas fa-user-tag"></i>
                                    <p>
                                        Role
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access registrar')
                            <li class="nav-item">
                                <router-link to="/registrar" class="nav-link">
                                    <i class="nav-icon fas fa-sign-in-alt"></i>
                                    <p>
                                        Registrar
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access program')
                            <li class="nav-item">
                                <router-link to="/program" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Program
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access major')
                            <li class="nav-item">
                                <router-link to="/major" class="nav-link">
                                    <i class="nav-icon fas fa-star"></i>
                                    <p>
                                        Department
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access schedule search')
                            <li class="nav-item">
                                <router-link to="/schedule-search" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p>
                                        Schedule
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access subject')
                            <li class="nav-item">
                                <router-link to="/subject" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Subject
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access substitution')
                            <li class="nav-item">
                                <router-link to="/substitution" class="nav-link">
                                    <i class="nav-icon far fa-people-arrows"></i>
                                    <p>
                                        Substitution
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access section')
                            <li class="nav-item">
                                <router-link to="/section" class="nav-link">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>
                                        Sections
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access schedule')
                            <li class="nav-item">
                                <router-link to="/schedule" class="nav-link">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>
                                        My Schedule
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access teacher load')
                            <li class="nav-item">
                                <router-link to="/teacher-load" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                    <p>
                                        Teacher Load
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <router-link to="/settings" class="nav-link">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>
                                    Settings
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            {{-- content vue here --}}
            <router-view></router-view>
        </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Made by AJCentillas
            </div>
            <strong>Copyright &copy; 2022-2023 <a href="#">CreateTiveMind.dev</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    @auth
        <script>
            window.user = @json(auth()->user());
            window.role = @json(auth()->user()->role);
        </script>
    @endauth
    {{-- <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script> --}}
    <script src="{{ asset('/js/app.js') }}"></script>
    {{-- <script>
        window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
        ]) !!};
    </script> --}}

</body>
</html>
