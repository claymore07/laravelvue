<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                <p>
                    داشبورد
                    <!--<span class="right badge badge-danger">New</span>-->
                </p>
            </router-link>
        </li>
        @can('isAdmin')
        <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs green"></i>
                <p>
                    مدیریت
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/users" class="nav-link ">
                        <i class="fas fa-users nav-icon indigo"></i>
                        <p>کاربران</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/papers" class="nav-link ">
                        <i class="fas fa-pencil-ruler nav-icon purple"></i>
                        <p>مقالات</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>Inactive Page</p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan
        <li class="nav-item ">
            <router-link to="/profile" class="nav-link ">
                <i class="nav-icon fas fa-user orange"></i>
                <p>
                    پروفایل
                    <!-- <i class="right fa fa-angle-left"></i>-->
                </p>

            </router-link>
           <!-- <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>Active Page</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>Inactive Page</p>
                    </a>
                </li>
            </ul>-->
        </li>
        @can('isAdmin')
        <li class="nav-item">
            <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs yellow"></i>
                <p>
                    توسعه دهنده
                    <!--<span class="right badge badge-danger">New</span>-->
                </p>
            </router-link>
        </li>
        @endcan
        <li class="nav-item">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav-link">

                <i class="nav-icon fas fa-sign-out red"></i>
                <p>
                {{ __('خروج') }}
                <!--<span class="right badge badge-danger">New</span>-->
                </p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </a>
        </li>
    </ul>
</nav>
