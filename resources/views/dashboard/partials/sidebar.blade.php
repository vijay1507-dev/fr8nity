 <aside id="sidebar" class="js-sidebar">
     <div class="h-100">
         <div class="sidebar-logo text-center">
             <a href="/"><img src="{{ asset('images/logo.svg') }}"> </a>
         </div>
         <ul class="sidebar-nav">
             <li class="sidebar-item">
                 <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                     <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                         <rect width="256" height="256" fill="none"></rect>
                         <rect x="48" y="48" width="64" height="64" rx="8" fill="none"
                             stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                         </rect>
                         <rect x="144" y="48" width="64" height="64" rx="8" fill="none"
                             stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                         </rect>
                         <rect x="48" y="144" width="64" height="64" rx="8" fill="none"
                             stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                         </rect>
                         <rect x="144" y="144" width="64" height="64" rx="8" fill="none"
                             stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                         </rect>
                     </svg>
                     Dashboard
                 </a>
             </li>
             @if(in_array(auth()->user()->role, [\App\Models\User::SUPER_ADMIN, \App\Models\User::ADMIN]))
             <li class="sidebar-item">
                 <a href="#" class="sidebar-link collapsed" data-bs-target="#auth" data-bs-toggle="collapse"
                     aria-expanded="{{ request()->routeIs('members.*') || request()->routeIs('admin.referrals.*') || request()->routeIs('admin.quotations.*') ? 'true' : 'false' }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                         fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                         <path
                             d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                     </svg>
                     Members
                 </a>
                 <ul id="auth" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('members.*') || request()->routeIs('admin.referrals.*') || request()->routeIs('admin.quotations.*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                     <li class="sidebar-item">
                         <a href="{{ route('members.index') }}" class="sidebar-link submenufont {{ request()->routeIs('members.*') ? 'active' : '' }}">FRT Members</a>
                     </li>
                    <li class="sidebar-item">
                        <a href="{{ route('admin.referrals.index') }}" class="sidebar-link submenufont {{ request()->routeIs('admin.referrals.*') ? 'active' : '' }}">
                            Referrals
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('admin.quotations.index') }}" class="sidebar-link submenufont {{ request()->routeIs('admin.quotations.*') ? 'active' : '' }}">
                            Quotations
                        </a>
                    </li>
                 </ul>
             </li>
             <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#trade-member" data-bs-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('trade-members.*') || request()->routeIs('shipments.*') ? 'true' : 'false' }}">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-briefcase" viewBox="0 0 16 16">
                    <path d="M6.5 0a.5.5 0 0 0-.5.5V2h-1A1.5 1.5 0 0 0 3.5 3.5V4H2a2 2 0 0 0-2 2v1h16V6a2 2 0 0 0-2-2h-1.5v-.5A1.5 1.5 0 0 0 9.5 2h-1V.5a.5.5 0 0 0-.5-.5h-1zM8 2h1.5v1H6.5V2H8zM0 8v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8H0z" />
                </svg>
                    Trade Members
                </a>
                <ul id="trade-member" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('trade-members.*') || request()->routeIs('shipments.*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                    <li class="sidebar-item ">
                       <a href="{{ route('trade-members.index') }}" class="sidebar-link submenufont {{ request()->routeIs('trade-members.*') ? 'active' : '' }}">Member Enquiry</a>
                   </li>
                   <li class="sidebar-item">
                        <a href="{{ route('shipments.index') }}" class="sidebar-link submenufont {{ request()->routeIs('shipments.*') ? 'active' : '' }}">Shipment Enquiry</a>
                    </li>
                </ul>
            </li>
             <li class="sidebar-item">
                 <a href="#" class="sidebar-link collapsed" data-bs-target="#settings" data-bs-toggle="collapse"
                     aria-expanded="{{ request()->routeIs('settings.*') || request()->routeIs('security.settings') || request()->routeIs('membership-tiers.*') ? 'true' : 'false' }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                         fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
                         <path fill-rule="evenodd"
                             d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z" />
                     </svg>
                     Settings
                 </a>
                 <ul id="settings" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('settings.*') || request()->routeIs('security.settings') || request()->routeIs('membership-tiers.*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('security.settings') }}" class="sidebar-link {{ request()->routeIs('security.settings') ? 'active' : '' }}">
                            <p class="m-0 submenufont">2FA Settings</p>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                            <p class="m-0 submenufont">Membership Reminders</p>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('settings.site.index') }}" class="sidebar-link {{ request()->routeIs('settings.site.*') ? 'active' : '' }}">
                            <p class="m-0 submenufont">Site Settings</p>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('membership-tiers.index') }}" class="sidebar-link {{ request()->routeIs('membership-tiers.*') ? 'active' : '' }}">
                            <p class="m-0 submenufont">Membership Tiers</p>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('settings.email-templates.index') }}" class="sidebar-link {{ request()->routeIs('settings.email-templates.*') ? 'active' : '' }}">
                            <p class="m-0 submenufont">Email Templates</p>
                        </a>
                    </li>
                </ul>
            </li>
             <!-- Spotlight Management -->
             <li class="sidebar-item">
                 <a href="#" class="sidebar-link collapsed" data-bs-target="#spotlight" data-bs-toggle="collapse"
                     aria-expanded="{{ request()->routeIs('admin.event-pulse.*') || request()->routeIs('admin.partner-showcase.*') ? 'true' : 'false' }}">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                         <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.576-2.906 2.77a.56.56 0 0 0-.163.505l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                     </svg>
                     Spotlight
                 </a>
                 <ul id="spotlight" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('admin.event-pulse.*') || request()->routeIs('admin.partner-showcase.*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('admin.event-pulse.index') }}" class="sidebar-link {{ request()->routeIs('admin.event-pulse.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p class="m-0 submenufont">Event Pulse</p>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('admin.partner-showcase.index') }}" class="sidebar-link {{ request()->routeIs('admin.partner-showcase.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p class="m-0 submenufont">Partner Showcase</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
           
           <li class="sidebar-item">
                <a href="{{ route('members.directory') }}" class="sidebar-link {{ request()->routeIs('members.directory*') ? 'active' : '' }}">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                         <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7.03 7.03 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7.03 7.03 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.03 7.03 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
                     </svg>
                    Member Directory
                </a>
            </li>
            @if(auth()->user()->role == \App\Models\User::MEMBER)
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#quotations" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('member.quotations.*') ? 'true' : 'false' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-quote" viewBox="0 0 16 16">
                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                        <path d="M7.066 6.76A1.665 1.665 0 0 0 4 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/>
                    </svg>
                    Quotations
                </a>
                <ul id="quotations" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('member.quotations.*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('member.quotations.given') }}" class="sidebar-link submenufont {{ request()->routeIs('member.quotations.given*') ? 'active' : '' }}">Given Quotations</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('member.quotations.received') }}" class="sidebar-link submenufont {{ request()->routeIs('member.quotations.received*') ? 'active' : '' }}">Received Quotations</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('referrals.index') }}" class="sidebar-link {{ request()->routeIs('referrals.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                        <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
                    </svg>
                    My Referrals
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                     <i class="bi bi-calendar-event"></i>
                    Event Calendar
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                     <i class="bi bi-people"></i>
                    Conference
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                     <i class="bi bi-camera-video"></i>
                    Online Meeting Room
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                     <i class="bi bi-calendar-check"></i>
                    Meeting Scheduler
                </a>
            </li>
            @endif
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#sales-report" data-bs-toggle="collapse"
                    aria-expanded="{{ request()->routeIs('sales-report.*') || request()->routeIs('member.sales-report.*') ? 'true' : 'false' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
                    </svg>
                    Report
                </a>
                <ul id="sales-report" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('sales-report.*') || request()->routeIs('member.sales-report.*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                    @if(auth()->user()->role == \App\Models\User::SUPER_ADMIN)
                        <li class="sidebar-item">
                            <a href="{{ route('sales-report.index') }}" class="sidebar-link submenufont {{ request()->routeIs('sales-report.*') ? 'active' : '' }}">Giver & Receiver Report</a>
                        </li>
                        @else
                        <li class="sidebar-item">
                            <a href="{{ route('member.sales-report.index') }}" class="sidebar-link submenufont {{ request()->routeIs('member.sales-report.*') ? 'active' : '' }}">Generate Report</a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') || request()->routeIs('editprofile') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    My Profile
                </a>
            </li>
             <li class="sidebar-item">
                 <form method="POST" action="{{ route('logout') }}" id="logout-form">
                     @csrf
                     <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                             <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                             <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                         </svg>
                         Logout
                     </a>
                 </form>
             </li>
         </ul>
     </div>
 </aside>
