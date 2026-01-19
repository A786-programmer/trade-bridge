<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <!-- Logo container -->
            <div class="logo">
                <a href="index.php" class="logo">
                    <i class="mdi mdi-bowling text-success mr-1"></i> 
                    <span class="hide-phone">Trade Bridge</span>
                </a>
            </div>
            <div class="menu-extras topbar-custom">
                <ul class="list-inline float-right mb-0">
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="javascript:void(0)" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <img src="logo.png" alt="user" class="rounded-circle">
                            <span class="ml-2 d-none d-sm-inline-block">
                                <?= isset($fetchUser['u_username']) ? htmlspecialchars($fetchUser['u_username']) : 'Guest' ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown border-0">
                            <div class="dropdown-item noti-title">
                                <h5>Welcome <?=htmlspecialchars($fetchUser['u_name'])?></h5>
                            </div>
                            <!-- <a class="dropdown-item" href="index.php">
                                <i class="mdi mdi-settings m-r-5 text-muted"></i> Settings
                            </a> -->
                            <a class="dropdown-item" href="code.php?type=logout">
                                <i class="mdi mdi-logout m-r-5 text-muted"></i> Logout
                            </a>
                        </div>
                    </li>

                    <li class="menu-item list-inline-item">
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Navbar -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <ul class="navigation-menu">
                    <?php 
                        if($canAccessImport) {
                    ?>
                    <li class="has-submenu">
                        <a href="import.php"><i class="dripicons-blog"></i>Import</a>
                        <ul class="submenu">
                            <li class="has-submenu">
                                <a href="javascript:void(0)">Ranking By</a>
                                <ul class="submenu">
                                    <li><a href="javascript:void(0)">Top Importers</a></li>
                                    <li><a href="javascript:void(0)">Top Importer Afghan</a></li>
                                    <li><a href="javascript:void(0)">Top Importer (Karachi/KICT)</a></li>
                                    <li><a href="javascript:void(0)">Top Importer (Karachi/KPCT)</a></li>
                                    <li><a href="javascript:void(0)">Top Importer (P/Qasim)</a></li>
                                    <li><a href="javascript:void(0)">Top Ports</a></li>
                                    <li><a href="javascript:void(0)">Top Countries</a></li>
                                    <li><a href="javascript:void(0)">Top Region</a></li>
                                    <li><a href="javascript:void(0)">Top Importers/Ports</a></li>
                                    <li><a href="javascript:void(0)">Top Carrier/Lines - Monthly</a></li>
                                    <li><a href="javascript:void(0)">Top Carrier/Lines - Quarterly</a></li>
                                    <li><a href="javascript:void(0)">Top Importers,shipping Agents/Ports</a></li>
                                    <li><a href="javascript:void(0)">Top shipping Agents/Region</a></li>
                                    <li><a href="javascript:void(0)">Top shipping Agents/Ports</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php 
                        }
                        if($canAccessExport) {
                    ?>
                    <li class="has-submenu">
                        <a href="export.php"><i class="dripicons-blog"></i>Export</a>
                    </li>
                    <?php 
                        }
                        if ($canAccessBulkData) {
                    ?>
                    <li class="">
                        <a href="javascript:void(0)"><i class="dripicons-blog"></i>Bulk Data</a>
                    </li>
                    <?php 
                        }
                        if ($canAccessAirFreightImport) {
                    ?>
                    <li class="">
                        <a href="javascript:void(0)"><i class="dripicons-blog"></i>Air Freight/Import</a>
                    </li>
                    <?php 
                        }
                        if ($canAccessAirFreightExport) {
                    ?>
                    <li class="">
                        <a href="javascript:void(0)"><i class="dripicons-blog"></i>Air Freight/Export</a>
                    </li>
                    <?php 
                        }
                        if ($hasAdminAccess) {
                    ?>
                    <li class="">
                        <a href="create-account.php"><i class="dripicons-to-do"></i>Create Account</a>
                    </li>
                    <li class="">
                        <a href="login-sessions.php"><i class="dripicons-to-do"></i>Login Sessions</a>
                    </li>
                    <?php 
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</header>
