<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{  route('pages.index')  }}">{{  config('app.name', 'Blog')  }}</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="nat-item {{  Request::is('/') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{  route('pages.index')  }}">Home</a>
                </li>
                <li class="nat-item {{  Request::is('about') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{  route('pages.about')  }}">About</a>
                </li>
                <li class="nat-item {{  Request::is('posts*') && !Request::is('posts/create') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{  route('posts.index')  }}">Posts</a>
                </li>
                <li class="nat-item {{  Request::is('contact') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{  route('pages.contact')  }}">Contact</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item {{  Request::is('login') ? 'active' : ''  }}">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item {{  Request::is('register') ? 'active' : ''  }}">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item {{  Request::is('posts/create') ? 'active' : ''  }}">
                        <a href="{{  route('posts.create')  }}">Create Post</a>
                    </li>

                    <li class="nav-link {{  Request::is('dashboard') ? 'active' : ''  }}">
                        <a href="{{  route('pages.dashboard')  }}">Dashboard</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <li>
                                <a href="{{  route('posts.create')  }}">Create Post</a>
                            </li>
                            <li>
                                <a href="{{  route('pages.dashboard')  }}">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{  route('categories.index')  }}">Categories</a>
                            </li>
                            <li>
                                <a href="{{  route('tags.index')  }}">Tags</a>
                            </li>
                            <li>
                                <a href="{{  route('profiles.index')  }}">Profile</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>

                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
