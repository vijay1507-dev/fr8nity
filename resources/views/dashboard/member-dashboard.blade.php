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
                                class="fs-6">{{ number_format($totalPoints ?? 0) }}</span>
                        </div>
                        <div class="d-flex membership align-items-center justify-content-center px-3 py-1">
                            <h6 class="fw-semibold mb-0">Redeemed Points:</h6><span class="fs-6">N/A</span>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="monthbtn p-2 px-3 ms-2" data-period="3">Last 3 months</button>
                        <button type="button" class="monthbtn p-2 px-3 ms-2" data-period="6">Last 6 months</button>
                        <button type="button" class="monthbtn p-2 ms-2 px-3 active" data-period="12"> Last 1 year</button>
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
                                <h2 class="mb-0 mt-3" data-target="given-transaction-value">
                                    ${{ number_format(auth()->user()->givenQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->sum('transaction_value'), 2) }}
                                </h2>
                                <p class="pt-2">Transaction Value Given</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Given Quotations">
                                <h2 class="mb-0 mt-3" data-target="given-successful-count">
                                    {{ auth()->user()->givenQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Given (Successful)</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Given Quotations">
                                <h2 class="mb-0 mt-3" data-target="given-unsuccessful-count">
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
                                <h2 class="mb-0 mt-3" data-target="referrals-count">{{ auth()->user()->referrals()->count() }}</h2>
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
                                <h2 class="mb-0 mt-3" data-target="received-transaction-value">
                                    ${{ number_format(auth()->user()->receivedQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->sum('transaction_value'), 2) }}
                                </h2>
                                <p class="pt-2">Transaction Value Received</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon4.svg') }}" alt="Received Quotations">
                                <h2 class="mb-0 mt-3" data-target="received-successful-count">
                                    {{ auth()->user()->receivedQuotations()->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->count() }}
                                </h2>
                                <p class="pt-2">Enquiries Received (Successful)</p>
                            </div>
                            <div class="col-4 p-3 py-4 text-center border-l">
                                <img src="{{ asset('images/dashboardIcon4.svg') }}" alt="Received Quotations">
                                <h2 class="mb-0 mt-3" data-target="received-unsuccessful-count">
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
                            <div>
                                <h1 class="chart-title">Membership Leadership Board</h1>
                                
                            </div>
                            <div class="d-flex gap-3">
                                <label for="yearFilter" class="small text-muted mb-0">Filter by Year:</label>
                                <select id="yearFilter" class="form-select form-select-sm" style="width: auto;" onchange="filterByYear(this.value)">
                                    @foreach(\App\Helpers\Helper::getAvailableYears() as $year)
                                        <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Leaderboard Wrapper -->
                        <div class="leaderboard-wrapper p-3" style="max-height: 400px; overflow-y: auto;">
                            @if(count($leadershipBoard ?? []) > 0)
                                <ul class="list-unstyled mb-0">
                                    @foreach($leadershipBoard as $leader)
                                    <li class="d-flex align-items-center mb-3 p-2 rounded leaderboard-item">
                                        <img src="{{ $leader['company_logo'] }}" class="rounded-circle me-3" width="50" height="50" alt="{{ $leader['company_name'] }}">
                                        <div class="flex-grow-1">
                                            <div class="text-muted small">{{ $leader['month'] }}</div>
                                            <span class="fw-semibold d-block">{{ $leader['company_name'] }}</span>
                                            <div class="text-muted small">{{ $leader['points'] }} pts</div>
                                        </div>
                                        <span class="badge bg-warning text-dark">Top Leader</span>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center text-muted py-4">
                                    <p>No leaderboard data available yet.</p>
                                    <p class="small">Start earning points to appear on the leaderboard!</p>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                </div>


                <!-- Trade Surplus/Deficit Chart -->
                <div class="col-lg-6 d-flex">
                    <div class="chart-card w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="chart-title">Trade Surplus/Deficit </h1>
                            </div>
                            <div class="d-flex gap-3">
                                <label for="chartYearFilter" class="small text-muted mb-0">Filter by Year:</label>
                                <select id="chartYearFilter" class="form-select form-select-sm" style="width: auto;">
                                    @for($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
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
        // Year filter function with AJAX
        function filterByYear(year) {
            // Show loading state
            const leaderboardWrapper = document.querySelector('.leaderboard-wrapper');
            const originalContent = leaderboardWrapper.innerHTML;
            leaderboardWrapper.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading leadership board data...</p>
                </div>
            `;
            
            // Make AJAX request
            fetch('{{ route("dashboard.leadership-board") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ year: year })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateLeaderboard(data.data);
                    // Update URL without page reload
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.set('year', year);
                    window.history.pushState({}, '', currentUrl.toString());
                } else {
                    throw new Error('Failed to load data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                leaderboardWrapper.innerHTML = `
                    <div class="text-center text-danger py-4">
                        <p>Error loading leadership board data.</p>
                        <button class="btn btn-sm btn-outline-primary" onclick="filterByYear(${year})">Retry</button>
                    </p>
                </div>
                `;
            });
        }
        
        // Function to update the leaderboard content
        function updateLeaderboard(data) {
            const leaderboardWrapper = document.querySelector('.leaderboard-wrapper');
            
            if (data.length > 0) {
                let html = '<ul class="list-unstyled mb-0">';
                
                data.forEach(leader => {
                    html += `
                        <li class="d-flex align-items-center mb-3 p-2 rounded leaderboard-item">
                            <img src="${leader.company_logo}" class="rounded-circle me-3" width="50" height="50" alt="${leader.company_name}">
                            <div class="flex-grow-1">
                                <div class="text-muted small">${leader.month}</div>
                                <span class="fw-semibold d-block">${leader.company_name}</span>
                                <div class="text-muted small">${leader.points} pts</div>
                            </div>
                            <span class="badge bg-warning text-dark">Top Leader</span>
                        </li>
                    `;
                });
                
                html += '</ul>';
                leaderboardWrapper.innerHTML = html;
            } else {
                leaderboardWrapper.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <p>No leaderboard data available for this year.</p>
                        <p class="small">Try selecting a different year.</p>
                    </div>
                `;
            }
        }
    </script>
    
    <script>
        // Dashboard Filter Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.monthbtn');
            let currentPeriod = 12; 
            let originalValues = {}; 
            
            // Store original values when page loads
            function storeOriginalValues() {
                document.querySelectorAll('[data-target]').forEach(element => {
                    const target = element.getAttribute('data-target');
                    originalValues[target] = element.textContent;
                });
            }
            
            // Store original values on page load
            storeOriginalValues();
            
            // Add click event listeners to filter buttons
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const period = parseInt(this.getAttribute('data-period'));
                    
                    // Update active state
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Only make AJAX request if period changed
                    if (period !== currentPeriod) {
                        currentPeriod = period;
                        updateDashboardData(period);
                    }
                });
            });
            
            // Function to update dashboard data via AJAX
            function updateDashboardData(period) {
                // Show loading state
                showLoadingState();
                
                fetch('{{ route("dashboard.filtered-data") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ period: period })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    updateDashboardValues(data);
                    hideLoadingState();
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                    hideLoadingState();
                    alert('Failed to update dashboard data. Please try again.');
                });
            }
            
            // Function to update dashboard values
            function updateDashboardValues(data) {
                // Simple function to update values
                const updateValue = (selector, newValue) => {
                    const element = document.querySelector(selector);
                    if (element) {
                        if (selector.includes('transaction-value')) {
                            element.textContent = '$' + parseFloat(newValue).toFixed(2);
                        } else {
                            element.textContent = newValue;
                        }
                    }
                };
                
                // Update Given Quotations
                updateValue('[data-target="given-transaction-value"]', data.given_quotations.transaction_value);
                updateValue('[data-target="given-successful-count"]', data.given_quotations.successful_count);
                updateValue('[data-target="given-unsuccessful-count"]', data.given_quotations.unsuccessful_count);
                
                // Update Received Quotations
                updateValue('[data-target="received-transaction-value"]', data.received_quotations.transaction_value);
                updateValue('[data-target="received-successful-count"]', data.received_quotations.successful_count);
                updateValue('[data-target="received-unsuccessful-count"]', data.received_quotations.unsuccessful_count);
                
                // Update Referrals
                updateValue('[data-target="referrals-count"]', data.referrals.count);
            }
            
            // Function to show loading state
            function showLoadingState() {
                // Show "Updating..." in place of values
                document.querySelectorAll('[data-target]').forEach(element => {
                    element.textContent = 'Updating...';
                    element.style.color = '#6c757d';
                    element.style.fontStyle = 'italic';
                    element.style.fontSize = '14px';
                });
                
                // Disable filter buttons during loading
                document.querySelectorAll('.monthbtn').forEach(btn => {
                    btn.disabled = true;
                    btn.style.opacity = '0.6';
                    btn.style.cursor = 'not-allowed';
                });
            }
            
            // Function to hide loading state
            function hideLoadingState() {
                // Restore original styling
                document.querySelectorAll('[data-target]').forEach(element => {
                    element.style.color = '';
                    element.style.fontStyle = '';
                    element.style.fontSize = '';
                });
                
                // Re-enable filter buttons
                document.querySelectorAll('.monthbtn').forEach(btn => {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.style.cursor = 'pointer';
                });
            }
        });
    </script>
    
    <script>
        // Trade Surplus/Deficit Chart
        let tradeChart;
        
        // Function to initialize the chart
        function initializeTradeChart() {
            const ctx = document.getElementById('tradeChart').getContext('2d');
            tradeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Transaction Value Given',
                        data: [],
                        borderColor: 'rgba(181, 131, 32, 1)',
                        backgroundColor: 'rgba(181, 131, 32, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.5,
                        pointBackgroundColor: 'rgba(181, 131, 32, 1)',
                        pointBorderColor: '#000',
                        pointBorderWidth: 1,
                        pointRadius: 4
                    },
                    {
                        label: 'Transaction Value Received',
                        data: [],
                        borderColor: '#000',
                        backgroundColor: '#000',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        fill: false,
                        tension: 0.5,
                        pointBackgroundColor: '#000',
                        pointBorderColor: '#000',
                        pointBorderWidth: 1,
                        pointRadius: 4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += '$' + context.parsed.y.toLocaleString();
                                    }
                                    return label;
                                }
                            }
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
                                color: '#000',
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            },
                            grid: {
                                color: '#eee'
                            }
                        }
                    }
                }
            });
        }
        
        // Function to update chart data
        function updateChartData() {
            const selectedYear = document.getElementById('chartYearFilter').value;
            
            // Show loading state
            if (tradeChart) {
                tradeChart.data.labels = ['Loading...', '', '', '', ''];
                tradeChart.data.datasets[0].data = [0, 0, 0, 0, 0];
                tradeChart.data.datasets[1].data = [0, 0, 0, 0, 0];
                tradeChart.update();
            }
            
            fetch('{{ route("dashboard.chart-data") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ year: selectedYear })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (tradeChart) {
                    tradeChart.data.labels = data.labels;
                    tradeChart.data.datasets[0].data = data.given_data;
                    tradeChart.data.datasets[1].data = data.received_data;
                    tradeChart.update();
                }
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                // Show error state
                if (tradeChart) {
                    tradeChart.data.labels = ['Error loading data'];
                    tradeChart.data.datasets[0].data = [0];
                    tradeChart.data.datasets[1].data = [0];
                    tradeChart.update();
                }
            });
        }
        
        // Initialize chart when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeTradeChart();
            updateChartData(); // Load current year data by default
            
            // Add event listener for year filter
            document.getElementById('chartYearFilter').addEventListener('change', function() {
                updateChartData();
            });
        });
        
    </script>

@endsection
