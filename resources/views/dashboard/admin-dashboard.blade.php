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
                            <h6 class="fw-semibold mb-0">Strategic Growth Metrics</h6>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="button" class="monthbtn p-2 px-3 ms-2">Last 3 months</button>
                        <button type="button" class="monthbtn p-2 px-3 ms-2">Last 6 months</button>
                        <button type="button" class="monthbtn p-2 px-3 ms-2 active">Last 1 year</button>
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-12 col-lg-4 ">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3">New sign-ups</h6>
                                <div class="col-12 text-center p-4">
                                    <img src="{{ asset('images/dashboardIcon5.svg') }}" alt="Members referred to">
                                    <h2 class="mb-0 mt-3">00</h2>
                                    <p class="pt-2">Lorem, ipsum dolor. </p>
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
                                    <h2 class="mb-0 mt-3">
                                        00
                                    </h2>
                                    <p class="pt-2">Cancellations </p>
                                </div>
                                <div class="col-6 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Renewals">
                                    <h2 class="mb-0 mt-3">
                                        00
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
                                    <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Cancellations">
                                    <h2 class="mb-0 mt-3">
                                        00
                                    </h2>
                                    <p class="pt-2">Upgrade </p>
                                </div>
                                <div class="col-6 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Renewals">
                                    <h2 class="mb-0 mt-3">
                                        00
                                    </h2>
                                    <p class="pt-2">Downgrade</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <h6 class="fw-semibold mb-0 mt-4">Revenue & Monetisation Insights</h6>
                </div>

                <div class="row g-3 pt-3">

                    <div class="col-12 col-lg-8">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3"> Membership fees by tier</h6>
                                <div class="col-3 p-4 text-center">
                                    <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Cancellations">
                                    <h2 class="mb-0 mt-3">
                                        $ 00
                                    </h2>
                                    <p class="pt-2">Explorer </p>
                                </div>
                                <div class="col-3 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Renewals">
                                    <h2 class="mb-0 mt-3">
                                        $ 00
                                    </h2>
                                    <p class="pt-2"> Elevate</p>
                                </div>
                                <div class="col-3 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Renewals">
                                    <h2 class="mb-0 mt-3">
                                        $ 00
                                    </h2>
                                    <p class="pt-2">Summit</p>
                                </div>
                                <div class="col-3 p-3 py-4 text-center border-l">
                                    <img src="{{ asset('images/dashboardIcon2.svg') }}" alt="Renewals">
                                    <h2 class="mb-0 mt-3">
                                        $ 00
                                    </h2>
                                    <p class="pt-2">Pinnacle</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 col-lg-4">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3"> Membership fees by tier</h6>
                                <div class="col-3 p-4 text-center">
                                    <img src="{{ asset('images/dashboardIcon1.svg') }}" alt="Cancellations">
                                    <h2 class="mb-0 mt-3">
                                        $ 00
                                    </h2>
                                    <p class="pt-2">Explorer </p>
                                </div>

                            </div>
                        </div>
                    </div> -->
