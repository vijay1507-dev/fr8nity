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
                        <button type="button" class="monthbtn p-2 px-3 ms-2">Last 3 months</button>
                        <button type="button" class="monthbtn p-2 px-3 ms-2">Last 6 months</button>
                        <button type="button" class="monthbtn p-2 px-3 ms-2 active">Last 1 year</button>
                    </div>
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
                <div class="">
                    <h6 class="fw-semibold mb-0 mt-4">Strategic Growth Metrics</h6>
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

            var membersData = {
                "IN": 1200, "US": 540, "BR": 300,
                "CN": 800, "FR": 150, "DE": 220,
                "GB": 400, "PK": 600, "RU": 250
            };

            // Default polygon settings
            worldSeries.mapPolygons.template.setAll({
                interactive: true,
                stroke: am5.color(0xffffff),
                strokeWidth: 1,
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

            // Add members data
            worldSeries.events.on("datavalidated", function () {
                worldSeries.mapPolygons.each(function (polygon) {
                    var id = polygon.dataItem.dataContext.id;
                    polygon.dataItem.dataContext.members = membersData[id] || 0;
                    polygon.dataItem.set("value", polygon.dataItem.dataContext.members);
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
                window.location.href = "/country/" + countryId;
            });
        });
    </script>
@endsection