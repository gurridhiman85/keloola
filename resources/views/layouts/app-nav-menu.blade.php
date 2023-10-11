<nav class="bottom-navbar border-bottom">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            @if(Auth::user()->user_type == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products') }}">
                        <i class="icon-social-soundcloud menu-icon"></i>
                        <span class="menu-title">Products</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('topfeatures') }}">
                        <i class="icon-social-soundcloud menu-icon"></i>
                        <span class="menu-title">Top Features</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('hardware_integration') }}">
                        <i class="icon-user menu-icon"></i>
                        <span class="menu-title">Hardware Integration</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pricing') }}">
                        <i class="icon-social-soundcloud menu-icon"></i>
                        <span class="menu-title">Pricing</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news_videos') }}">
                        <i class="icon-social-soundcloud menu-icon"></i>
                        <span class="menu-title">News & videos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('server_status') }}">
                        <i class="icon-user menu-icon"></i>
                        <span class="menu-title">Server Status</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('knowledge_base') }}">
                        <i class="icon-user menu-icon"></i>
                        <span class="menu-title">Knowledge Base</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="">
                        <i class="icon-user menu-icon"></i>
                        <span class="menu-title">Affliate</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users') }}">
                        <i class="icon-user menu-icon"></i>
                        <span class="menu-title">Users</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