<div class="col-12 col-lg-4 ">
                        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
                            <div class="row flex-grow-1">
                                <h6 class="text-center pt-3"> Average Revenue Per Month</h6>
                                <div class="col-12 text-center p-4">
                                    <img src="{{ asset('images/dashboardIcon5.svg') }}" alt="Members referred to">
                                    <h2 class="mb-0 mt-3"> $ 00</h2>
                                    <p class="pt-2">Lorem, ipsum dolor. </p>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>




                <div class="row g-3 pt-3">
                    <div class="col-12">
                        <div class="">


                            <div id="chartdiv"></div>
                        </div>
                        <div class="map-dis p-4">
                            <ul>
                                <li>Oceania Region</li>
                                <li>Asia Region</li>
                                <li>Africa Region</li>
                                <li>Europe Region</li>
                                <li>Middle East Region</li>
                                <li>India Subcontinent Region</li>
                                <li>America Region</li>
                            </ul>
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
        // Wait for the page and scripts to be fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Data organized by regions
            var groupData = [
                {
                    "name": "Oceania Region",
                    "data": [
                        { "id": "AU", "name": "Oceania Region" },
                        { "id": "NZ",  "name": "Oceania Region" }
                    ]
                },
                {
                    "name": "Asia Region",
                    "data": [
                        { "id": "CN",  "name": "Asia Region" },
                        { "id": "PH", "name": "Asia Region" }
                    ]
                },
                {
                    "name": "Africa Region",
                    "data": [
                        { "id": "ZA", "name": "Africa Region" }
                    ]
                },
                {
                    "name": "Europe Region",
                    "data": [
                        { "id": "SE", "name": "Europe Region" },
                        { "id": "RU", "name": "Europe Region" }
                    ]
                },
                {
                    "name": "Middle East Region",
                    "data": [
                        { "id": "SA", "name": "Middle East Region" }
                    ]
                },
                {
                    "name": "India Subcontinent Region",
                    "data": [
                        { "id": "IN", "name": "India Subcontinent Region" }
                    ]
                },
                {
                    "name": "America Region",
                    "data": [
                        { "id": "US", "name": "America Region" }
                    ]
                }
            ];

            // Create root and chart
            var root = am5.Root.new("chartdiv");

            // Remove amCharts logo
            if (root._logo) {
                root._logo.dispose();
            }

            // Set themes
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Create chart
            var chart = root.container.children.push(am5map.MapChart.new(root, {
                panX: "none",
                panY: "none",
                wheelY: "zoomXY",
                homeZoomLevel: 1,
                homeGeoPoint: { longitude: 10, latitude: 40 }
            }));

            // Create world polygon series (background)
            var worldSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
                geoJSON: am5geodata_worldLow,
                exclude: ["AQ"]
            }));

            worldSeries.mapPolygons.template.setAll({
                fill: am5.color(0xdddddd),
                stroke: am5.color(0xffffff),
                strokeWidth: 1,
                interactive: false
            });

            // Define distinct colors for each region
            var regionColors = [
                am5.color(0xFF6F61), // Oceania - Coral
                am5.color(0x6B728E), // Asia - Slate
                am5.color(0xFFB347), // Africa - Orange
                am5.color(0x4A90E2), // Europe - Blue
                am5.color(0x8B008B), // Middle East - Purple
                am5.color(0x2ECC71), // India Subcontinent - Green
                am5.color(0xE74C3C)  // America - Red
            ];

            // Create series for each region
            am5.array.each(groupData, function (group, index) {
                var countries = [];
                var color = regionColors[index % regionColors.length]; // Assign unique color per region

                am5.array.each(group.data, function (country) {
                    countries.push(country.id);
                });

                var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
                    geoJSON: am5geodata_worldLow,
                    include: countries,
                    name: group.name
                }));

                polygonSeries.mapPolygons.template.setAll({
                    tooltipText: "{name}\nSales: [bold]USD {sales}M[/]",
                    interactive: true,
                    fill: color,
                    stroke: am5.color(0xFFFFFF),
                    strokeWidth: 1
                });

                // Hover state
                polygonSeries.mapPolygons.template.states.create("hover", {
                    fill: am5.Color.brighten(color, -0.3),
                    strokeWidth: 2
                });

                // Ensure tooltip shows on hover
                polygonSeries.mapPolygons.template.events.on("pointerover", function (ev) {
                    ev.target.showTooltip();
                    ev.target.series.mapPolygons.each(function (polygon) {
                        polygon.states.applyAnimate("hover");
                    });
                });

                polygonSeries.mapPolygons.template.events.on("pointerout", function (ev) {
                    ev.target.hideTooltip();
                    ev.target.series.mapPolygons.each(function (polygon) {
                        polygon.states.applyAnimate("default");
                    });
                });

                polygonSeries.data.setAll(group.data);
            });




        });
    </script>
@endsection