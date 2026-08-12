@extends('backend.app')

@section('title', 'Admin Dashboard')

@push('style')
    <style>
        .dash-card {
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* padding: 20px; */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Icon section */
        .dash-card .icon img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Info section */
        .dash-card .info h5 {
            font-size: 24px;
            color: #2c3e50;
            font-weight: bolder;
            margin-bottom: 5px;
        }

        .dash-card .info p {
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Hover effect */
        .dash-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .quick_access_card.card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background-color: #fff;
            cursor: pointer;
        }

        .quick_access_card.card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .quick_access_card .card-body {
            display: flex;
            align-items: center;
        }

        .quick_access_card .icon {
            background-color: #f0f2f5;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            min-width: 40px;
            min-height: 40px;
        }

        .quick_access_card .icon i {
            width: 24px;
            height: 24px;
            stroke: #4a4a4a;
        }

        .quick_access_card .info h5 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .quick_access_card .info p {
            font-size: 13px;
            color: #777;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="info">
                                        <h5>{{ $greetings['message'] }} {{ auth()->user()->name }}</h5>
                                        <p class="card-text font-small-3">What's your plan today ?</p>
                                    </div>
                                    <div class="img">
                                        @if ($greetings['type'] == 'morning')
                                            <img src="{{ asset('backend/assets/greetings/004-sunrise.png') }}"
                                                alt="Gooddo Morning" />
                                        @elseif ($greetings['type'] == 'afternoon')
                                            <img src="{{ asset('backend/assets/greetings/002-sunsets.png') }}"
                                                alt="Gooddo Afternoon">
                                        @else
                                            <img src="{{ asset('backend/assets/greetings/003-cloudy-night.png') }}"
                                                alt="Gooddo Night">
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="card shadow-sm border-0 rounded-lg">
                                <div class="card-body dash-card p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon mr-3">
                                            <img src="{{ asset('default/dashboard/002-stack-of-books.png') }}"
                                                alt="" style="width: 50px; height: 50px;">
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1" style="font-size: 24px; color: #2c3e50;">
                                                {{ App\Models\Book::count() }}</h5>
                                            <p class="card-text font-small-3 mb-0" style="font-size: 14px; color: #7f8c8d;">
                                                Total Books</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="card shadow-sm border-0 rounded-lg">
                                <div class="card-body dash-card p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon mr-3">
                                            <img src="{{ asset('default/dashboard/003-chapter.png') }}" alt=""
                                                style="width: 50px; height: 50px;">
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1" style="font-size: 24px; color: #2c3e50;">
                                                {{ App\Models\Chapter::count() }}</h5>
                                            <p class="card-text font-small-3 mb-0" style="font-size: 14px; color: #7f8c8d;">
                                                Total Chapters</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="card shadow-sm border-0 rounded-lg">
                                <div class="card-body dash-card p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon mr-3">
                                            <img src="{{ asset('default/dashboard/001-subscribe.png') }}" alt=""
                                                style="width: 50px; height: 50px;">
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1" style="font-size: 24px; color: #2c3e50;">
                                                {{ App\Models\Subscriber::count() }}</h5>
                                            <p class="card-text font-small-3 mb-0" style="font-size: 14px; color: #7f8c8d;">
                                                Total Subscribers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="card shadow-sm border-0 rounded-lg">
                                <div class="card-body dash-card p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon mr-3">
                                            <img src="{{ asset('default/dashboard/004-inbox.png') }}" alt=""
                                                style="width: 50px; height: 50px;">
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1" style="font-size: 24px; color: #2c3e50;">
                                                {{ App\Models\SiteMessage::where('status', 'unread')->count() }}</h5>
                                            <p class="card-text font-small-3 mb-0" style="font-size: 14px; color: #7f8c8d;">
                                                Unread Messages</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <small style="color: #2c3e50; font-size: 14px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 10px; display: block; text-align: left; background-color: #e6e6e6; padding: 10px; border-radius: 5px;">Quick Links</small>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('book.index') }}" style="text-decoration: none;">
                                <div class="quick_access_card card">
                                    <div class="card-body p-3">
                                        <div class="icon mr-2">
                                            <i data-feather="book"></i>
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1">Books</h5>
                                            <p class="card-text font-small-3 mb-0">Manage Books</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('chapter.index') }}" style="text-decoration: none;">
                                <div class="quick_access_card card">
                                    <div class="card-body p-3">
                                        <div class="icon mr-2">
                                            <i data-feather="book-open"></i>
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1">Chapters</h5>
                                            <p class="card-text font-small-3 mb-0">Manage Chapters</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('aboutus.index') }}" style="text-decoration: none;">
                                <div class="quick_access_card card">
                                    <div class="card-body p-3">
                                        <div class="icon mr-2">
                                            <i data-feather="aperture"></i>
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1">About Us</h5>
                                            <p class="card-text font-small-3 mb-0">Update About Us</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('category.index') }}" style="text-decoration: none;">
                                <div class="quick_access_card card">
                                    <div class="card-body p-3">
                                        <div class="icon mr-2">
                                            <i data-feather="grid"></i>
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1">Category</h5>
                                            <p class="card-text font-small-3 mb-0">Create New Category</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('system.setting') }}" style="text-decoration: none;">
                                <div class="quick_access_card card">
                                    <div class="card-body p-3">
                                        <div class="icon mr-2">
                                            <i data-feather="settings"></i>
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1">Site Information</h5>
                                            <p class="card-text font-small-3 mb-0">Update Site Information</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('inbox.index') }}" style="text-decoration: none;">
                                <div class="quick_access_card card">
                                    <div class="card-body p-3">
                                        <div class="icon mr-2">
                                            <i data-feather="inbox"></i>
                                        </div>
                                        <div class="info">
                                            <h5 class="font-weight-bold mb-1">Site Messages</h5>
                                            <p class="card-text font-small-3 mb-0">Read Unread Messages</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
@endsection
