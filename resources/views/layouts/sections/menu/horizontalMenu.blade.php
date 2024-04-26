@php
$configData = Helper::appClasses();
@endphp
<!-- Horizontal Menu -->
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
  <div class="{{$containerNav}} d-flex h-100">
    <ul class="menu-inner">
      @if (Auth::guard('web')->check())
        @foreach ($menuData[1]->menu_user as $menu)
          @php
            $activeClass = null;
            $currentRouteName =  Route::currentRouteName();

            if ($currentRouteName === $menu->slug) {
                $activeClass = 'active';
            }
            elseif (isset($menu->submenu)) {
              if (gettype($menu->slug) === 'array') {
                foreach($menu->slug as $slug){
                  if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
                    $activeClass = 'active';
                  }
                }
              }
              else{
                if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
                  $activeClass = 'active';
                }
              }

            }
          @endphp

          {{-- main menu --}}
          <li class="menu-item {{$activeClass}}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
              <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
            </a>

            {{-- submenu --}}
            @isset($menu->submenu)
              @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
            @endisset
          </li>
        @endforeach
      @elseif(Auth::guard('admin')->check())
        @foreach ($menuData[1]->menu as $menu)
          @php
            $activeClass = null;
            $currentRouteName =  Route::currentRouteName();

            if ($currentRouteName === $menu->slug) {
                $activeClass = 'active';
            }
            elseif (isset($menu->submenu)) {
              if (gettype($menu->slug) === 'array') {
                foreach($menu->slug as $slug){
                  if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
                    $activeClass = 'active';
                  }
                }
              }
              else{
                if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
                  $activeClass = 'active';
                }
              }

            }
          @endphp

          {{-- main menu --}}
          <li class="menu-item {{$activeClass}}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
              <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
            </a>

            {{-- submenu --}}
            @isset($menu->submenu)
              @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
            @endisset
          </li>
        @endforeach
      @else
        @foreach ($menuData[1]->menu_company as $menu)
          @php
            $activeClass = null;
            $currentRouteName =  Route::currentRouteName();

            if ($currentRouteName === $menu->slug) {
                $activeClass = 'active';
            }
            elseif (isset($menu->submenu)) {
              if (gettype($menu->slug) === 'array') {
                foreach($menu->slug as $slug){
                  if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
                    $activeClass = 'active';
                  }
                }
              }
              else{
                if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
                  $activeClass = 'active';
                }
              }

            }
          @endphp

          {{-- main menu --}}
          <li class="menu-item {{$activeClass}}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
              <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
            </a>

            {{-- submenu --}}
            @isset($menu->submenu)
              @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
            @endisset
          </li>
        @endforeach
      @endif
    </ul>
  </div>
</aside>
<!--/ Horizontal Menu -->
