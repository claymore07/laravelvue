<nav class="mt-2">
    <ul style="overflow:auto;" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="nav-icon false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li v-if="$gate.hasProfile()" class="nav-item">
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                <p>
                    داشبورد
                    <!--<span class="right badge badge-danger">New</span>-->
                </p>
            </router-link>
        </li>

        <li  v-if="$gate.hasProfile()" class="nav-item has-treeview ">
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
                    <router-link to="/researchActivity" class="nav-link ">
                        <i class="nav-icon fal fa-user-secret nav-icon  "></i>
                        <p>فعالیت های اجرایی پژوهشی</p>
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
        <li  v-if="$gate.hasProfile()" class="nav-item has-treeview ">
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

        <li v-if="(type === 'admin' ||type === 'author' )  && $gate.hasProfile()" class="nav-item has-treeview ">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-server blue"></i>
                <p>
                    مدیریت سیستم
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li v-if="(type === 'admin' )  && $gate.hasProfile()" class="nav-item">
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
                    <router-link to="/blacklist" class="nav-link ">
                        <i class="nav-icon fal fa-shield-check  "></i>
                        <p>لیست مجلات غیرمجاز</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/regulations" class="nav-link ">
                        <i class="nav-icon fal fa-info-circle  "></i>
                        <p>آیین نامه و بخشنامه ها</p>
                    </router-link>
                </li>

            </ul>
        </li>

        <li v-if="(type === 'admin' ||type === 'author' ) && $gate.hasProfile()"  class="nav-item has-treeview ">
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
                    <router-link to="/rewardReport" class="nav-link ">
                        <i class="nav-icon fal fa-award  "></i>
                        <p>گزارش جوایز</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/grantReport" class="nav-link ">
                        <i class="nav-icon fal fa-dollar-sign nav-icon  "></i>
                        <p>گزارش گرنت</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/projectReport" class="nav-link ">
                        <i class="nav-icon fal fa-project-diagram nav-icon  "></i>
                        <p>طرحی های پژوهشی و فناوری</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/tedReport" class="nav-link ">
                        <i class="nav-icon fal fa-lightbulb-on nav-icon  "></i>
                        <p>کرسی های نظریه پردازی</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/thesisReport" class="nav-link ">
                        <i class="nav-icon fal fa-book-reader  "></i>
                        <p>گزارش پایان نامه ها</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/refereeReport" class="nav-link ">
                        <i class="nav-icon fal fa-gavel nav-icon  "></i>
                        <p>گزارش داوری ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/researchActivityReport" class="nav-link ">
                        <i class="nav-icon fal fa-user-secret nav-icon  "></i>
                        <p>گزارش فعالیت های اجرایی</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/inventionReport" class="nav-link ">
                        <i class="nav-icon fal fa-microscope nav-icon  "></i>
                        <p>اختراعات و اکتشافات</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/courseReport" class="nav-link ">
                        <i class="nav-icon fal fa-users-class  "></i>
                        <p>گزارش دوره</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bookletReport" class="nav-link ">
                        <i class="nav-icon fal fa-presentation nav-icon  "></i>
                        <p>گزارش جزوات یا اسلایدها</p>
                    </router-link>
                </li>


            </ul>
        </li>
        <li v-if="(type === 'admin' ||type === 'author' ) && $gate.hasProfile()"  class="nav-item has-treeview ">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-analytics orange"></i>
                <p>
                    گزارشات آماری و نموداری
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                    <router-link to="/facultyStats" class="nav-link ">
                        <i class="nav-icon fal fa-university  "></i>
                        <p>گزارش نموداری دانشکده ها</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/positionStats" class="nav-link ">
                        <i class="nav-icon fal fa-user-friends  "></i>
                        <p>گزارش نموداری نوع همکاری</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/typesStats" class="nav-link ">
                        <i class="nav-icon fal fa-badge-check  "></i>
                        <p>گزارش نموداری نوع آثار</p>
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
