  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        @php
        function setActive($path)
        {
         return Request::is($path. '*' ) ? ' active' :  '';
        }
        @endphp

        @foreach($menus as $index=>$menu)
          
          @if(isset($menu['subs']))  
            <li class="treeview {{ setActive($menu['path']) }}">
              <a href="#">
                <i class="fa {{ $menu['fa'] }}"></i> <span>{{ $menu['name'] }}</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
              </a>
              <ul class="treeview-menu">
                @foreach($menu['subs'] as $submenu)
                <li class="{{ setActive($submenu['path']) }}">
                  <a href="{{ route($submenu['permission']) }}"><i class="fa fa-circle-o"></i> {{ $submenu['name'] }}</a>
                </li>
                @endforeach
              </ul>
            </li>
          @else
            <li class="{{ setActive($menu['path']) }}">
              <a href="{{ route($menu['permission']) }}"><i class="fa {{ $menu['fa'] }}"></i> <span>{{ $menu['name'] }}</span></a>
            </li>
          @endif

        @endforeach          

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>