 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     @php
         $urls = [];
         $urls[] = Request::segment(2);
         $urls[] = Request::segment(3);
         $url = array_filter($urls);
         $user = Auth::user()->id;
     @endphp

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link
            {{-- Active Tab Class --}}
            {{ in_array('dashboard', $url) ? 'active-tab' : '' }}"
                 href="{{ route('dashboard') }}">
                 <i
                     class="bi bi-grid
                {{-- Icon Tab Class --}}
                {{ in_array('dashboard', $url) ? 'icon-tab' : '' }}"></i>
                 <span>{{ __('Dashboard') }}</span>
             </a>
         </li>

         <li class="nav-item">
            <a href="{{ route('articles.index') }}"
                class="nav-link  {{ strpos(Route::currentRouteName(), 'articles.index') !== false ? 'active-link' : '' }}">
                <i
                    class="{{ strpos(Route::currentRouteName(), 'articles.index') !== false ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Articles</span>
            </a>
        </li>

         {{-- User Tab --}}
         @if ($user)
             <li class="nav-item">
                 <a class="nav-link {{ strpos(Route::currentRouteName(), 'users') !== false ? 'active-tab' : 'collapsed' }}"
                     data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"
                     aria-expanded="{{ strpos(Route::currentRouteName(), 'users') !== false ? 'true' : 'false' }}">
                     <i class="fa-solid fa-users icon-tab"></i><span>Users</span><i
                         class="bi bi-chevron-down ms-auto icon-tab"></i>
                 </a>

                 <ul id="users-nav"
                     class="nav-content sidebar-ul collapse {{ strpos(Route::currentRouteName(), 'users') !== false ? 'show' : '' }}"
                     data-bs-parent="#sidebar-nav">
                     @if ($user)
                         <li>
                             <a href="{{ route('users') }}"
                                 class="{{ strpos(Route::currentRouteName(), 'users') !== false ? 'active-link' : '' }}">
                                 <i
                                     class="{{ strpos(Route::currentRouteName(), 'users') !== false ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Users</span>
                             </a>
                         </li>
                     @endif
                 </ul>
             </li>
         @endif




     </ul>

 </aside>
 <!-- End Sidebar-->
