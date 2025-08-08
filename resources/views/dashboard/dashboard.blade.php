@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
  <main class="content px-3 py-4">
    @if (in_array(auth()->user()->role, [\App\Models\User::SUPER_ADMIN, \App\Models\User::ADMIN]))
    <div class="container-fluid">
    <div class="mb-3">
      <h4 class="">Welcome Back,  </h4>
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
        <div class="mb-4"> <span class="avatar avatar-md bg-primary svg-white avatar-rounded"> <svg
          xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
          <rect width="256" height="256" fill="none"></rect>
          <rect x="32" y="48" width="192" height="160" rx="8" fill="none" stroke="currentColor"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></rect>
          <path d="M168,88a40,40,0,0,1-80,0" fill="none" stroke="currentColor" stroke-linecap="round"
          stroke-linejoin="round" stroke-width="16">
          </path>
        </svg> </span> </div>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-between"> <a href="javascript:void(0);"
        class="text-muted text-decoration-underline fw-medium fs-13">View all
        sales</a> <span class="text-success"><i class="ti ti-arrow-narrow-up"></i>0.29%</span> </div>
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
        <div class="mb-4"> <span class="avatar avatar-md bg-secondary svg-white avatar-rounded"> <svg
          xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
          <rect width="256" height="256" fill="none"></rect>
          <line x1="128" y1="24" x2="128" y2="232" fill="none" stroke="currentColor" stroke-linecap="round"
          stroke-linejoin="round" stroke-width="16"></line>
          <path d="M184,88a40,40,0,0,0-40-40H112a40,40,0,0,0,0,80h40a40,40,0,0,1,0,80H104a40,40,0,0,1-40-40"
          fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
          stroke-width="16"></path>
        </svg> </span> </div>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-between"> <a href="javascript:void(0);"
        class="text-muted text-decoration-underline fw-medium fs-13">complete
        revenue</a> <span class="text-success"><i class="ti ti-arrow-narrow-up"></i>3.45%</span> </div>
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
        <div class="mb-4"> <span class="avatar avatar-md bg-success svg-white avatar-rounded"> <svg
          xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
          <rect width="256" height="256" fill="none"></rect>
          <circle cx="84" cy="108" r="52" fill="none" stroke="currentColor" stroke-linecap="round"
          stroke-linejoin="round" stroke-width="16"></circle>
          <path d="M10.23,200a88,88,0,0,1,147.54,0" fill="none" stroke="currentColor" stroke-linecap="round"
          stroke-linejoin="round" stroke-width="16"></path>
          <path d="M172,160a87.93,87.93,0,0,1,73.77,40" fill="none" stroke="currentColor"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
          <path d="M152.69,59.7A52,52,0,1,1,172,160" fill="none" stroke="currentColor"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
        </svg> </span> </div>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-between"> <a href="javascript:void(0);"
        class="text-muted text-decoration-underline fw-medium fs-13">Total
        page views</a> <span class="text-success"><i class="ti ti-arrow-narrow-up"></i>11.54%</span>
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
        <div class="mb-4"> <span class="avatar avatar-md bg-info svg-white avatar-rounded"> <svg
          xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
          <rect width="256" height="256" fill="none"></rect>
          <path
          d="M40,56V184a16,16,0,0,0,16,16H216a8,8,0,0,0,8-8V80a8,8,0,0,0-8-8H56A16,16,0,0,1,40,56h0A16,16,0,0,1,56,40H192"
          fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
          stroke-width="16"></path>
          <circle cx="180" cy="132" r="12"></circle>
        </svg> </span> </div>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-between"> <a href="javascript:void(0);"
        class="text-muted text-decoration-underline fw-medium fs-13">Total
        profit earned</a> <span class="text-success"><i class="ti ti-arrow-narrow-up"></i>0.18%</span>
      </div>
      </div>
      </div>
      </div>
    </div>
    </div>
    @else
  <!-- memder dashboard -->
    <div class="dashboard-header d-flex justify-content-between">
      <div>   <h5>Welcome Back Emma</h5></div>
 
@php
      $startAt = Auth::user()->membership_start_at;
      $expiresAt = Auth::user()->membership_expires_at;
    @endphp
<div class="d-flex membership align-items-center justify-content-center bg-white px-3 ">
  @if($startAt && $expiresAt)
  <h6 class="fw-semibold mb-0">Membership Period : </h6><span class="fs-6 "> {{ optional($startAt)->format('j/n/Y') ?? 'N/A' }}
      TO
      {{ optional($expiresAt)->format('j/n/Y') ?? 'N/A' }}</span></div>
       @else
      <h6 class="fw-semibold mb-0">Membership Period : </h6>><span class="fs-6"> N/A</span>
    @endif
    </div>

 
    <div class="container rounded  bg-white ">
    <div class="row mt-3 pt-4 pb-2">
      <div class="d-flex justify-content-between">
    <div class="d-flex gap-2">
