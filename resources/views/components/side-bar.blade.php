<aside class="app-sidebar bg-white shadow" data-bs-theme="light">
    <div class="sidebar-brand">
        <a class='brand-link' href='/'>
            <img src="{{ asset('storage') }}/images/logo.svg" width="200"/>
        </a>
    </div>
    {{-- @dd(auth()->user()->isAdmin()) --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @foreach ($controllers as $controller)
                
                @php
                    $isActive = str_contains($currentRouteName, $controller::$base_route);    
                @endphp    
                
                    <li class="nav-item {{ $isActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon {{ $controller::$menu_icon }}"></i>
                            <p>{{ __($controller::$menu_label) }}
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        @if($controller::$actions)
                        <ul class="nav nav-treeview" style="box-sizing: border-box">
                            @foreach ($controller::$actions as $actionkey => $action)
                                @php
                                $isActionActive = $currentRouteName === $controller::$base_route . '.' . $action['route'];

                                //dd($currentRouteName);
                                @endphp
                                
                                {{-- @dd($action['route']) --}}
                                @if (Route::has($action['route']))
                                
                                <li class="nav-item">
                                    <a class="nav-link {{ $isActionActive ? 'active' : '' }}"
                                        href="{{ route($action['route']) }}">
                                        <i class="nav-icon {{ $action['icon'] }}"></i>
                                        <p>{{ __($action['label']) }}</p>
                                    </a>
                                </li>
                                @else
                                    @dd($action['route'])
                                @endif
                            @endforeach
                        </ul>
                        @endif
                    </li>                
                @endforeach
                

            </ul>
        </nav>
    </div>
</aside>
