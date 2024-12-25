
    <!--New Crm Sidebar  -->
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">

                    <li class="menu-title" key="t-apps">{{__('messages.MENU')}}</li>
                    <li>
                        <a href="{{route('admin.crm')}}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span key="t-dashboards">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-user-circle"></i>
                            <span key="t-users">{{__('messages.users')}} </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('admin.users.all')}}" key="t-users">{{__('messages.view_users')}} </a></li>
                            <li><a href="{{route('admin.users.piriority')}}" key="t-add-product">{{__('messages.sort_users')}}</a></li>

                        </ul>
                    </li>

                  @if(Auth()->user()->role == 1 )
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span key="t-users">{{__('messages.accounts')}}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('admin.accounts')}}" key="t-users">{{__('messages.show_accounts')}} </a></li>
                            <li><a href="{{route('admin.accounts.create')}}" key="t-add-product">{{__('messages.new_account')}} </a></li>
                        </ul>
                    </li>
                @endif


                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-briefcase-alt-2"></i>
                            <span key="t-users"> {{__('messages.Categories')}} </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('admin.categories.list')}}" key="t-users">{{__('messages.All_Categories')}} </a></li>
                            <li><a href="{{route('admin.categories.create')}}" key="t-add-product">{{__('messages.add_new_category')}}</a></li>
                        </ul>
                    </li>



                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-detail"></i>
                            <span key="t-users">{{__('messages.packages')}}  </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('admin.packages')}}" key="t-users"> {{__('messages.show_packages')}} </a></li>
                            <li><a href="{{route('admin.packages.create')}}" key="t-add-product">  {{__('messages.add_package')}} </a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-purchase-tag"></i>
                            <span key="t-users">Tags </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('admin.tags')}}" key="t-users"> Tags </a></li>
                            <li><a href="{{route('admin.tags.create')}}" key="t-add-product">{{__('messages.new_tag')}}</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('admin.settings')}}" class="waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-dashboards">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!--End New CRM Sidebar  -->
