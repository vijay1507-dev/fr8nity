@extends('layouts.dashboard')

@section('title', 'Member Dashboard')

@section('content')
    <main class="content px-3 py-4">
        <!-- memder dashboard -->
        <div class="dashboard-header d-flex justify-content-between">
            <div>
                <h5>Welcome Back, <span style="color: rgba(181, 131, 32, 1);">{{ ucfirst(Auth::user()->name) }}</span>
                </h5>
            </div>

            @php
                $startAt = Auth::user()->membership_start_at;
                $expiresAt = Auth::user()->membership_expires_at;
            @endphp
            <div class="d-flex membership align-items-center justify-content-center bg-white px-3 ">
                @if ($startAt && $expiresAt)
                    <h6 class="fw-semibold mb-0">Membership Period : </h6><span class="fs-6 ps-1"
                        style="color: rgba(181, 131, 32, 1);"> {{ optional($startAt)->format('d M Y') ?? 'N/A' }}
                        <span style="color: #000">-</span>
                        {{ optional($expiresAt)->format('d M Y') ?? 'N/A' }}</span>
            </div>
                @else
                <h6 class="fw-semibold mb-0">Membership Period : </h6><span class="fs-6"> N/A</span>
                @endif
        </div>

        <div class="container rounded  bg-white ">
            <div class="row mt-3 pt-4 pb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <div class="d-flex membership align-items-center justify-content-center px-3 py-1 ">
                            <h6 class="fw-semibold mb-0">Accumulated Points to Date:</h6><span
                                class="fs-6">1234567890</span>
                        </div>
                        <div class="d-flex membership align-items-center justify-content-center px-3 py-1">
                            <h6 class="fw-semibold mb-0">Redeemped Points:</h6><span class="fs-6">1234567890</span>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="monthbtn  p-2 px-3 ms-2">Last 6 months</button>
                        <button type="button" class="monthbtn p-2  ms-2 px-3 active"> Last 1 year</button>
                        <button type="button" class="monthbtn p-2 ms-2 px-3 ">Lifetime</button>
                        <button type="button" class="tooltip-btn p-1 ms-2 " data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="You can filter the data by selecting the time period">!</button>
                    </div>
                </div>
            </div>

            <div class="row g-3 pt-3">
                <!-- Card 1 -->
                <div class="col-12 col-lg-4">
                    <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                        <div class="row flex-grow-1">
                            <h6 class="text-center pt-3">Total Given Quotations / Transactions</h6>
                            <div class="col-6 p-4 text-center">
                                <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Transaction Value Given">
                                <h2 class="mb-0 mt-3">
                                    ${{ number_format(auth()->user()->givenQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->sum('transaction_value'), 2) }}
                                </h2>
                                <p class="pt-2">Transaction Value Given</p>
                            </div>
                            <div class="col-6 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Given Quotations">
                                <h2 class="mb-0 mt-3">
                                    {{ auth()->user()->givenQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Given (Freight Member)</p>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button class="view-btn"
                                onclick="window.location.href='{{ route('member.quotations.given') }}'">View</button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-lg-4">
                    <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                        <div class="row flex-grow-1">
                            <h6 class="text-center pt-3">Total Received Quotations / Transactions</h6>
                            <div class="col-6 p-4 text-center">
                                <img src="{{ asset('images/dashboardIcon3.svg') }}" alt="Transaction Value Received">
                                <h2 class="mb-0 mt-3">
                                    ${{ number_format(auth()->user()->receivedQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->sum('transaction_value'), 2) }}
                                </h2>
                                <p class="pt-2">Transaction Value Received</p>
                            </div>
                            <div class="col-6 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon4.svg') }}" alt="Received Quotations">
                                <h2 class="mb-0 mt-3">
                                    {{ auth()->user()->receivedQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Received (Freight Member)</p>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button class="view-btn"
                                onclick="window.location.href='{{ route('member.quotations.received') }}'">View</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-2 ">
                    <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                        <div class="row flex-grow-1">
                            <h6 class="text-center pt-3">Total Members referred</h6>
                            <div class="col-12 text-center p-4">
                                <img src="{{ asset('images/dashboardIcon5.svg') }}" alt="Members referred to">
                                <h2 class="mb-0 mt-3">{{ auth()->user()->referrals()->count() }}</h2>
                                <p class="pt-2">Members referred to</p>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button class="view-btn"
                                onclick="window.location.href='{{ route('referrals.index') }}'">View</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-2 ">
                    <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                        <div class="row flex-grow-1">
                            <h6 class="text-center pt-3">Events attended till date</h6>
                            <div class="col-12 text-center p-4">
                                <img src="{{ asset('images/dashboardIcon6.svg') }}" alt="Events attended till date">
                                <h2 class="mb-0 mt-3">N/A</h2>
                                <p class="pt-2">Events attended till date</p>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button class="view-btn">View</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3 pt-3 align-items-stretch">
                <!-- Membership Chart -->
                <div class="col-lg-7 d-flex">
                    <div class="chart-card w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="chart-title">Membership Leadership Board</h1>
                            <div> <img src="{{ asset('images/graphicondashboard.svg') }}"
                                    alt="Membership Leadership Board"></div>

                        </div>
                        <div class="chart-wrapper">
                            <canvas id="membershipChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Trade Surplus/Deficit Chart -->
                <div class="col-lg-5 d-flex">
                    <div class="chart-card w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="chart-title">Trade Surplus/Deficit </h1>
                            <div> <img src="{{ asset('images/graphicondashboard.svg') }}"
                                    alt="Membership Leadership Board"></div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="tradeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="./js/admin.js"></script>
    <script>
        // Initialize all tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


        const chartConfig = {
            type: 'line',
            data: {
                labels: ["Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                datasets: [{
                    data: [2, 3, 15, 25, 28, 28],
                    backgroundColor: 'rgba(181, 131, 32, 1)',
                    borderColor: 'rgba(181, 131, 32, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(181, 131, 32, 1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 30,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        };

        // Initialize both charts
        new Chart(document.getElementById('membershipChart1'), chartConfig);
        new Chart(document.getElementById('membershipChart2'), chartConfig);
    </script>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('memberGrowthChart').getContext('2d');

            const data = {
                labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Total Members',
                    data: [3, 5, 18, 25, 28, 28],
                    borderColor: 'rgba(181, 131, 32, 1)',
                    backgroundColor: 'rgba(181, 131, 32, 1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(181, 131, 32, 1)',
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

    <!-- new -->
    <script>
        // Membership Chart
        const ctx = document.getElementById('membershipChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(181, 131, 32, 0.15)');
        gradient.addColorStop(1, 'rgba(181, 131, 32, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                datasets: [{
                    data: [8, 12, 9, 11, 18, 9, 11, 6],
                    backgroundColor: gradient,
                    borderColor: 'rgba(181, 131, 32, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(181, 131, 32, 1)',
                    pointRadius: 5,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#222',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawTicks: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: (context) => context.tick.label === 'May' ? 'rgba(181, 131, 32, 1)' : '#555',
                            font: context => {
                                const label = context.tick.label;
                                return {
                                    weight: label === 'May' ? '600' : '400'
                                };
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#888',
                            stepSize: 5
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        }
                    }
                }
            }
        });

        // Trade Surplus/Deficit Chart
        new Chart(document.getElementById('tradeChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                        data: [5, 30, 25, 28, 40],
                        borderColor: 'rgba(181, 131, 32, 1)',
                        backgroundColor: 'rgba(181, 131, 32, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.5
                    },
                    {
                        data: [3, 25, 20, 22, 35],
                        borderColor: '#000',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        fill: false,
                        tension: 0.5
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#000'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            color: '#000'
                        },
                        grid: {
                            color: '#eee'
                        }
                    }
                }
            }
        });
    </script>

@endsection
