<div class="search container">
    <form>
        <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
    </form>
    <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
</div>
<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg container">
        <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
                <div class="logo">
                    <a href="{{ url('home') }}">CUB UNGASAN</a>
                </div>

            </div>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">last_page</i></a>
                    </li>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link active" href="{{ url('/home') }}">Beranda</a>
                    </li>
                    @guest
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link" href="{{ route('getLoginUser') }}">Masuk</a>
                    </li>
                    @endguest

                    @auth
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown">{{ auth()->user()->nama }} <i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
                            <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                                <li><a class="dropdown-item" href="{{ route('profil.index') }}">Profil</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        {{ __('Logout') }}
                                    </a>
    
                                </li>
                            </ul>
                    </li> 
                    @endauth
                   
                   
                </ul>
            </div>
        </div>
    </nav>
</div>