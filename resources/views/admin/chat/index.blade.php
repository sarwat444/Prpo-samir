@php use Carbon\Carbon; @endphp
@extends('admin.chat.layouts.chat')
@section('title') @endsection
<style>
 textarea.form-control
 {
     min-height: 150px;
 }
</style>
@section('content')
    <!-- Sidebar Start -->
    <aside class="chat_sidebar">
        <!-- Tab Content Start -->
        <div class="tab-content">
            <!-- Chat Tab Content Start -->
            <div class="tab-pane active" id="chats-content">
                <div class="d-flex flex-column h-100">

                    <div class="hide-scrollbar h-100" id="chatContactsList">
                        <!-- Chat Header Start -->
                        <div class="sidebar-header sticky-top p-2">

                            <!-- Sidebar Header Start -->
                            <div class="sidebar-sub-header">
                                <!-- Sidebar Header Dropdown Start -->
                                <div class="dropdown mr-2">
                                    <!-- Dropdown Button Start -->
                                    <button class="btn btn-outline-default dropdown-toggle" type="button"
                                            data-chat-filter-list="" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        All Chats
                                    </button>
                                    <!-- Dropdown Button End -->

                                    <!-- Dropdown Menu Start -->
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" data-chat-filter="" data-select="all-chats" href="#">Private
                                            Chats</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="groups" href="#">Groups</a>
                                    </div>
                                    <!-- Dropdown Menu End -->
                                </div>
                                <div class="form-inline">
                                    <div class="input-group">
                                        <input id="top_searchInput" type="text" class="form-control search border-right-0 transparent-bg pr-0" placeholder="Search users">

                                        <div class="input-group-append">
                                            <div class="input-group-text transparent-bg border-left-0" role="button" style="background: #1b5b96;border-bottom: 1;color: #fff;">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="hw-20" fill="none" viewbox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <ul class="nav flex-nowrap">
                                            <li class="nav-item list-inline-item d-block d-xl-none mr-1">
                                                <a class="nav-link text-muted px-1" href="#" title="Appbar"
                                                   data-toggle-appbar="">
                                                    <!-- Default :: Inline SVG -->
                                                    <svg class="hw-20" fill="none" stroke-linecap="round"
                                                         stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path
                                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                                    </svg>

                                                    <!-- Alternate :: External File link -->
                                                    <!-- <img class="hw-20" src="./../../assets/media/heroicons/outline/view-grid.svg" alt="" class="injectable hw-20"> -->
                                                </a>
                                            </li>

                                            <li class="nav-item list-inline-item mr-0">
                                                <div class="dropdown">
                                                    <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <!-- Default :: Inline SVG -->
                                                        <svg class="hw-20" fill="none" viewbox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                        </svg>

                                                        <!-- Alternate :: External File link -->
                                                        <!-- <img  class="injectable hw-20" src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                           data-target="#createGroup">Create Group</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Sidebar Search End -->
                            </div>
                            <!-- Sidebar Header End -->
                        </div>
                        <!-- Chat Header End -->
                        <ul class="contacts-list" id="chatContactTab" data-chat-list="">
                            <!-- Display users with chat rooms first -->
                            @foreach($usersWithRooms as $user)
                                @php
                                                if (auth()->user()->id === $user->id) {
                                                    continue;
                                                }
                                                $room = $privateRooms->first(function($room) use ($user) {
                                                    return strpos($room->chat_room_users, (string)$user->id) !== false || $room->chat_room_creator === $user->id;
                                                });
                                @endphp
                                <li class="contacts-item friends" data-name="{{ $user->first_name . ' ' . $user->last_name }}" >
                                    <a class="contacts-link" href="javascript:void(0);"
                                       data-room-id="{{ optional($room)->chat_room_id }}"
                                       data-type="{{ optional($room)->chat_room_type }}" data-user-id="{{ $user->id }}">
                                        <div class="avatar avatar-online">
                                            @if($user->image)
                                                <img src="{{ 'https://pri-po.com/public/assets/images/users/'.$user->image }}"
                                                     alt="{{ $user->first_name }} {{ $user->last_name }}">
                                            @else
                                                <img src="{{ asset(PUBLIC_PATH.'assets/media/avatar/2.png') }}" alt="">
                                            @endif
                                        </div>
                                        <div class="contacts-content">
                                            <div class="contacts-info">
                                                <h6 class="chat-name text-truncate">
                                                    {{ $user->first_name . ' ' . $user->last_name }}
                                                </h6>
                                                <div class="chat-time">
                                                    {{ optional($room)->created_at ? Carbon::parse($room->created_at)->format('d.m.Y') : '' }}
                                                </div>
                                                <div class="chat-count-{{$user->id}}">
                                                    <input type="hidden" id="chat-count-{{$user->id}}" value="{{$room->count ?? 0 }}">
                                                    <span class="badge badge-primary">{{ $room->count ??  0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach

                        @foreach($groupRooms as $group)
                                <li class="contacts-item groups" >
                                    <a class="contacts-link"
                                       href="javascript:void(0);"
                                       data-room-id="{{ $group->chat_room_id }}"
                                       data-type="{{ $group->chat_room_type }}">
                                        <div class="avatar bg-success text-light">
                                            <span>
                                                <img src="{{$group->chat_room_image}}">
                                            </span>
                                        </div>
                                        <div class="contacts-content">
                                            <div class="contacts-info">
                                                <h6 class="chat-name">{{$group->chat_room_name}}</h6>
                                                <div class="chat-count">
                                                    <input type="hidden" id="chat-count" value="">
                                                    <span class="badge badge-primary">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach

                            <!-- Display users without chat rooms -->
                            @foreach($usersWithoutRooms as $user)
                                @php
                                    // Check if the current user is the authenticated user
                                   $isAuthUser = auth()->user()->id === $user->id;
                                @endphp
                                <li class="contacts-item friends" data-name="{{ $user->first_name . ' ' . $user->last_name }}">
                                    <a class="contacts-link" href="javascript:void(0);" data-user-id="{{ $user->id }}" data-type="Private">
                                        <div class="avatar avatar-online">
                                            @if($user->image)
                                                <img src={{"https://pri-po.com/public/assets/images/users/".$user->image }}
                                                     alt="{{ $user->first_name }} {{ $user->last_name }}">
                                            @else
                                                <img src="{{ asset(PUBLIC_PATH.'assets/media/avatar/2.png') }}" alt="">
                                            @endif
                                        </div>
                                        <div class="contacts-content">
                                            <div class="contacts-info">
                                                <h6 class="chat-name text-truncate">
                                                    {{ $isAuthUser ? 'Just You' : $user->first_name . ' ' . $user->last_name }}
                                                </h6>
                                                <div class="chat-count-{{$user->id}}">
                                                    <input type="hidden" id="chat-count-{{$user->id}}" value="{{$room->count ?? 0 }}">
                                                    <span class="badge badge-primary">{{ $room->count ??  0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            @if($users->isEmpty())
                                <li>No Users Found</li>
                            @endif

                        </ul>

                    </div>
                </div>
            </div>
            <!-- Chats Tab Content End -->

            <!-- Calls Tab Content Start -->
            <div class="tab-pane" id="calls-content">
                <div class="d-flex flex-column h-100">
                    <div class="hide-scrollbar h-100" id="callContactsList">
                        <!-- Chat Header Start -->
                        <div class="sidebar-header sticky-top p-2">

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Chat Tab Pane Title Start -->
                                <h5 class="font-weight-semibold mb-0">Calls</h5>
                                <!-- Chat Tab Pane Title End -->

                                <ul class="nav flex-nowrap">

                                    <li class="nav-item list-inline-item mr-1">
                                        <a class="nav-link text-muted px-1" href="#" title="Notifications" role="button"
                                           data-toggle="modal" data-target="#notificationModal">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img src="./../../assets/media/heroicons/outline/bell.svg" alt="" class="injectable hw-20"> -->
                                        </a>
                                    </li>

                                    <li class="nav-item list-inline-item mr-0">
                                        <div class="dropdown">
                                            <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="hw-20" fill="none" viewbox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt="" class="injectable hw-20"> -->
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                   data-target="#startConversation">New Chat</a>
                                                <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                   data-target="#createGroup">Create Group</a>
                                                <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                   data-target="#inviteOthers">Invite Others</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>


                            <!-- Sidebar Header Start -->
                            <div class="sidebar-sub-header">
                                <!-- Sidebar Header Dropdown Start -->
                                <div class="dropdown mr-2">
                                    <!-- Dropdown Button Start -->
                                    <button class="btn btn-outline-default dropdown-toggle" type="button"
                                            data-chat-filter-list="" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        All Chats
                                    </button>
                                    <!-- Dropdown Button End -->

                                    <!-- Dropdown Menu Start -->
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" data-chat-filter="" data-select="all-chats" href="#">All
                                            Chats</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="friends" href="#">Friends</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="groups" href="#">Groups</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="unread" href="#">Unread</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="archived" href="#">Archived</a>
                                    </div>
                                    <!-- Dropdown Menu End -->
                                </div>
                                <!-- Sidebar Header Dropdown End -->

                                <!-- Sidebar Search Start -->
                                <div class="form-inline">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control search border-right-0 transparent-bg pr-0"
                                               placeholder="Search users">
                                        <div class="input-group-append">
                                            <div class="input-group-text transparent-bg border-left-0" role="button">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="text-muted hw-20" fill="none" viewbox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Sidebar Search End -->
                            </div>
                            <!-- Sidebar Header End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Calls Tab Content End -->

            <!-- Friends Tab Content Start -->
            <div class="tab-pane" id="friends-content">
                <div class="d-flex flex-column h-100">
                    <div class="hide-scrollbar" id="friendsList">
                        <!-- Chat Header Start -->
                        <div class="sidebar-header sticky-top p-2">

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Chat Tab Pane Title Start -->
                                <h5 class="font-weight-semibold mb-0">Friends</h5>
                                <!-- Chat Tab Pane Title End -->

                                <ul class="nav flex-nowrap">

                                    <li class="nav-item list-inline-item mr-1">
                                        <a class="nav-link text-muted px-1" href="#" title="Notifications" role="button"
                                           data-toggle="modal" data-target="#notificationModal">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img src="./../../assets/media/heroicons/outline/bell.svg" alt="" class="injectable hw-20"> -->
                                        </a>
                                    </li>

                                    <li class="nav-item list-inline-item mr-0">
                                        <div class="dropdown">
                                            <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="hw-20" fill="none" viewbox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt="" class="injectable hw-20"> -->
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                   data-target="#startConversation">New Chat</a>
                                                <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                   data-target="#createGroup">Create Group</a>
                                                <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                   data-target="#inviteOthers">Invite Others</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>


                            <!-- Sidebar Header Start -->
                            <div class="sidebar-sub-header">
                                <!-- Sidebar Header Dropdown Start -->
                                <div class="dropdown mr-2">
                                    <!-- Dropdown Button Start -->
                                    <button class="btn btn-outline-default dropdown-toggle" type="button"
                                            data-chat-filter-list="" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        All Chats
                                    </button>
                                    <!-- Dropdown Button End -->

                                    <!-- Dropdown Menu Start -->
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" data-chat-filter="" data-select="all-chats" href="#">Private
                                            Chats</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="friends" href="#">Friends</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="groups" href="#">Groups</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="unread" href="#">Unread</a>
                                        <a class="dropdown-item" data-chat-filter="" data-select="archived" href="#">Archived</a>
                                    </div>
                                    <!-- Dropdown Menu End -->
                                </div>
                                <!-- Sidebar Header Dropdown End -->

                                <!-- Sidebar Search Start -->
                                <div class="form-inline">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control search border-right-0 transparent-bg pr-0"
                                               placeholder="Search users">
                                        <div class="input-group-append">
                                            <div class="input-group-text transparent-bg border-left-0" role="button">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="text-muted hw-20" fill="none" viewbox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/search.svg" alt=""> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Sidebar Search End -->
                            </div>
                            <!-- Sidebar Header End -->
                        </div>
                        <!-- Chat Header End -->
                    </div>
                </div>
            </div>
            <!-- Friends Tab Content End -->

            <!-- Profile Tab Content Start -->

            <!-- Profile Tab Content End -->
        </div>
        <!-- Tab Content End -->
    </aside>
    <!-- Sidebar End -->

    <!-- Main Start -->
    <main class="main main-visible">
        <!-- Chats Page Start -->
        <div class="chats">
            <div class="chat-body">
                <!-- Chat Header Start-->
                <div class="chat-header ">
                    <!-- Chat Back Button (Visible only in Small Devices) -->
                    <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted d-xl-none" type="button"
                            data-close="">
                        <!-- Default :: Inline SVG -->
                        <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>

                        <!-- Alternate :: External File link -->
                        <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/arrow-left.svg" alt=""> -->
                    </button>

                    <!-- Chat participant's Name -->
                    <div class="media chat-name align-items-center text-truncate contact_info">
                        <div class="avatar avatar-online d-none d-sm-inline-block mr-3">
                            <img src="{{asset(PUBLIC_PATH.'assets/media/avatar/8.png')}}" alt="">
                        </div>

                        <div class="media-body align-self-center online_user ">
                            <h6 class="text-truncate mb-0">Catherine Richardson</h6>
                            <small class="text-muted">Online</small>
                        </div>
                    </div>

                    <!-- Chat Options -->
                    <ul class="nav flex-nowrap">

                        <li class="nav-item list-inline-item d-none d-sm-block mr-0">
                            <div class="dropdown">
                                <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>

                                    <!-- Alternate :: External File link -->
                                    <!-- <img src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt="" class="injectable hw-20"> -->
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item align-items-center d-flex" href="#"
                                       data-chat-info-toggle="">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/information-circle.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>View Info</span>
                                    </a>

                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"
                                                  clip-rule="evenodd"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/volume-off.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Mute Notifications</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/photograph.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Wallpaper</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/archive.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Archive</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/trash.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Delete</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex text-danger" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/ban.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Block</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item list-inline-item d-sm-none mr-0">
                            <div class="dropdown">
                                <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>

                                    <!-- Alternate :: External File link -->
                                    <!-- <img src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt="" class="injectable hw-20"> -->
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/phone.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Call</span>
                                    </a>

                                    <a class="dropdown-item align-items-center d-flex" href="#"
                                       data-chat-info-toggle="">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/information-circle.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>View Info</span>
                                    </a>

                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"
                                                  clip-rule="evenodd"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/volume-off.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Mute Notifications</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/photograph.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Wallpaper</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/archive.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Archive</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/trash.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Delete</span>
                                    </a>
                                    <a class="dropdown-item align-items-center d-flex text-danger" href="#">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 mr-2" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img src="./../../assets/media/heroicons/outline/ban.svg" alt="" class="injectable hw-20 mr-2"> -->
                                        <span>Block</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Chat Header End-->

                <!-- Search Start -->
                <div class="collapse border-bottom px-3" id="searchCollapse">
                    <div class="container-xl py-2 px-0 px-md-3">
                        <div class="input-group bg-light ">
                            <input type="text" class="form-control form-control-md border-right-0 transparent-bg pr-0"
                                   placeholder="Search">
                            <div class="input-group-append">
                                    <span class="input-group-text transparent-bg border-left-0">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-20 text-muted" fill="none" viewbox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/search.svg" alt="Search icon"> -->
                                    </span>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Search End -->

                <!-- Chat Content Start-->

                <div class="chat-content p-2 " id="" data-to="0">
                    <div class="container">
                        <div class="message-day">
                            <div class="interface text-center">
                                <h1 class="fw-bold text-center fs-3">Verbunden bleiben</h1>
                                <img src="{{asset(PUBLIC_PATH.'assets/images/chat.png')}}">
                            </div>
                        </div>
                    </div>
                    <!-- Scroll to finish -->
                    <div class="chat-finished" id="chat-finished"></div>
                </div>

                <!-- Chat Content End-->

                <!-- Chat Footer Start-->
                <div class="chat-footer" style="padding: 0px 20px;">
                    <div class="row">
                        <div class="col-md-2 d-flex mt-3">
                            <label for="file_upload" class="upload-icon">
                                <i class="fa fa-paperclip"></i>
                                <input type="file" id="image_upload"  style="display: none;">
                            </label>

                            <label for="image_upload" class="upload-icon">
                                <i class="fa fa-image"></i>
                                <input type="file" id="image_upload" accept="image/*" style="display: none;">
                            </label>
                            <div id="audioControls">
                                <button id="recordButton" class="btn btn-primary"><i class="fa fa-microphone"></i></button>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="d-flex ">

                                <button type="button" id="deleteRecording" class="btn btn-warning" disabled><i
                                        class="fa fa-trash"></i></button>


                                <div id="audioPreview" class="mt-2"></div>


                                <button type="button" id="sendRecording" class="btn btn-success" disabled><i
                                        class="fa fa-arrow-right"></i></button>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control emojionearea-form-control" id="message_input" rows="3"
                                      placeholder="Type your message here..."></textarea>
                            <input type="hidden" id="room_type" name="room_type">
                            <input type="hidden" id="user_to" name="to">
                            <input type="hidden" id="room_id" name="room_id">
                            <div class="btn btn-primary btn-icon send-icon rounded-circle text-light mb-1" role="button"
                                 id="submit_button">
                                <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Footer End-->
            </div>

            <!-- Chat Info Start -->
            <div class="chat-info">
                <div class="d-flex h-100 flex-column">

                    <!-- Chat Info Header Start -->
                    <div class="chat-info-header px-2">
                        <div class="container-fluid">
                            <ul class="nav justify-content-between align-items-center">
                                <!-- Sidebar Title Start -->
                                <li class="text-center">
                                    <h5 class="text-truncate mb-0">Profile Details</h5>
                                </li>
                                <!-- Sidebar Title End -->

                                <!-- Close Sidebar Start -->
                                <li class="nav-item list-inline-item">
                                    <a class="nav-link text-muted px-0" href="#" data-chat-info-close="">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-22" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img class="injectable hw-22" src="./../../assets/media/heroicons/outline/x.svg" alt=""> -->

                                    </a>
                                </li>
                                <!-- Close Sidebar End -->
                            </ul>
                        </div>
                    </div>
                    <!-- Chat Info Header End  -->

                    <!-- Chat Info Body Start  -->
                    <div class="hide-scrollbar flex-fill">

                        <!-- User Profile Start -->
                        <div class="text-center p-3">

                            <!-- User Info -->
                            <h5 class="mb-1">User Name</h5>
                            <p class="text-muted d-flex align-items-center justify-content-center">
                                <!-- Default :: Inline SVG -->
                                <svg class="hw-18 mr-1" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>

                                <!-- Alternate :: External File link -->
                                <!-- <img class="injectable mr-1 hw-18" src="./../../assets/media/heroicons/outline/location-marker.svg" alt=""> -->
                                <span>San Fransisco, CA</span>
                            </p>

                            <!-- User Quick Options -->
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="btn btn-outline-default btn-icon rounded-circle mx-1">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>

                                    <!-- Alternate :: External File link -->
                                    <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/user-add.svg" alt=""> -->
                                </div>
                                <div class="btn btn-primary btn-icon rounded-circle text-light mx-1">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>

                                    <!-- Alternate :: External File link -->
                                    <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/heart.svg" alt=""> -->
                                </div>
                                <div class="btn btn-danger btn-icon rounded-circle text-light mx-1">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>

                                    <!-- Alternate :: External File link -->
                                    <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/ban.svg" alt=""> -->
                                </div>
                            </div>
                        </div>
                        <!-- User Profile End -->

                        <!-- User Information Start -->
                        <div class="chat-info-group">
                            <a class="chat-info-group-header" data-toggle="collapse" href="#profile-info" role="button"
                               aria-expanded="true" aria-controls="profile-info">
                                <h6 class="mb-0">User Information</h6>

                                <!-- Default :: Inline SVG -->
                                <svg class="hw-20 text-muted" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>

                                <!-- Alternate :: External File link -->
                                <!-- <img class="injectable text-muted hw-20" src="./../../assets/media/heroicons/outline/information-circle.svg" alt=""> -->
                            </a>

                            <div class="chat-info-group-body collapse show" id="profile-info">
                                <div class="chat-info-group-content list-item-has-padding">
                                    <!-- List Group Start -->
                                    <ul class="list-group list-group-flush ">

                                        <!-- List Group Item Start -->
                                        <li class="list-group-item border-0">
                                            <p class="small text-muted mb-0">Phone</p>
                                            <p class="mb-0">+01-222-364522</p>
                                        </li>
                                        <!-- List Group Item End -->

                                        <!-- List Group Item Start -->
                                        <li class="list-group-item border-0">
                                            <p class="small text-muted mb-0">Email</p>
                                            <p class="mb-0">catherine.richardson@gmail.com</p>
                                        </li>
                                        <!-- List Group Item End -->

                                        <!-- List Group Item Start -->
                                        <li class="list-group-item border-0">
                                            <p class="small text-muted mb-0">Address</p>
                                            <p class="mb-0">1134 Ridder Park Road, San Fransisco, CA 94851</p>
                                        </li>
                                        <!-- List Group Item End -->
                                    </ul>
                                    <!-- List Group End -->
                                </div>
                            </div>
                        </div>
                        <!-- User Information End -->

                        <!-- Shared Media Start -->
                        <div class="chat-info-group">
                            <a class="chat-info-group-header" data-toggle="collapse" href="#shared-media" role="button"
                               aria-expanded="true" aria-controls="shared-media">
                                <h6 class="mb-0">Last Media</h6>

                                <!-- Default :: Inline SVG -->
                                <svg class="hw-20 text-muted" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>

                            </a>

                        </div>
                        <!-- Shared Media End -->

                        <!-- Shared Files Start -->
                        <div class="chat-info-group">
                            <a class="chat-info-group-header" data-toggle="collapse" href="#shared-files" role="button"
                               aria-expanded="true" aria-controls="shared-files">
                                <h6 class="mb-0">Documents</h6>

                                <!-- Default :: Inline SVG -->
                                <svg class="hw-20 text-muted" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>

                                <!-- Alternate :: External File link -->
                                <!-- <img class="injectable text-muted hw-20" src="./../../assets/media/heroicons/outline/document.svg" alt=""> -->
                            </a>

                            <div class="chat-info-group-body collapse show" id="shared-files">
                                <div class="chat-info-group-content list-item-has-padding">
                                    <!-- List Group Start -->
                                    <ul class="list-group list-group-flush">

                                        <!-- List Group Item Start -->
                                        <li class="list-group-item">
                                            <div class="document">
                                                <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                                    <!-- Default :: Inline SVG -->
                                                    <svg class="hw-24" fill="none" viewbox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>

                                                    <!-- Alternate :: External File link -->
                                                    <!-- <img class="injectable hw-24" src="./../../assets/media/heroicons/outline/document.svg" alt=""> -->
                                                </div>

                                                <div class="document-body">
                                                    <h6 class="text-truncate">
                                                        <a href="#" class="text-reset"
                                                           title="effects-of-global-warming.docs">Effects-of-global-warming.docs</a>
                                                    </h6>

                                                    <ul class="list-inline small mb-0">
                                                        <li class="list-inline-item">
                                                            <span class="text-muted">79.2 KB</span>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span class="text-muted text-uppercase">docs</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="document-options ml-1">
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted"
                                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <!-- Default :: Inline SVG -->
                                                            <svg class="hw-20" fill="none" viewbox="0 0 24 24"
                                                                 stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                            </svg>

                                                            <!-- Alternate :: External File link -->
                                                            <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Download</a>
                                                            <a class="dropdown-item" href="#">Share</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- List Group Item End -->

                                        <!-- List Group Item Start -->
                                        <li class="list-group-item">
                                            <div class="document">
                                                <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                                    <!-- Default :: Inline SVG -->
                                                    <svg class="hw-24" fill="none" viewbox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>

                                                    <!-- Alternate :: External File link -->
                                                    <!-- <img class="injectable hw-24" src="./../../assets/media/icons/excel-file.svg" alt=""> -->
                                                </div>

                                                <div class="document-body">
                                                    <h6 class="text-truncate">
                                                        <a href="#" class="text-reset"
                                                           title="global-warming-data-2020.xlxs">Global-warming-data-2020.xlxs</a>
                                                    </h6>

                                                    <ul class="list-inline small mb-0">
                                                        <li class="list-inline-item">
                                                            <span class="text-muted">79.2 KB</span>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span class="text-muted text-uppercase">xlxs</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="document-options ml-1">
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted"
                                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <!-- Default :: Inline SVG -->
                                                            <svg class="hw-20" fill="none" viewbox="0 0 24 24"
                                                                 stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                            </svg>

                                                            <!-- Alternate :: External File link -->
                                                            <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">View</a>
                                                            <a class="dropdown-item" href="#">Share</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- List Group Item End -->

                                        <!-- List Group Item Start -->
                                        <li class="list-group-item">
                                            <div class="document">
                                                <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                                    <!-- Default :: Inline SVG -->
                                                    <svg class="hw-24" fill="none" viewbox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>

                                                    <!-- Alternate :: External File link -->
                                                    <!-- <img class="injectable hw-24" src="./../../assets/media/icons/powerpoint-file.svg" alt=""> -->
                                                </div>

                                                <div class="document-body">
                                                    <h6 class="text-truncate">
                                                        <a href="#" class="text-reset"
                                                           title="great-presentation-on global-warming-2020.ppt">Great-presentation-on
                                                            global-warming-2020.ppt</a>
                                                    </h6>

                                                    <ul class="list-inline small mb-0">
                                                        <li class="list-inline-item">
                                                            <span class="text-muted">79.2 KB</span>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span class="text-muted text-uppercase">ppt</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="document-options ml-1">
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted"
                                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <!-- Default :: Inline SVG -->
                                                            <svg class="hw-20" fill="none" viewbox="0 0 24 24"
                                                                 stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                            </svg>

                                                            <!-- Alternate :: External File link -->
                                                            <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Download</a>
                                                            <a class="dropdown-item" href="#">Share</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- List Group Item End -->
                                    </ul>
                                    <!-- List Group End -->
                                </div>
                            </div>
                        </div>
                        <!-- Shared Files End -->

                    </div>
                    <!-- Chat Info Body Start  -->

                </div>
            </div>
            <!-- Chat Info End -->
        </div>
        <!-- Chats Page End -->


    </main>
    <!-- Main End -->

    <div class="backdrop"></div>

    <!-- All Modals Start -->

    <!-- Modal 1 :: Start a Conversation-->
    <div class="modal modal-lg-fullscreen fade" id="startConversation" tabindex="-1" role="dialog"
         aria-labelledby="startConversationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="startConversationLabel">New Chat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 hide-scrollbar">
                    <div class="row">
                        <div class="col-12">
                            <!-- Search Start -->
                            <div class="form-inline w-100 p-2 border-bottom">
                                <div class="input-group w-100 bg-light">
                                    <input type="text"
                                           class="form-control form-control-md search border-right-0 transparent-bg pr-0"
                                           placeholder="Search">
                                    <div class="input-group-append">
                                        <div class="input-group-text transparent-bg border-left-0" role="button">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-20" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/search.svg" alt=""> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Search End -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 :: Create Group -->
    <div class="modal fade" id="createGroup" tabindex="-1" role="dialog"
         aria-labelledby="createGroupLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupLabel">Create New Goup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.chat.addGroup')}}" method="post" onsubmit="return collectSelectedUsers()" enctype="multipart/form-data">
                    <div class="modal-body py-0">
                            @csrf
                            <div class="row  pt-2" data-title="Create a New Group">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="groupName">Group name</label>
                                        <input name="group_name" type="text" class="form-control form-control-md"
                                               id="groupName" placeholder="Type group name here" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Choose profile picture</label>
                                        <div class="custom-file">
                                            <input name="group_image" type="file" class="custom-file-input"
                                                   id="profilePictureInput" accept="image/*" required>
                                            <label class="custom-file-label" for="profilePictureInput">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row  pt-2" d data-title="Add Group Members">
                                <div class="col-12 px-0">
                                    <!-- Search Start -->
                                    <div class="form-inline w-100 px-2 pb-2 border-bottom">
                                        <div class="input-group w-100 bg-light">
                                            <input type="text" id="searchInput"
                                                   class="form-control form-control-md search border-right-0 transparent-bg pr-0"
                                                   placeholder="Search">
                                            <div class="input-group-append">
                                                <div class="input-group-text transparent-bg border-left-0" role="button">
                                                    <svg class="hw-20" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Search End -->
                                </div>
                                <div class="col-12 px-0">
                                    <!-- List Group Start -->
                                    <ul class="list-group list-group-flush user_groups" id="userList">
                                        @forelse($users as $user)
                                            <!-- List Group Item Start -->
                                            <li class="list-group-item">
                                                <div class="media">
                                                    @if($user->image)
                                                        <img style="height: 40px; width: 40px;border-radius: 50%;margin-right: 10px;border: 2px solid #ccc;" src="{{ 'https://pri-po.com/public/assets/images/users/'.$user->image }}"
                                                             alt="{{ $user->first_name }} {{ $user->last_name }}">
                                                    @else
                                                        <img  style="height: 40px; width: 40px;border-radius: 50%;margin-right: 10px;border: 2px solid #ccc;"  src="{{ asset(PUBLIC_PATH.'assets/media/avatar/2.png') }}" alt="">
                                                    @endif
                                                    <div class="media-body">
                                                        <h6 class="text-truncate">
                                                            <a href="#"
                                                               class="text-reset">{{ $user->first_name }} {{ $user->last_name }}</a>
                                                        </h6>
                                                        <p class="text-muted mb-0">Online</p>
                                                    </div>
                                                    <div class="media-options">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input user-checkbox"
                                                                   type="checkbox" value="{{ $user->id }}"
                                                                   id="chx-user-{{ $user->id }}">
                                                            <label class="custom-control-label"
                                                                   for="chx-user-{{ $user->id }}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="list-group-item">No users found.</li>
                                        @endforelse
                                    </ul>
                                    <!-- List Group End -->
                                </div>
                            </div>
                            <!-- Hidden input to store selected users -->
                            <input type="hidden" name="users" id="selectedUsers">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-muted mr-auto" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- Modal 3 :: Invite Others -->
        <div class="modal modal-lg-fullscreen fade" id="inviteOthers" tabindex="-1" role="dialog"
             aria-labelledby="inviteOthersLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inviteOthersLabel">Invite Others</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body hide-scrollbar">
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inviteEmailAddress">Email address</label>
                                        <input type="email" class="form-control form-control-md" id="inviteEmailAddress"
                                               placeholder="Type email address here" value="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inviteMessage">Invitation message</label>
                                        <textarea class="form-control form-control-md no-resize hide-scrollbar"
                                                  id="inviteMessage" placeholder="Write your message here"
                                                  rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Send Invitation</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Main Layout End -->
@endsection
@push('script')
    @include('admin.chat.scripts.script')
@endpush


