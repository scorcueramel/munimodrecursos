<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/home')}}">
        <i class="fas fa-tachometer-alt"></i><span>General</span>
    </a>
</li>
@can('VER-USUARIOS')
<li class="side-menus {{ Request::is('usuarios') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/usuarios')}}">
        <i class="fas fa-users"></i><span>Usuarios</span>
    </a>
</li>
@endcan
@can('VER-ROLES')
<li class="side-menus {{ Request::is('roles') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/roles')}}">
        <i class="fas fa-cogs"></i><span>Roles</span>
    </a>
</li>
@endcan
@can('VER-VACACIONES')
<li class="side-menus {{ Request::is('vacaciones') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/vacaciones')}}">
        <i class="fas fa-swimmer"></i><span>Vacaciones</span>
    </a>
</li>
@endcan
@can('VER-DESCANSOS-MEDICOS')
<li class="side-menus {{ Request::is('descansosmedicos') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/descansosmedicos')}}">
        <i class="fas fa-user-injured"></i><span>Descansos Médicos</span>
    </a>
</li>
@endcan
@can('VER-LICENCIAS')
<li class="side-menus {{ Request::is('licencias') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/licencias')}}">
        <i class="fas fa-id-badge"></i><span>Licencias</span>
    </a>
</li>
@endcan
@can('VER-AISLAMIENTOS')
<li class="side-menus {{ Request::is('aislamientos') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('aislamientos')}}">
        <i class="fas fa-house-user"></i><span>Aislamientos</span>
    </a>
</li>
@endcan
@can('VER-SUSPENSIONES')
<li class="side-menus {{ Request::is('suspensiones') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('suspensiones')}}">
        <i class="fas fa-user-slash"></i><span>Suspensiones</span>
    </a>
</li>
@endcan
{{--
@can('VER-MARCADORES')
<li class="side-menus {{ Request::is('marcadores') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('marcadores')}}">
        <i class="fas fa-clock"></i><span>Marcadores</span>
    </a>
</li>
@endcan
--}}