<div class="d-flex membership align-items-center justify-content-center px-3 py-1 ">
  <h6 class="fw-semibold mb-0">Accumulated Points to Date:</h6><span class="fs-6">1234567890</span>
</div>
<div class="d-flex membership align-items-center justify-content-center px-3 py-1">
  <h6 class="fw-semibold mb-0">Redeemped Points:</h6><span class="fs-6">1234567890</span>
</div>
    </div>
    <div>    
      <button type="button" class="monthbtn  p-2 px-3 ms-2">Last 6 months</button>
   <button type="button" class="monthbtn p-2  ms-2 px-3 active"> Last 1 year</button>
    <button type="button" class="monthbtn p-2 ms-2 px-3 ">Lifetime</button>
      <button type="button" class="tooltip-btn p-1 ms-2 " data-bs-toggle="tooltip" data-bs-placement="top"
      data-bs-title="Tooltip on top">!</button>
  </div>
  </div>   
    </div>

    <div class="row g-3 pt-3">
      <!-- Card 1 -->
      <div class="col-12 col-lg-4">
        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
          <div class="row flex-grow-1">
            <div class="col-6 p-4">
              <img src="{{asset('images/dashboardIcon1.svg')}}" alt="ransaction Value Give">
              <h2 class="mb-0 mt-3">$11,123</h2>
              <p class="pt-2">Transaction Value Give</p>
            </div>
            <div class="col-6 p-3 py-4  border-l">
            <img src="{{asset('images/dashboardIcon2.svg')}}" alt="Enquiries Given (Freight Member)">
              <h2 class="mb-0 mt-3">$11,123</h2>
              <p class="pt-2">Enquiries Given (Freight Member)</p>
            </div>
          </div>
          <div class="text-center pb-3">
            <button class="view-btn   ">View</button>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-12 col-lg-4">
        <div class="dashboard-card  p-0 h-100 d-flex flex-column">
          <div class="row flex-grow-1">
            <div class="col-6 p-4">
           <img src="{{asset('images/dashboardIcon3.svg')}}" alt="Transaction Value Received">
              <h2 class="mb-0 mt-3">$11,123</h2>
              <p class="pt-2">Transaction Value Received</p>
            </div>
            <div class="col-6 p-3 py-4 border-l">
            <img src="{{asset('images/dashboardIcon4.svg')}}" alt="Enquiries Given (Freight Member)">
              <h2 class="mb-0 mt-3">11</h2>
              <p class="pt-2">Enquiries Given (Freight Member)</p>
            </div>
          </div>
          <div class="text-center pb-3">
            <button class="view-btn ">View</button>
          </div>
        </div>
      </div>
<div class="col-12 col-lg-2 ">
     <div class="dashboard-card  p-0 h-100 d-flex flex-column">
          <div class="row flex-grow-1">
            <div class="col-12 p-4">
         <img src="{{asset('images/dashboardIcon5.svg')}}" alt="Members referred to">
              <h2 class="mb-0 mt-3">11</h2>
              <p class="pt-2">Members referred to</p>
            </div>
       
          </div>
          <div class="text-center pb-3">
            <button class="view-btn ">View</button>
          </div>
        </div>
</div>

<div class="col-12 col-lg-2 ">
     <div class="dashboard-card  p-0 h-100 d-flex flex-column">
          <div class="row flex-grow-1">
            <div class="col-12 p-4">
              <img src="{{asset('images/dashboardIcon6.svg')}}" alt="Events attended till date">
              <h2 class="mb-0 mt-3">11</h2>
              <p class="pt-2">Events attended till date</p>
            </div>
       
          </div>
          <div class="text-center pb-3">
            <button class="view-btn  ">View</button>
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
          <div> <img src="{{asset('images/graphicondashboard.svg')}}" alt="Membership Leadership Board"></div>
             
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
        <div> <img src="{{asset('images/graphicondashboard.svg')}}" alt="Membership Leadership Board"></div>   
        </div>
          <div class="chart-wrapper">
            <canvas id="tradeChart"></canvas>
          </div>
        </div>
      </div>
    </div>



    </div>

    

    
</div>


     <!-- <div class="container ">
      <div class="row d-flex ">
      <div class="col-12 col-lg-6 ">
      <div class="bg-white p-3 rounded_10 shadow-sm">
      <h6>Membership Leadership Board</h6>
      <canvas id="membershipChart1"></canvas>
      </div>
      </div>
      <div class="col-12 col-lg-6 ">

      <div class="bg-white p-3 rounded_10 shadow-sm">
      <h6>Trade surplus/deficit </h6>
      <canvas id="membershipChart2"></canvas>
      </div>

      </div>
      </div>
    </div>  -->

  @endif
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
      legend: { display: false }
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
    document.addEventListener('DOMContentLoaded', function () {
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
          legend: { display: false },
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
        datasets: [
          {
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
          legend: { display: false }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#000' }
          },
          y: {
            beginAtZero: true,
            ticks: { stepSize: 10, color: '#000' },
            grid: { color: '#eee' }
          }
        }
      }
    });
  </script>

@endsection