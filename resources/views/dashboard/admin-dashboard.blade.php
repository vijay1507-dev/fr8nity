@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="mb-3">
                <h5>Welcome Back, <span style="color: rgba(181, 131, 32, 1);">{{ ucfirst(Auth::user()->name) }}</span>
                </h5>
            </div>
            <div class="container rounded bg-white p-4">


                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex ">
                        <div class="">
                            <h6 class="fw-semibold mb-0"> Revenue & Monetisation Insights</h6>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="button" class="monthbtn p-2 px-3 ms-2" data-period="3">Last 3 months</button>
                        <button type="button" class="monthbtn p-2 px-3 ms-2" data-period="6">Last 6 months</button>
                        <button type="button" class="monthbtn p-2 px-3 ms-2 active" data-period="12">Last 1 year</button>
                    </div>
                </div>

                <div class="row g-3 pt-3">

                    <div class="col-12 col-lg-8">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3"> Membership fees by tier</h6>
                                
                                <!-- Total Revenue Summary -->
                                {{-- <div class="col-12 text-center mb-3">
                                    <div class="bg-light rounded p-3">
                                        <h4 class="mb-0" style="color: rgba(181, 131, 32, 1);" id="total-tier-revenue">
                                            Total: $ {{ number_format($adminData['membership_fees']['total']['total_revenue'] ?? 0) }}
                                        </h4>
                                        <small class="text-muted">Sum of all tier pricing</small>
                                    </div>
                                </div> --}}
                                
                                <div class="col-3 p-4 text-center">
                                    <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Explorer">
                                    <h2 class="mb-0 mt-3" id="explorer-revenue">
                                        $ {{ number_format($adminData['membership_fees']['explorer']['total_revenue'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2">Explorer </p>
                                    <small class="text-muted">{{ number_format($adminData['membership_fees']['explorer']['count'] ?? 0) }} active members</small>
                                    <br>
                                    <small class="text-info">Annual Fee: ${{ number_format($adminData['membership_fees']['explorer']['annual_fee'] ?? 0) }}</small>
                                </div>
                                <div class="col-3 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Elevate">
                                    <h2 class="mb-0 mt-3" id="elevate-revenue">
                                        $ {{ number_format($adminData['membership_fees']['elevate']['total_revenue'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2"> Elevate</p>
                                    <small class="text-muted">{{ number_format($adminData['membership_fees']['elevate']['count'] ?? 0) }} active members</small>
                                    <br>
                                    <small class="text-info">Annual Fee: ${{ number_format($adminData['membership_fees']['elevate']['annual_fee'] ?? 0) }}</small>
                                </div>
                                <div class="col-3 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Summit">
                                    <h2 class="mb-0 mt-3" id="summit-revenue">
                                        $ {{ number_format($adminData['membership_fees']['summit']['total_revenue'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2">Summit</p>
                                    <small class="text-muted">{{ number_format($adminData['membership_fees']['summit']['count'] ?? 0) }} active members</small>
                                    <br>
                                    <small class="text-info">Annual Fee: ${{ number_format($adminData['membership_fees']['summit']['annual_fee'] ?? 0) }}</small>
                                </div>
                                <div class="col-3 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Pinnacle">
                                    <h2 class="mb-0 mt-3" id="pinnacle-revenue">
                                        $ {{ number_format($adminData['membership_fees']['pinnacle']['total_revenue'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2">Pinnacle</p>
                                    <small class="text-muted">{{ number_format($adminData['membership_fees']['pinnacle']['count'] ?? 0) }} active members</small>
                                    <br>
                                    <small class="text-info">Annual Fee: ${{ number_format($adminData['membership_fees']['pinnacle']['annual_fee'] ?? 0) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4 ">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3"> Average Revenue Per Month</h6>
                                <div class="col-12 text-center p-4">
                                    <img src="{{ asset('images/dashboardIcon5.svg') }}" alt="Average Revenue">
                                    <h2 class="mb-0 mt-3" id="avg-revenue"> $ {{ number_format($adminData['average_revenue'] ?? 0) }}</h2>
                                    <p class="pt-2">Monthly average revenue from all active members</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <h6 class="fw-semibold mb-0 mt-4">Strategic Growth Metrics</h6>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-12 col-lg-4 ">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3">New sign-ups</h6>
                                <div class="col-12 text-center p-4">
                                    <img src="{{ asset('images/dashboardIcon5.svg') }}" alt="New Sign-ups">
                                    <h2 class="mb-0 mt-3" id="new-signups">{{ number_format($adminData['new_signups'] ?? 0) }}</h2>
                                    <p class="pt-2">New member registrations in the selected period</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3">Member churn rate</h6>
                                <div class="col-6 p-4 text-center">
                                    <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Cancellations">
                                    <h2 class="mb-0 mt-3" id="cancellations">
                                        {{ number_format($adminData['member_churn']['cancellations'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2">Cancellations </p>
                                </div>
                                <div class="col-6 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Non-Renewals">
                                    <h2 class="mb-0 mt-3" id="non-renewals">
                                        {{ number_format($adminData['member_churn']['non_renewals'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2">Non-Renewals</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3 px-5">Helps spot which tiers are growing and which may need
                                    rework.
                                </h6>
                                <div class="col-6 p-4 text-center">
                                    <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Upgrades">
                                    <h2 class="mb-0 mt-3" id="upgrades">
                                        {{ number_format($adminData['tier_growth']['upgrades'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2">Upgrade </p>
                                </div>
                                <div class="col-6 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Downgrades">
                                    <h2 class="mb-0 mt-3" id="downgrades">
                                        {{ number_format($adminData['tier_growth']['downgrades'] ?? 0) }}
                                    </h2>
                                    <p class="pt-2">Downgrade</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <h6 class="pt-3">Global Coverage map</h6>
                    <div class="col-12">
                        <div class="map-border">
                            <div id="chartdiv"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </main>
@endsection


@section('scripts')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Period button functionality
            const periodButtons = document.querySelectorAll('.monthbtn');
            let currentPeriod = 12; // Default to 1 year

            periodButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    periodButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const period = parseInt(this.dataset.period);
                    currentPeriod = period;
                    
                    // Update dashboard data
                    updateAdminDashboardData(period);
                });
            });

            // Function to update admin dashboard data via AJAX
            function updateAdminDashboardData(period) {
                // Show loading state
                showLoadingState();
                
                console.log('Fetching admin dashboard data for period:', period);
                
                fetch('{{ route("dashboard.admin-data") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ period: period })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Admin dashboard data received:', data);
                    if (data.success) {
                        updateDashboardValues(data.data);
                    } else {
                        console.error('API returned success: false');
                        alert('Failed to update dashboard data. Please try again.');
                    }
                    hideLoadingState();
                })
                .catch(error => {
                    console.error('Error fetching admin dashboard data:', error);
                    hideLoadingState();
                    alert('Failed to update dashboard data. Please try again.');
                });
            }

            // Function to update dashboard values
            function updateDashboardValues(data) {
                try {
                    // Update total tier revenue (only if element exists)
                    const totalTierRevenueElement = document.getElementById('total-tier-revenue');
                    if (totalTierRevenueElement && data.membership_fees && data.membership_fees.total) {
                        totalTierRevenueElement.textContent = 'Total: $ ' + Number(data.membership_fees.total.total_revenue || 0).toLocaleString();
                    }

                    // Update membership fees by tier
                    if (data.membership_fees) {
                        if (data.membership_fees.explorer) {
                            const explorerElement = document.getElementById('explorer-revenue');
                            if (explorerElement) {
                                explorerElement.textContent = '$ ' + Number(data.membership_fees.explorer.total_revenue || 0).toLocaleString();
                            // Update member count
                                const explorerCountElement = explorerElement.parentNode.querySelector('small');
                            if (explorerCountElement) {
                                explorerCountElement.textContent = Number(data.membership_fees.explorer.count || 0).toLocaleString() + ' active members';
                            }
                            // Update annual fee
                            const explorerAnnualFeeElement = explorerCountElement?.nextElementSibling;
                            if (explorerAnnualFeeElement) {
                                explorerAnnualFeeElement.textContent = 'Annual Fee: $' + Number(data.membership_fees.explorer.annual_fee || 0).toLocaleString();
                                }
                            }
                        }
                        if (data.membership_fees.elevate) {
                            const elevateElement = document.getElementById('elevate-revenue');
                            if (elevateElement) {
                                elevateElement.textContent = '$ ' + Number(data.membership_fees.elevate.total_revenue || 0).toLocaleString();
                            // Update member count
                                const elevateCountElement = elevateElement.parentNode.querySelector('small');
                            if (elevateCountElement) {
                                elevateCountElement.textContent = Number(data.membership_fees.elevate.count || 0).toLocaleString() + ' active members';
                            }
                            // Update annual fee
                            const elevateAnnualFeeElement = elevateCountElement?.nextElementSibling;
                            if (elevateAnnualFeeElement) {
                                elevateAnnualFeeElement.textContent = 'Annual Fee: $' + Number(data.membership_fees.elevate.annual_fee || 0).toLocaleString();
                                }
                            }
                        }
                        if (data.membership_fees.summit) {
                            const summitElement = document.getElementById('summit-revenue');
                            if (summitElement) {
                                summitElement.textContent = '$ ' + Number(data.membership_fees.summit.total_revenue || 0).toLocaleString();
                            // Update member count
                                const summitCountElement = summitElement.parentNode.querySelector('small');
                            if (summitCountElement) {
                                summitCountElement.textContent = Number(data.membership_fees.summit.count || 0).toLocaleString() + ' active members';
                            }
                            // Update annual fee
                            const summitAnnualFeeElement = summitCountElement?.nextElementSibling;
                            if (summitAnnualFeeElement) {
                                summitAnnualFeeElement.textContent = 'Annual Fee: $' + Number(data.membership_fees.summit.annual_fee || 0).toLocaleString();
                                }
                            }
                        }
                        if (data.membership_fees.pinnacle) {
                            const pinnacleElement = document.getElementById('pinnacle-revenue');
                            if (pinnacleElement) {
                                pinnacleElement.textContent = '$ ' + Number(data.membership_fees.pinnacle.total_revenue || 0).toLocaleString();
                            // Update member count
                                const pinnacleCountElement = pinnacleElement.parentNode.querySelector('small');
                            if (pinnacleCountElement) {
                                pinnacleCountElement.textContent = Number(data.membership_fees.pinnacle.count || 0).toLocaleString() + ' active members';
                            }
                            // Update annual fee
                            const pinnacleAnnualFeeElement = pinnacleCountElement?.nextElementSibling;
                            if (pinnacleAnnualFeeElement) {
                                pinnacleAnnualFeeElement.textContent = 'Annual Fee: $' + Number(data.membership_fees.pinnacle.annual_fee || 0).toLocaleString();
                                }
                            }
                        }
                    }

                    // Update average revenue
                    const avgRevenueElement = document.getElementById('avg-revenue');
                    if (avgRevenueElement && data.average_revenue !== undefined) {
                        avgRevenueElement.textContent = '$ ' + Number(data.average_revenue || 0).toLocaleString();
                    }

                    // Update new sign-ups
                    const newSignupsElement = document.getElementById('new-signups');
                    if (newSignupsElement && data.new_signups !== undefined) {
                        newSignupsElement.textContent = Number(data.new_signups || 0).toLocaleString();
                    }

                    // Update member churn data
                    if (data.member_churn) {
                        const cancellationsElement = document.getElementById('cancellations');
                        if (cancellationsElement && data.member_churn.cancellations !== undefined) {
                            cancellationsElement.textContent = Number(data.member_churn.cancellations || 0).toLocaleString();
                        }
                        const nonRenewalsElement = document.getElementById('non-renewals');
                        if (nonRenewalsElement && data.member_churn.non_renewals !== undefined) {
                            nonRenewalsElement.textContent = Number(data.member_churn.non_renewals || 0).toLocaleString();
                        }
                    }

                    // Update tier growth data
                    if (data.tier_growth) {
                        const upgradesElement = document.getElementById('upgrades');
                        if (upgradesElement && data.tier_growth.upgrades !== undefined) {
                            upgradesElement.textContent = Number(data.tier_growth.upgrades || 0).toLocaleString();
                        }
                        const downgradesElement = document.getElementById('downgrades');
                        if (downgradesElement && data.tier_growth.downgrades !== undefined) {
                            downgradesElement.textContent = Number(data.tier_growth.downgrades || 0).toLocaleString();
                        }
                    }

                    // Update map data
                    if (data.country_members) {
                        updateMapData(data.country_members);
                    }
                } catch (error) {
                    console.error('Error updating dashboard values:', error);
                    hideLoadingState();
                }
            }

            // Function to show loading state
            function showLoadingState() {
                // Add loading indicators to key elements
                const elements = ['explorer-revenue', 'elevate-revenue', 'summit-revenue', 'pinnacle-revenue', 
                                'avg-revenue', 'new-signups', 'cancellations', 'non-renewals', 'upgrades', 'downgrades'];
                
                elements.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.dataset.originalContent = element.textContent;
                        element.textContent = 'Updating...';
                        element.style.opacity = '0.7';
                        element.style.color = '#6c757d'; // Light gray color
                        element.style.fontSize = '0.875rem'; // Smaller font size (14px)
                    }
                });

                // Show loading state for map
                const mapContainer = document.getElementById('chartdiv');
                if (mapContainer) {
                    mapContainer.style.opacity = '0.7';
                }
            }

            // Function to hide loading state
            function hideLoadingState() {
                const elements = ['explorer-revenue', 'elevate-revenue', 'summit-revenue', 'pinnacle-revenue', 
                                'avg-revenue', 'new-signups', 'cancellations', 'non-renewals', 'upgrades', 'downgrades'];
                
                elements.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.style.opacity = '1';
                        element.style.color = ''; 
                        element.style.fontSize = ''; 
                    }
                });

                // Restore map opacity
                const mapContainer = document.getElementById('chartdiv');
                if (mapContainer) {
                    mapContainer.style.opacity = '1';
                }
            }

            // Init amCharts
            var root = am5.Root.new("chartdiv");
            root.setThemes([am5themes_Animated.new(root)]);
            if (root._logo) root._logo.dispose();

            // Create map chart
            var chart = root.container.children.push(am5map.MapChart.new(root, {
                panX: "translateX",
                panY: "translateY",
                wheelY: "zoom",
                pinchZoom: true,
                homeZoomLevel: 1,
                homeGeoPoint: { longitude: 10, latitude: 40 },
                minZoomLevel: 1,
                maxZoomLevel: 5
            }));

            chart.set("panBehavior", "move");

            // Add zoom buttons
            var zoomControl = am5map.ZoomControl.new(root, {
                layout: root.verticalLayout
            });
            chart.set("zoomControl", zoomControl);

            // Style zoom buttons
            zoomControl.minusButton.setAll({
                background: am5.RoundedRectangle.new(root, {
                    fill: am5.color(0xb58320),
                    stroke: am5.color(0x999999),
                    cornerRadiusBL: 10,
                    cornerRadiusBR: 10
                })
            });
            zoomControl.plusButton.setAll({
                background: am5.RoundedRectangle.new(root, {
                    fill: am5.color(0xb58320),
                    stroke: am5.color(0x999999),
                    cornerRadiusTL: 10,
                    cornerRadiusTR: 10
                })
            });

            // Map polygon series for countries
            var worldSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
                geoJSON: am5geodata_worldLow,
                exclude: ["AQ"]
            }));

            var membersData = {!! json_encode($adminData['country_members'] ?? []) !!};

            // Default polygon settings
            worldSeries.mapPolygons.template.setAll({
                interactive: true,
                stroke: am5.color(0xffffff),
                strokeWidth: 1,
                fillOpacity: 0.8, // Ensure minimum visibility
                cursorOverStyle: "pointer",
                tooltip: am5.Tooltip.new(root, {
                    getFillFromSprite: false,
                    getLabelFillFromSprite: false,
                    autoTextColor: false,
                    background: am5.Rectangle.new(root, {
                        fill: am5.color(0x333333),
                        fillOpacity: 0.9,
                        stroke: am5.color(0xffffff),
                        strokeWidth: 1
                    })
                }),
                tooltipText: "[#b58320]{name}[/]\n[#ffffff]Total Members:[/] [#b58320]{members}[/]"

            });

            // Hover style
            worldSeries.mapPolygons.template.states.create("hover", {
                strokeWidth: 2,
                stroke: am5.color(0x000000)
            });

            // Function to highlight countries with distinct colors
            function highlightCountry(polygon, countryId) {
                // Define a color palette for different countries with better visibility
                var colorPalette = {
                    // Major countries with distinct colors
                    "US": { fill: 0xff6b6b, stroke: 0xcc5555, name: "United States" },
                    "CN": { fill: 0xff8e8e, stroke: 0xcc7272, name: "China" },
                    "IN": { fill: 0xffb366, stroke: 0xcc8f52, name: "India" },
                    "BR": { fill: 0xffcc66, stroke: 0xcca352, name: "Brazil" },
                    "RU": { fill: 0xffe666, stroke: 0xccb852, name: "Russia" },
                    "JP": { fill: 0xffff66, stroke: 0xcccc52, name: "Japan" },
                    "DE": { fill: 0xccff66, stroke: 0xa3cc52, name: "Germany" },
                    "GB": { fill: 0x99ff66, stroke: 0x7acc52, name: "United Kingdom" },
                    "FR": { fill: 0x66ff66, stroke: 0x52cc52, name: "France" },
                    "CA": { fill: 0x66ff99, stroke: 0x52cc7a, name: "Canada" },
                    "AU": { fill: 0x66ffcc, stroke: 0x52cca3, name: "Australia" },
                    "SG": { fill: 0xff0000, stroke: 0xcc0000, name: "Singapore" },
                    "AE": { fill: 0x6666ff, stroke: 0x5252cc, name: "UAE" },
                    "SA": { fill: 0x9966ff, stroke: 0x7a52cc, name: "Saudi Arabia" },
                    "KR": { fill: 0xcc66ff, stroke: 0xa352cc, name: "South Korea" },
                    "IT": { fill: 0xff66cc, stroke: 0xcc52a3, name: "Italy" },
                    "ES": { fill: 0xff6699, stroke: 0xcc527a, name: "Spain" },
                    "NL": { fill: 0xff6680, stroke: 0xcc5266, name: "Netherlands" },
                    "SE": { fill: 0xff6680, stroke: 0xcc5266, name: "Sweden" },
                    "NO": { fill: 0x80ff66, stroke: 0x66cc52, name: "Norway" },
                    "CH": { fill: 0x66ff80, stroke: 0x52cc66, name: "Switzerland" },
                    // Additional countries with better visibility
                    "MX": { fill: 0xffb3cc, stroke: 0xcc8fa3, name: "Mexico" },
                    "AR": { fill: 0xffb3e6, stroke: 0xcc8fb8, name: "Argentina" },
                    "ZA": { fill: 0xffb3ff, stroke: 0xcc8fcc, name: "South Africa" },
                    "EG": { fill: 0xccb3ff, stroke: 0xa38fcc, name: "Egypt" },
                    "NG": { fill: 0xb3b3ff, stroke: 0x8f8fcc, name: "Nigeria" },
                    "KE": { fill: 0xb3ccff, stroke: 0x8fa3cc, name: "Kenya" },
                    "TH": { fill: 0xb3ffcc, stroke: 0x8fcca3, name: "Thailand" },
                    "VN": { fill: 0xb3ffb3, stroke: 0x8fcc8f, name: "Vietnam" },
                    "MY": { fill: 0xccffb3, stroke: 0xa3cc8f, name: "Malaysia" },
                    "ID": { fill: 0xe6ffb3, stroke: 0xb8cc8f, name: "Indonesia" },
                    "PH": { fill: 0xffffb3, stroke: 0xcccc8f, name: "Philippines" },
                    "PK": { fill: 0xffe6b3, stroke: 0xccb88f, name: "Pakistan" },
                    "BD": { fill: 0xffccb3, stroke: 0xcca38f, name: "Bangladesh" },
                    "TR": { fill: 0xffb3b3, stroke: 0xcc8f8f, name: "Turkey" },
                    "IR": { fill: 0xffb3cc, stroke: 0xcc8fa3, name: "Iran" },
                    "IL": { fill: 0xccb3cc, stroke: 0xa38fa3, name: "Israel" },
                    "PL": { fill: 0xb3ccb3, stroke: 0x8fa38f, name: "Poland" },
                    "UA": { fill: 0xb3b3cc, stroke: 0x8f8fa3, name: "Ukraine" },
                    "RO": { fill: 0xccb3b3, stroke: 0xa38f8f, name: "Romania" },
                    "BG": { fill: 0xb3ccb3, stroke: 0x8fa38f, name: "Bulgaria" },
                    "GR": { fill: 0xb3b3cc, stroke: 0x8f8fa3, name: "Greece" },
                    "PT": { fill: 0xccb3cc, stroke: 0xa38fa3, name: "Portugal" },
                    "IE": { fill: 0xb3ccb3, stroke: 0x8fa38f, name: "Ireland" },
                    "FI": { fill: 0xccb3b3, stroke: 0xa38f8f, name: "Finland" },
                    "DK": { fill: 0xb3b3cc, stroke: 0x8f8fa3, name: "Denmark" },
                    "BE": { fill: 0xccb3cc, stroke: 0xa38fa3, name: "Belgium" },
                    "AT": { fill: 0xb3ccb3, stroke: 0x8fa38f, name: "Austria" },
                    "CZ": { fill: 0xb3b3cc, stroke: 0x8f8fa3, name: "Czech Republic" },
                    "HU": { fill: 0xccb3b3, stroke: 0xa38f8f, name: "Hungary" },
                    "SK": { fill: 0xb3ccb3, stroke: 0x8fa38f, name: "Slovakia" },
                    "HR": { fill: 0xb3b3cc, stroke: 0x8f8fa3, name: "Croatia" },
                    "SI": { fill: 0xccb3cc, stroke: 0xa38fa3, name: "Slovenia" },
                    "RS": { fill: 0xb3ccb3, stroke: 0x8fa38f, name: "Serbia" },
                    "BA": { fill: 0xb3b3cc, stroke: 0x8f8fa3, name: "Bosnia" },
                    "ME": { fill: 0xccb3b3, stroke: 0xa38f8f, name: "Montenegro" },
                    "MK": { fill: 0xb3ccb3, stroke: 0x8fa38f, name: "North Macedonia" },
                    "AL": { fill: 0xb3b3cc, stroke: 0x8f8fa3, name: "Albania" },
                    "XK": { fill: 0xccb3cc, stroke: 0xa38fa3, name: "Kosovo" }
                };

                // Get color for this country or use a default
                var countryColors = colorPalette[countryId];
                if (countryColors) {
                    polygon.set("fill", am5.color(countryColors.fill));
                    polygon.set("stroke", am5.color(countryColors.stroke));
                    polygon.set("strokeWidth", 2);
                } else {
                    // Generate a unique color for other countries based on country ID
                    var hash = 0;
                    for (var i = 0; i < countryId.length; i++) {
                        hash = countryId.charCodeAt(i) + ((hash << 5) - hash);
                    }
                    
                    // Use predefined fallback colors for unknown countries with better visibility
                    var fallbackColors = [
                        { fill: 0xdda0dd, stroke: 0xcc88cc }, // Plum
                        { fill: 0x98fb98, stroke: 0x88dd88 }, // Pale Green
                        { fill: 0x87ceeb, stroke: 0x77b8db }, // Sky Blue
                        { fill: 0xdda0dd, stroke: 0xcc88cc }, // Plum
                        { fill: 0xf0e68c, stroke: 0xe0d67c }, // Khaki
                        { fill: 0xdeb887, stroke: 0xcea477 }, // Burlywood
                        { fill: 0x5f9ea0, stroke: 0x4f8e90 }, // Cadet Blue
                        { fill: 0xb8860b, stroke: 0xa8760b }, // Dark Goldenrod
                        { fill: 0xcd853f, stroke: 0xbd753f }, // Peru
                        { fill: 0xdaa520, stroke: 0xca9520 }  // Goldenrod
                    ];
                    
                    var colorIndex = Math.abs(hash) % fallbackColors.length;
                    var selectedColors = fallbackColors[colorIndex];
                    
                    polygon.set("fill", am5.color(selectedColors.fill));
                    polygon.set("stroke", am5.color(selectedColors.stroke));
                    polygon.set("strokeWidth", 1.5);
                }
            }

            // Function to update map data
            function updateMapData(countryData) {
                membersData = countryData;
                worldSeries.mapPolygons.each(function (polygon) {
                    var id = polygon.dataItem.dataContext.id;
                    polygon.dataItem.dataContext.members = membersData[id] || 0;
                    polygon.dataItem.set("value", polygon.dataItem.dataContext.members);
                    
                    // Highlight all countries with distinct colors
                    highlightCountry(polygon, id);
                });
            }

            // Initialize map with default data
            worldSeries.events.on("datavalidated", function () {
                worldSeries.mapPolygons.each(function (polygon) {
                    var id = polygon.dataItem.dataContext.id;
                    polygon.dataItem.dataContext.members = membersData[id] || 0;
                    polygon.dataItem.set("value", polygon.dataItem.dataContext.members);
                    
                    // Highlight all countries with distinct colors
                    highlightCountry(polygon, id);
                });
            });

            // Heat rules
            worldSeries.set("heatRules", [{
                target: worldSeries.mapPolygons.template,
                dataField: "value",
                min: am5.color(0xd4e6f1),
                max: am5.color(0x154360)
            }]);

            // Click navigation
            worldSeries.mapPolygons.template.events.on("click", function (ev) {
                var countryId = ev.target.dataItem.dataContext.id;
                // Redirect to admin members page with country code as query parameter
                window.location.href = "/members?country=" + countryId;
            });
        });
    </script>
@endsection