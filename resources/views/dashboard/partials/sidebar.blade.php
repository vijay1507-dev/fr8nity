 <aside id="sidebar" class="js-sidebar">
     <div class="h-100">
         <div class="sidebar-logo text-center">
             <a href="/"><img src="{{ asset('images/logo.svg') }}"> </a>
         </div>
         <ul class="sidebar-nav">
             <li class="sidebar-item">
                 <a href="{{ route('dashboard') }}" class="sidebar-link">
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
         </ul>
     </div>
 </aside>
