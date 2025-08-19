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
                                class="fs-6">N/A</span>
                        </div>
                        <div class="d-flex membership align-items-center justify-content-center px-3 py-1">
                            <h6 class="fw-semibold mb-0">Redeemped Points:</h6><span class="fs-6">N/A</span>
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
                <div class="col-12 col-lg-7">
                    <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                        <div class="row flex-grow-1">
                            <h6 class="text-center pt-3">Total Given Quotations / Transactions</h6>
                            <div class="col-4 p-4 text-center">
                                <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Transaction Value Given">
                                <h2 class="mb-0 mt-3">
                                    ${{ number_format(auth()->user()->givenQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->sum('transaction_value'), 2) }}
                                </h2>
                                <p class="pt-2">Transaction Value Given</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Given Quotations">
                                <h2 class="mb-0 mt-3">
                                    {{ auth()->user()->givenQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Given (Successful)</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Given Quotations">
                                <h2 class="mb-0 mt-3">
                                    {{ auth()->user()->givenQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Given (Unsuccessful)</p>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button class="view-btn"
                                onclick="window.location.href='{{ route('member.quotations.given') }}'">View</button>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-lg-5 ">
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
                <!-- Card 2 -->
                <div class="col-12 col-lg-7">
                    <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                        <div class="row flex-grow-1">
                            <h6 class="text-center pt-3">Total Received Quotations / Transactions</h6>
                            <div class="col-4 p-4 text-center">
                                <img src="{{ asset('images/dashboardIcon3.svg') }}" alt="Transaction Value Received">
                                <h2 class="mb-0 mt-3">
                                    ${{ number_format(auth()->user()->receivedQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->sum('transaction_value'), 2) }}
                                </h2>
                                <p class="pt-2">Transaction Value Received</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon4.svg') }}" alt="Received Quotations">
                                <h2 class="mb-0 mt-3">
                                    {{ auth()->user()->receivedQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Received (Successful)</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon4.svg') }}" alt="Received Quotations">
                                <h2 class="mb-0 mt-3">
                                    {{ auth()->user()->receivedQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Received (Unsuccessful)</p>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button class="view-btn"
                                onclick="window.location.href='{{ route('member.quotations.received') }}'">View</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 ">
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
                <div class="col-lg-6 d-flex">
                    <div class="chart-card w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="chart-title">Membership Leadership Board</h1>
                            <div>
                                <img src="{{ asset('images/graphicondashboard.svg') }}"
                                    alt="Membership Leadership Board">
                            </div>
                        </div>

                        <!-- Leaderboard Wrapper -->
                        <div class="leaderboard-wrapper p-3" style="max-height: 400px; overflow-y: auto;">
                            <ul class="list-unstyled mb-0">
                                @php
                                    // Example dummy data - top leader for each month
                                    $leaders = [
                                        ['name' => 'John Doe', 'points' => 1200, 'month' => 'January 2025', 'img' => 'https://i.pravatar.cc/50?img=1'],
                                        ['name' => 'Jane Smith', 'points' => 1100, 'month' => 'February 2025', 'img' => 'https://i.pravatar.cc/50?img=2'],
                                        ['name' => 'Michael Lee', 'points' => 980, 'month' => 'March 2025', 'img' => 'https://i.pravatar.cc/50?img=3'],
                                        ['name' => 'Sophia Brown', 'points' => 1050, 'month' => 'April 2025', 'img' => 'https://i.pravatar.cc/50?img=4'],
                                        ['name' => 'David Wilson', 'points' => 1150, 'month' => 'May 2025', 'img' => 'https://i.pravatar.cc/50?img=5'],
                                        ['name' => 'Emily Davis', 'points' => 950, 'month' => 'June 2025', 'img' => 'https://i.pravatar.cc/50?img=6'],
                                        ['name' => 'Chris Martin', 'points' => 1250, 'month' => 'July 2025', 'img' => 'https://i.pravatar.cc/50?img=7'],
                                        ['name' => 'Olivia Taylor', 'points' => 1080, 'month' => 'August 2025', 'img' => 'https://i.pravatar.cc/50?img=8'],
                                        ['name' => 'Daniel Thomas', 'points' => 990, 'month' => 'September 2025', 'img' => 'https://i.pravatar.cc/50?img=9'],
                                        ['name' => 'Sophia Johnson', 'points' => 1020, 'month' => 'October 2025', 'img' => 'https://i.pravatar.cc/50?img=10'],
                                        ['name' => 'James Anderson', 'points' => 1180, 'month' => 'November 2025', 'img' => 'https://i.pravatar.cc/50?img=11'],
                                        ['name' => 'Isabella White', 'points' => 1120, 'month' => 'December 2025', 'img' => 'https://i.pravatar.cc/50?img=12'],
                                    ];
                        
                                    // Convert month name to numeric value for sorting
                                    $monthOrder = [
                                        'January' => 1, 'February' => 2, 'March' => 3, 'April' => 4,
                                        'May' => 5, 'June' => 6, 'July' => 7, 'August' => 8,
                                        'September' => 9, 'October' => 10, 'November' => 11, 'December' => 12,
                                    ];
                        
                                    // Sort leaders in descending order of month
                                    usort($leaders, function ($a, $b) use ($monthOrder) {
                                        $monthA = explode(' ', $a['month'])[0];
                                        $monthB = explode(' ', $b['month'])[0];
                                        return $monthOrder[$monthB] <=> $monthOrder[$monthA]; // Descending
                                    });
                                @endphp
                        
                                @foreach ($leaders as $leader)
                                <li class="d-flex align-items-center mb-3 p-2 rounded leaderboard-item">
                                    <img src="{{ $leader['img'] }}" class="rounded-circle me-3" width="50" height="50" alt="{{ $leader['name'] }}">
                                    <div class="flex-grow-1">
                                        <div class="text-muted small">{{ $leader['month'] }}</div>
                                        <span class="fw-semibold d-block">{{ $leader['name'] }}</span>
                                        <div class="text-muted small">{{ $leader['points'] }} pts</div>
                                    </div>
                                    <span class="badge bg-warning text-dark">Top Leader</span>
                                </li>
                                
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                </div>


                <!-- Trade Surplus/Deficit Chart -->
                <div class="col-lg-6 d-flex">
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

    <script>
        // Initialize all tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
    <script>
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
