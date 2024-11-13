<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'dashboard') active @endif" aria-current="page" href="{{route('dashboard')}}">
                    <span data-feather="home"></span>
                    Главная
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'prizes.index') active @endif" href="{{route('prizes.index')}}">
                    <span data-feather="gift"></span>
                    Призы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->route()->getName() == 'clients.index') active @endif" href="{{route('clients.index')}}">
                    <span data-feather="users"></span>
                    Пользователи
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="document.getElementById('logout').submit()" href="#">
                    <span data-feather="layers"></span>
                    Выйти
                </a>
            </li>
        </ul>
    </div>
</nav>

<form action="{{route('logout')}}" id="logout" method="post">
    @csrf
</form>
