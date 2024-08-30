<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Master</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('book') ? 'active' : '' }}" href="{{ route('book.index') }}"
                        aria-expanded="false">
                        <span>
                            <i class="ti ti-player-record" style="font-size: 8pt"></i> </span>
                        <span class="hide-menu">Book</span>
                    </a>
                </li>
                @if (auth()->user()->roles[0]->name == 'admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->is('category') ? 'active' : '' }}"
                            href="{{ route('category.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-player-record" style="font-size: 8pt"></i> </span>
                            </span>
                            <span class="hide-menu">Category</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->is('writer') ? 'active' : '' }}"
                            href="{{ route('writer.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-player-record" style="font-size: 8pt"></i> </span>
                            </span>
                            <span class="hide-menu">Writer</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->is('publisher') ? 'active' : '' }}"
                            href="{{ route('publisher.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-player-record" style="font-size: 8pt"></i> </span>
                            </span>
                            <span class="hide-menu">Publisher</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->is('user') ? 'active' : '' }}"
                            href="{{ route('user.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-player-record" style="font-size: 8pt;"></i> </span>
                            </span>
                            <span class="hide-menu">User</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->roles[0]->name == 'admin')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Reports</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->is('reports/book-category') ? 'active' : '' }}"
                            href="{{ route('reports.category') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-player-record" style="font-size: 8pt;"></i> </span>
                            </span>
                            <span class="hide-menu">Book By Category</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->is('reports/book-publisher') ? 'active' : '' }}"
                            href="{{ route('reports.publisher') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-player-record" style="font-size: 8pt;"></i> </span>
                            </span>
                            <span class="hide-menu">Book By Publisher</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->is('reports/book-writer') ? 'active' : '' }}"
                            href="{{ route('reports.writer') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-player-record" style="font-size: 8pt;"></i> </span>
                            </span>
                            <span class="hide-menu">Book By Writer</span>
                        </a>
                    </li>
                @endif
            </ul>
            {{-- <div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
                <div class="d-flex">
                    <div class="unlimited-access-title me-3">
                        <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Upgrade to pro</h6>
                        <a href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/" target="_blank"
                            class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Pro</a>
                    </div>
                    <div class="unlimited-access-img">
                        <img src="{{ asset('assets/images/backgrounds/rocket.png') }}" alt=""
                            class="img-fluid">
                    </div>
                </div>
            </div> --}}
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
