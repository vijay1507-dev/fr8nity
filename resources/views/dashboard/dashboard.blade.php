@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
     <main class="content px-3 py-4">
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
                      <div class="mb-4"> <span class="avatar avatar-md bg-primary svg-white avatar-rounded"> <svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none"></rect>
                            <rect x="32" y="48" width="192" height="160" rx="8" fill="none" stroke="currentColor"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></rect>
                            <path d="M168,88a40,40,0,0,1-80,0" fill="none" stroke="currentColor" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="16"></path>
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
                            <line x1="128" y1="24" x2="128" y2="232" fill="none" stroke="currentColor"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                            <path
                              d="M184,88a40,40,0,0,0-40-40H112a40,40,0,0,0,0,80h40a40,40,0,0,1,0,80H104a40,40,0,0,1-40-40"
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
                            <path d="M10.23,200a88,88,0,0,1,147.54,0" fill="none" stroke="currentColor"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
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
      </main>
@endsection
