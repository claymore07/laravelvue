<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="nav-icon false">
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

        <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs green"></i>
                <p>
                    مدیریت رزومه
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/papers" class="nav-link ">
                        <i class="nav-icon fal fa-pencil-ruler nav-icon green"></i>
                        <p>مقالات</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/books" class="nav-link ">
                        <i class="nav-icon fal fa-books nav-icon green"></i>
                        <p>کتب</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/rewards" class="nav-link ">
                        <i class="nav-icon fal fa-award nav-icon green"></i>
                        <p>جوایز</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/projects" class="nav-link ">
                        <i class="nav-icon fal fa-project-diagram nav-icon green"></i>
                        <p>طرحی های پژوهشی و فناوری</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/teds" class="nav-link ">
                        <i class="nav-icon fal fa-lightbulb-on nav-icon green"></i>
                        <p>کرسی های نظریه پردازی</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/thesis" class="nav-link ">
                        <i class="nav-icon fal fa-book nav-icon green"></i>
                        <p>پایان نامه ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/referees" class="nav-link ">
                        <i class="nav-icon fal fa-gavel nav-icon green"></i>
                        <p>داوری و نظارت بر طرح ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-microscope nav-icon green"></i>
                        <p>اختراعات و اکتشافات</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/courses" class="nav-link ">
                        <i class="nav-icon fal fa-users-class nav-icon green"></i>
                        <p>دوره ها</p>
                    </router-link>
                </li>
            </ul>
        </li>


        <li v-if="type == 'admin'" class="nav-item has-treeview ">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-server blue"></i>
                <p>
                    مدیریت سیستم
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/users" class="nav-link ">
                        <i class="nav-icon fal fa-users nav-icon blue"></i>
                        <p>کاربران</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/faculties" class="nav-link ">
                        <i class="nav-icon fal fa-university blue"></i>
                        <p>دانشکده ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/departments" class="nav-link ">
                        <i class="nav-icon fal fa-building blue"></i>
                        <p>گروه های آموزشی</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/score" class="nav-link ">
                        <i class="nav-icon fal fa-star blue"></i>
                        <p>مدیریت امتیازها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/term" class="nav-link ">
                        <i class="nav-icon fal fa-calendar-edit blue"></i>
                        <p>مدیریت ترم ها</p>
                    </router-link>
                </li>

            </ul>
        </li>

        <li v-if="type == 'admin'"  class="nav-item has-treeview ">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-newspaper orange"></i>
                <p>
                    گزارشات سامانه
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-pencil-ruler nav-icon orange"></i>
                        <p>گزارش مقالات</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-books orange"></i>
                        <p>گزارش کتب</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-award orange"></i>
                        <p>گزارش جوایز</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-book-reader orange"></i>
                        <p>گزارش پایان نامه ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-users-class orange"></i>
                        <p>گزارش دوره</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-university orange"></i>
                        <p>گزارش دانشکده ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-building orange"></i>
                        <p>گزارش گروه های آموزشی</p>
                    </router-link>
                </li>

            </ul>
        </li>

        <li class="nav-item ">
            <router-link to="/profile" class="nav-link ">
                <i class="nav-icon fas fa-id-card cyan"></i>
                <p>
                    پروفایل
                    <!-- <i class="right fa fa-angle-left"></i>-->
                </p>

            </router-link>

        </li>

        <li v-if="type == 'admin'"  class="nav-item">
            <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs yellow"></i>
                <p>
                    توسعه دهنده
                    <!--<span class="right badge badge-danger">New</span>-->
                </p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/logout"  class="nav-link ">

                <i class="nav-icon fas fa-sign-out red"></i>
                <p>
               خروج
                </p>
            </>
        </li>
    </ul>
</nav>
