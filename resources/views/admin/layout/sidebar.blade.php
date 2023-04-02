<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Request::route()->getName() == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- End Dashboard --}}

                {{-- Users --}}
                <li class="nav-item {{ strpos(Request::route()->getName(), 'users') !== false ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ strpos(Request::route()->getName(), 'users') !== false ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('list.users') }}" class="nav-link {{ strpos(Request::route()->getName(), 'list.users') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('create.users') }}" class="nav-link {{ strpos(Request::route()->getName(), 'create.users') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Users --}}

                {{-- Blogs --}}
                <li class="nav-item {{ strpos(Request::route()->getName(), 'blogs') !== false ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ strpos(Request::route()->getName(), 'blogs') !== false ? 'active' : '' }}">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>
                            Blog
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('list.blogs') }}" class="nav-link {{ strpos(Request::route()->getName(), 'list.blogs') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Blog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('create.blogs') }}" class="nav-link {{ strpos(Request::route()->getName(), 'create.blogs') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Blog</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Blogs --}}

                {{-- Categories --}}
                <li class="nav-item {{ strpos(Request::route()->getName(), 'categories') !== false ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ strpos(Request::route()->getName(), 'categories') !== false ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Category
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('list.categories') }}" class="nav-link {{ strpos(Request::route()->getName(), 'list.categories') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('create.categories') }}" class="nav-link {{ strpos(Request::route()->getName(), 'create.categories') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Category</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Categories --}}

                {{-- Attributes --}}
                <li class="nav-item {{ strpos(Request::route()->getName(), 'attributeTypes') || strpos(Request::route()->getName(), 'attributeValues')  !== false ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ strpos(Request::route()->getName(), 'attributeTypes') || strpos(Request::route()->getName(), 'attributeValues') !== false ? 'active' : '' }}">
                        <i class="nav-icon fas fa-window-restore"></i>
                        <p>
                            Attribute
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('list.attributeTypes') }}" class="nav-link {{ strpos(Request::route()->getName(), 'list.attributeTypes') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Attribute Type </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('list.attributeValues') }}" class="nav-link {{ strpos(Request::route()->getName(), 'list.attributeValues') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Attribute Value</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Attributes --}}

                {{-- Products --}}
                <li class="nav-item {{ strpos(Request::route()->getName(), 'products') !== false ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ strpos(Request::route()->getName(), 'products') !== false ? 'active' : '' }}">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('list.products') }}" class="nav-link {{ strpos(Request::route()->getName(), 'list.products') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('create.products') }}" class="nav-link {{ strpos(Request::route()->getName(), 'create.products') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Products --}}
                {{-- Slider --}}
                <li class="nav-item {{ strpos(Request::route()->getName(), 'slider') !== false ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ strpos(Request::route()->getName(), 'slider') !== false ? 'active' : '' }}">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Slider
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('list.slider') }}" class="nav-link {{ strpos(Request::route()->getName(), 'list.slider') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Slider</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('create.slider') }}" class="nav-link {{ strpos(Request::route()->getName(), 'create.slider') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Slider</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Slider --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
