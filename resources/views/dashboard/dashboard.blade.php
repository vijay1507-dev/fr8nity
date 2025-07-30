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

               <h3 class="mb-4">Welcome Back Emma</h3>
            <div class=" bggray dashboard_referrals">
                <div class="row mb-4">
                   <div class="col-12 col-md-6">
                        <p class="mb-2 fw-bold">Accumulated Points to Date: 13245678</p>
                        <p class="mb-2 d-block fw-bold">Redeemped Points: 13245678</p>
                   </div>
                   <div class="col-12 col-md-6">
                        <ul class="d-flex flex-wrap gap-2 list-unstyled mb-1 align-items-center justify-content-end">
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
                        <p class="text-end">Membership Period: 29/7/2025 ΤΟ 28/7/2025</p>
                   </div>
                </div>

                <div class="row  px-3">
                    <div class="col-12 col-lg-5 mb-3 mb-lg-0">
                        <div class="p-3 border rounded bg-white">
                            <h6 class="mb-3">Membership Leadership Board</h6>
                            <div class="chart-container" style="position: relative; height: 200px;">
                                <canvas id="memberGrowthChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7 pe-0">
                        <div class="row g-3  mb-1">
                            <!-- Left Panel -->
                            <div class="col-12 col-md-6">
                                <div class="rounded border bg-white">
                                   <div class="row mx-0">
                                        <div class="col-6 text-center p-2 pt-3 border-end">
                                            <h6 class="card-title text-dark mb-3">Transaction Value Given</h6>
                                            <h5 class="card-subtitle mb-3 text-body-secondary">$ 213,454</h5>
                                        </div>
                                        <div class="col-6 text-center p-2 pt-3">
                                            <h6 class="card-title text-dark mb-3">Enquiries Given (Freight Member)</h6>
                                            <h5 class="card-subtitle mb-3 text-body-secondary">11</h5>
                                        </div>
                                   </div>
                                    <div class="d-flex mt-auto">
                                        <a href="#"
                                            class="w-100 text-center p-2 text-decoration-none btnbg rounded-start border-end">View</a>
                                    </div>
                                </div>
                            </div>
                             <div class="col-12 col-md-6">
                                <div class="rounded border bg-white">
                                   <div class="row mx-0">
                                        <div class="col-6 text-center p-2 pt-3 border-end">
                                            <h6 class="card-title text-dark mb-3">Transaction Value Received</h6>
                                            <h5 class="card-subtitle mb-3 text-body-secondary">$ 213,454</h5>
                                        </div>
                                        <div class="col-6 text-center p-2 pt-3">
                                            <h6 class="card-title text-dark mb-3">Enquiries Receive (Freight Member)</h6>
                                            <h5 class="card-subtitle mb-3 text-body-secondary">11</h5>
                                        </div>
                                   </div>
                                    <div class="d-flex mt-auto">
                                        <a href="#"
                                            class="w-100 text-center p-2 text-decoration-none btnbg rounded-start border-end">View</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                       
                    </div>
                </div>


                 <div class="row  px-3 mt-4">
                    <div class="col-12 col-lg-5 mb-3 mb-lg-0">
                        <div class="p-3 border rounded bg-white">
                            <h6 class="mb-3">Trade surplus/deficit</h6>
                            <div class="chart-container" style="position: relative; height: 200px;">
                                <canvas id="memberGrowthChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7 pe-0">
                        <div class="row g-3  mb-1">
                            <!-- Left Panel -->
                            <div class="col-12 col-md-6">
                                <div class="rounded border bg-white">                                  
                                    <div class="col-12 text-center p-2 pt-3">
                                        <h6 class="card-title text-dark mb-3">Members referred to FR8NITY</h6>
                                        <h5 class="card-subtitle mb-3 text-body-secondary">256</h5>
                                    </div>
                                    <div class="d-flex mt-auto">
                                        <a href="#"
                                            class="w-100 text-center p-2 text-decoration-none btnbg rounded-start border-end">View</a>
                                    </div>
                                </div>
                            </div>
                             <div class="col-12 col-md-6">
                                <div class="rounded border bg-white">
                                        <div class="col-12 text-center p-2 pt-3 border-end">
                                            <h6 class="card-title text-dark mb-3">Events attended till date</h6>
                                            <h5 class="card-subtitle mb-3 text-body-secondary">14</h5>
                                        </div>
                                    <div class="d-flex mt-auto">
                                        <a href="#"
                                            class="w-100 text-center p-2 text-decoration-none btnbg rounded-start border-end">View</a>
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
