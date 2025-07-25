@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <main class="content px-3 py-4">
        @if (in_array(auth()->user()->role, [\App\Models\User::SUPER_ADMIN, \App\Models\User::ADMIN]))
            <div class="container-fluid">
                <div class="mb-3">
                    <h4>Welcome Back, </h4>
                </div>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card custom-card main-card-item primary bg-white">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-3 flex-wrap">
                                    <div> <span class="d-block mb-3 fw-medium">Total Users</span>
                                        <h3 class="fw-semibold lh-1 mb-0">321</h3>
                                    </div>
                                    <div class="text-end">
                                        <div class="mb-4"> <span
                                                class="avatar avatar-md bg-primary svg-white avatar-rounded"> <svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none"></rect>
                                                    <rect x="32" y="48" width="192" height="160" rx="8"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16"></rect>
                                                    <path d="M168,88a40,40,0,0,1-80,0" fill="none" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                                                    </path>
                                                </svg> </span> </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between"> <a
                                        href="javascript:void(0);"
                                        class="text-muted text-decoration-underline fw-medium fs-13">View all
                                        sales</a> <span class="text-success"><i
                                            class="ti ti-arrow-narrow-up"></i>0.29%</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card custom-card main-card-item bg-white">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-3 flex-wrap">
                                    <div> <span class="d-block mb-3 fw-medium">Statistics</span>
                                        <h3 class="fw-semibold lh-1 mb-0">14,145</h3>
                                    </div>
                                    <div class="text-end">
                                        <div class="mb-4"> <span
                                                class="avatar avatar-md bg-secondary svg-white avatar-rounded"> <svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none"></rect>
                                                    <line x1="128" y1="24" x2="128" y2="232"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16"></line>
                                                    <path
                                                        d="M184,88a40,40,0,0,0-40-40H112a40,40,0,0,0,0,80h40a40,40,0,0,1,0,80H104a40,40,0,0,1-40-40"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16"></path>
                                                </svg> </span> </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between"> <a
                                        href="javascript:void(0);"
                                        class="text-muted text-decoration-underline fw-medium fs-13">complete
                                        revenue</a> <span class="text-success"><i
                                            class="ti ti-arrow-narrow-up"></i>3.45%</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card custom-card main-card-item bg-white">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-3 flex-wrap">
                                    <div> <span class="d-block mb-3 fw-medium">Page Views</span>
                                        <h3 class="fw-semibold lh-1 mb-0">4,678</h3>
                                    </div>
                                    <div class="text-end">
                                        <div class="mb-4"> <span
                                                class="avatar avatar-md bg-success svg-white avatar-rounded"> <svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none"></rect>
                                                    <circle cx="84" cy="108" r="52" fill="none"
                                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="16"></circle>
                                                    <path d="M10.23,200a88,88,0,0,1,147.54,0" fill="none"
                                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="16"></path>
                                                    <path d="M172,160a87.93,87.93,0,0,1,73.77,40" fill="none"
                                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="16"></path>
                                                    <path d="M152.69,59.7A52,52,0,1,1,172,160" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16"></path>
                                                </svg> </span> </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between"> <a
                                        href="javascript:void(0);"
                                        class="text-muted text-decoration-underline fw-medium fs-13">Total
                                        page views</a> <span class="text-success"><i
                                            class="ti ti-arrow-narrow-up"></i>11.54%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card custom-card main-card-item bg-white">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-3 flex-wrap">
                                    <div> <span class="d-block mb-3 fw-medium">Countries</span>
                                        <h3 class="fw-semibold lh-1 mb-0">645</h3>
                                    </div>
                                    <div class="text-end">
                                        <div class="mb-4"> <span
                                                class="avatar avatar-md bg-info svg-white avatar-rounded"> <svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none"></rect>
                                                    <path
                                                        d="M40,56V184a16,16,0,0,0,16,16H216a8,8,0,0,0,8-8V80a8,8,0,0,0-8-8H56A16,16,0,0,1,40,56h0A16,16,0,0,1,56,40H192"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16"></path>
                                                    <circle cx="180" cy="132" r="12"></circle>
                                                </svg> </span> </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between"> <a
                                        href="javascript:void(0);"
                                        class="text-muted text-decoration-underline fw-medium fs-13">Total
                                        profit earned</a> <span class="text-success"><i
                                            class="ti ti-arrow-narrow-up"></i>0.18%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- <header class="container-fluid mt-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h4 class="mb-0">Hello Karen</h4>
                <div class="d-flex flex-wrap gap-5  align-items-center">
                    <div class="d-flex align-items-center gap-2 p-1 px-3 rounded headbtn ">
                        <input type="text" class="form-control border-0 shadow-none bg-transparent" placeholder="Search..."
                            style="flex-grow: 1;" />
                        <a href="#">
                            <img src="./images/Group 20.png" alt="search icon" class="img-fluid"style="width: 24px; height: 24px;" />
                        </a>
                    </div>
                    <ul class="d-flex flex-wrap gap-5 list-unstyled align-items-center mb-0">
                        <li class="list-group-item fs-5 px-3 py-2 headbtn text-center">
                            <div> Phone 123456789</div>
                        </li>
                        <li class=" fs-5 px-3 py-2 headbtn ">
                            <a href="#" class=" text-decoration-none headtext">Reply</a>
                        </li>
                    </ul>
                </div>
            </div>
               </header> -->


            <div class="container-fluid bggray mt-5 dashboard_referrals">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h4 class="mb-2">Referrals Given</h4>
                    <ul class="d-flex flex-wrap gap-3 list-unstyled mb-0 align-items-center">
                        <li class="fs-6 fw-semibold px-2 py-1 rounded">Last 6 Months</li>
                        <li class="fs-6 fw-semibold px-2 py-1 rounded">Last 12 Months</li>
                        <li class="fs-6 fw-semibold px-2 py-1 rounded">Lifetime</li>
                        <li class="">
                            <a href="#" class="text-red"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                    height="20" fill="currentColor" class="bi bi-exclamation-circle-fill"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                                </svg></a>
                        </li>
                    </ul>
                </div>

                <div class="row  px-3">
                    <div class="col-12 col-lg-5 mb-3 mb-lg-0 border rounded bg-white">
                        <div class="p-3">
                            <h6 class="text-uppercase mb-3">Member Growth</h6>
                            <div class="chart-container" style="position: relative; height: 200px;">
                                <canvas id="memberGrowthChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="row g-3  mb-1">
                            <!-- Left Panel -->
                            <div class="col-12   col-lg-4">
                                <div class="rounded border text-white h-100  d-flex flex-column bg-white">
                                    <div class="text-center pt-3">
                                        <h6 class="card-title text-dark">TYFBFC Received:</h6>
                                        <div class="my-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="#000" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                                <path fill-rule="evenodd"
                                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                            </svg>
                                        </div>
                                        <h5 class="card-subtitle mb-3 text-body-secondary">S$ 213,454</h5>
                                    </div>
                                    <div class="d-flex mt-auto">
                                        <a href="#"
                                            class="w-50 text-center p-2 text-decoration-none btnbg rounded-start border-end">Submit</a>
                                        <a href="#"
                                            class="w-50 text-center p-2 text-decoration-none  btnbg border-start">Review</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Panel -->
                            <div class="col-12 h-100 col-lg-8">
                                <div class="row g-3">
                                    <!-- Referrals Received -->
                                    <div class="col-12  col-lg-4">
                                        <div class="rounded border  h-100 d-flex flex-column bg-white">
                                            <div class="text-center pt-3">
                                                <h6 class="card-title">Referrals Received:</h6>
                                                <div class="my-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="#000" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                                        <path fill-rule="evenodd"
                                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                                    </svg>
                                                </div>
                                                <h5 class="card-subtitle mb-3 text-body-secondary">11</h5>
                                            </div>
                                            <a href="#"
                                                class="w-100 mt-auto text-center p-2 text-decoration-none btnbg rounded"
                                                style="border-radius: 20px;">TRACK Online</a>
                                        </div>
                                    </div>

                                    <!-- Referrals Given -->
                                    <div class="col-12  col-lg-4">
                                        <div class="rounded border h-100 d-flex flex-column bg-white">
                                            <div class="text-center pt-3">
                                                <h6 class="card-title text-dark">Referrals Given:</h6>
                                                <div class="my-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="#000" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                                        <path fill-rule="evenodd"
                                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                                    </svg>
                                                </div>
                                                <h5 class="card-subtitle mb-3 text-body-secondary">28</h5>
                                            </div>
                                            <div class="d-flex mt-auto">
                                                <a href="#"
                                                    class="w-50 text-center p-2 text-decoration-none btnbg border-end rounded-start">Submit</a>
                                                <a href="#"
                                                    class="w-50 text-center p-2 text-decoration-none btnbg rounded-end border-start">Review</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TYFBFC Given -->
                                    <div class="col-12  col-lg-4">
                                        <div class="rounded border h-100 d-flex flex-column bg-white">
                                            <div class="text-center pt-3">
                                                <h6 class="card-title text-dark">TYFBFC Given:</h6>
                                                <div class="my-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="#000" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                                        <path fill-rule="evenodd"
                                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                                    </svg>
                                                </div>
                                                <h5 class="card-subtitle mb-3 text-body-secondary">S$ 277</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lower Section -->
                        <div class="row g-3  pt-2 ">
                            <!-- Left Column Links -->
                            <div class="col-12 col-lg-4">
                                <div class="rounded h-100 d-flex flex-column gap-3 ">
                                    <a href="#"
                                        class="border rounded text-center p-2 fs-6 text-decoration-none text-dark bg-white">Personal
                                        Meeting Activity</a>
                                    <a href="#"
                                        class="border rounded text-center p-2 fs-6 text-decoration-none text-dark bg-white">Referrals
                                        Track Sheet Report</a>
                                    <a href="#"
                                        class="border rounded text-center p-2 fs-6 text-decoration-none text-dark bg-white">My
                                        Personal Summary</a>
                                </div>
                            </div>

                            <!-- Right Cards -->
                            <div class="col-12 h-100 col-lg-8">
                                <div class="row g-3">
                                    <!-- Visitor -->
                                    <div class="col-12  col-lg-4">
                                        <div class="rounded border h-100 d-flex flex-column bg-white">
                                            <div class="text-center pt-3">
                                                <h6 class="card-title text-dark ">Visitor:</h6>
                                                <img src="./images/user22.png" alt="User"
                                                    class="rounded-circle cardimg my-3">
                                                <h5 class="card-subtitle mb-3 text-body-secondary">0</h5>
                                            </div>
                                            <a href="#"
                                                class="w-100 mt-auto text-center p-2 text-decoration-none btnbg rounded-bottom">Visitor
                                                Portal</a>
                                        </div>
                                    </div>

                                    <!-- CEUs -->
                                    <div class="col-12 col-lg-4">
                                        <div class="rounded border h-100 d-flex flex-column bg-white">
                                            <div class="text-center pt-3">
                                                <h6 class="card-title text-dark">CEUs:</h6>
                                                <img src="./images/user22.png" alt="User"
                                                    class="rounded-circle cardimg my-3">
                                                <h5 class="card-subtitle mb-3 text-body-secondary">64</h5>
                                            </div>
                                            <div class="d-flex mt-auto">
                                                <a href="#"
                                                    class="w-50 text-center p-2 text-decoration-none btnbg border-end rounded-start">Submit</a>
                                                <a href="#"
                                                    class="w-50 text-center p-2 text-decoration-none btnbg rounded-end border-start">Review</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- One to Ones -->
                                    <div class="col-12  col-lg-4">
                                        <div class="rounded border h-100 d-flex flex-column bg-white">
                                            <div class="text-center pt-3">
                                                <h6 class="card-title text-dark">One to Ones:</h6>
                                                <img src="./images/user22.png" alt="User"
                                                    class="rounded-circle cardimg my-3">
                                                <h5 class="card-subtitle mb-3 text-body-secondary">S$ 277</h5>
                                            </div>
                                            <div class="d-flex mt-auto">
                                                <a href="#"
                                                    class="w-50 text-center p-2 text-decoration-none btnbg border-end rounded-start">Submit</a>
                                                <a href="#"
                                                    class="w-50 text-center p-2 text-decoration-none btnbg rounded-end border-start">Review</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('memberGrowthChart').getContext('2d');
    
    const data = {
        labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        datasets: [{
            label: 'Total Members',
            data: [3, 5, 18, 25, 28, 28],
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#dc3545',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0',
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: 5,
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
@endsection
