<nav class="mt-2">
    <ul style="overflow:auto;" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="nav-icon false">
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
                    مدیریت رزومه پژوهشی
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/papers" class="nav-link ">
                        <i class="nav-icon fal fa-pencil-ruler nav-icon  "></i>
                        <p>مقالات</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/books" class="nav-link ">
                        <i class="nav-icon fal fa-books nav-icon  "></i>
                        <p>کتب</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/rewards" class="nav-link ">
                        <i class="nav-icon fal fa-award nav-icon  "></i>
                        <p>جوایز</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/grants" class="nav-link ">
                        <i class="nav-icon fal fa-dollar-sign nav-icon  "></i>
                        <p>گرنت جذب شده</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/projects" class="nav-link ">
                        <i class="nav-icon fal fa-project-diagram nav-icon  "></i>
                        <p>طرحی های پژوهشی و فناوری</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/teds" class="nav-link ">
                        <i class="nav-icon fal fa-lightbulb-on nav-icon  "></i>
                        <p>کرسی های نظریه پردازی</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/thesis" class="nav-link ">
                        <i class="nav-icon fal fa-book nav-icon  "></i>
                        <p>پایان نامه ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/referees" class="nav-link ">
                        <i class="nav-icon fal fa-gavel nav-icon  "></i>
                        <p>داوری و نظارت بر طرح ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/inventions" class="nav-link ">
                        <i class="nav-icon fal fa-microscope nav-icon  "></i>
                        <p>اختراعات و اکتشافات</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/courses" class="nav-link ">
                        <i class="nav-icon fal fa-users-class nav-icon  "></i>
                        <p>دوره ها</p>
                    </router-link>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs cyan"></i>
                <p>
                    مدیریت رزومه آموزشی
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/booklets" class="nav-link ">
                        <i class="nav-icon fal fa-presentation nav-icon  "></i>
                        <p>جزوات یا اسلایدها</p>
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
                        <i class="nav-icon fal fa-users nav-icon  "></i>
                        <p>کاربران</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/faculties" class="nav-link ">
                        <i class="nav-icon fal fa-university  "></i>
                        <p>دانشکده ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/departments" class="nav-link ">
                        <i class="nav-icon fal fa-building  "></i>
                        <p>گروه های آموزشی</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/score" class="nav-link ">
                        <i class="nav-icon fal fa-star  "></i>
                        <p>مدیریت امتیازها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/term" class="nav-link ">
                        <i class="nav-icon fal fa-calendar-edit  "></i>
                        <p>مدیریت ترم ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/not-ready" class="nav-link ">
                        <i class="nav-icon fal fa-shield-check  "></i>
                        <p>لیست مجلات غیرمجاز</p>
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
                    <router-link to="/paperReport" class="nav-link ">
                        <i class="nav-icon fal fa-pencil-ruler nav-icon  "></i>
                        <p>گزارش مقالات</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bookReport" class="nav-link ">
                        <i class="nav-icon fal fa-books  "></i>
                        <p>گزارش کتب</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-award  "></i>
                        <p>گزارش جوایز</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-book-reader  "></i>
                        <p>گزارش پایان نامه ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-users-class  "></i>
                        <p>گزارش دوره</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-university  "></i>
                        <p>گزارش دانشکده ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/notready" class="nav-link ">
                        <i class="nav-icon fal fa-building  "></i>
                        <p>گزارش گروه های آموزشی</p>
                    </router-link>
                </li>

            </ul>
        </li>

        <li class="nav-item ">
            <router-link to="/profile" class="nav-link ">
                <i class="nav-icon fas fa-id-card cyan "></i>
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
            </router-link>
        </li>
    </ul>
</nav>
