<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Vuka</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../styling/main.css">
</head>

<body class="admin-body">

    <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>
    <div class="admin-layout">

        <!-- ── Sidebar ── -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-brand">
                <span class="admin-logo">Vuka</span>
                <span class="admin-logo-tag">Admin</span>
            </div>

            <nav class="admin-nav">
                <button class="admin-nav-item active" data-section="overview">
                    <i class="ri-dashboard-line"></i> Overview
                </button>
                <button class="admin-nav-item" data-section="users">
                    <i class="ri-user-line"></i> Users
                </button>
                <button class="admin-nav-item" data-section="listings">
                    <i class="ri-store-2-line"></i> Listings
                </button>
                <button class="admin-nav-item" data-section="orders">
                    <i class="ri-shopping-bag-line"></i> Orders
                </button>
                <button class="admin-nav-item" data-section="reports">
                    <i class="ri-flag-line"></i> Reports
                </button>
            </nav>

            <a href="../index.php" class="admin-back-link">
                <i class="ri-arrow-left-line"></i> Back to site
            </a>
        </aside>

        <!-- ── Main content ── -->
        <main class="admin-main">

            <div class="admin-topbar">
                <div class="admin-topbar-left">
                    <button class="admin-hamburger" id="sidebarToggle" aria-label="Toggle menu">
                        <i class="ri-menu-line"></i>
                    </button>
                    <div>
                        <h1 class="admin-page-title" id="pageTitle">Overview</h1>
                        <p class="admin-page-sub">Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Overview -->
            <section class="admin-section active" id="section-overview">

                <div class="admin-stats-grid">
                    <div class="admin-stat-card">
                        <div class="stat-icon stat-icon--users"><i class="ri-user-line"></i></div>
                        <div>
                            <p class="stat-label">Total Users</p>
                            <p class="stat-value" id="statUsers">—</p>
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="stat-icon stat-icon--listings"><i class="ri-store-2-line"></i></div>
                        <div>
                            <p class="stat-label">Active Listings</p>
                            <p class="stat-value" id="statListings">—</p>
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="stat-icon stat-icon--orders"><i class="ri-shopping-bag-line"></i></div>
                        <div>
                            <p class="stat-label">Total Orders</p>
                            <p class="stat-value" id="statOrders">—</p>
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="stat-icon stat-icon--volume"><i class="ri-money-rand-circle-line"></i></div>
                        <div>
                            <p class="stat-label">Transaction Volume</p>
                            <p class="stat-value" id="statVolume">—</p>
                        </div>
                    </div>
                </div>

                <div class="admin-two-col">
                    <div class="admin-card">
                        <h3 class="admin-card-title">Recent Sign-ups</h3>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody id="recentUsersBody">
                                <tr>
                                    <td colspan="3" class="table-loading">Loading…</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="admin-card">
                        <h3 class="admin-card-title">Recent Orders</h3>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Listing</th>
                                    <th>Buyer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrdersBody">
                                <tr>
                                    <td colspan="4" class="table-loading">Loading…</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>

            <!-- Users -->
            <section class="admin-section" id="section-users">
                <div class="admin-card">
                    <div class="admin-card-head">
                        <h3 class="admin-card-title">All Users</h3>
                        <span class="admin-card-sub">Sorted by rating — lowest first</span>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="usersBody">
                            <tr>
                                <td colspan="6" class="table-loading">Loading…</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Listings -->
            <section class="admin-section" id="section-listings">
                <div class="admin-card">
                    <div class="admin-card-head">
                        <h3 class="admin-card-title">All Listings</h3>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Seller</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="listingsBody">
                            <tr>
                                <td colspan="6" class="table-loading">Loading…</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Reports -->
            <section class="admin-section" id="section-reports">
                <div class="admin-card">
                    <div class="admin-card-head">
                        <h3 class="admin-card-title">Reported Listings</h3>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Seller</th>
                                <th>Reported By</th>
                                <th>Reason</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="reportsBody">
                            <tr>
                                <td colspan="5" class="table-loading">Loading…</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Orders -->
            <section class="admin-section" id="section-orders">
                <div class="admin-card">
                    <div class="admin-card-head">
                        <h3 class="admin-card-title">All Orders</h3>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="ordersBody">
                            <tr>
                                <td colspan="6" class="table-loading">Loading…</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>

    <script>
        // ── Mobile sidebar toggle ─────────────────────────────────
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const hamburger = document.getElementById('sidebarToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('open');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        }

        hamburger.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
        overlay.addEventListener('click', closeSidebar);

        // ── Sidebar nav ───────────────────────────────────────────
        const navItems = document.querySelectorAll('.admin-nav-item');
        const sections = document.querySelectorAll('.admin-section');
        const titles = {
            overview: 'Overview',
            users: 'Users',
            listings: 'Listings',
            orders: 'Orders',
            reports: 'Reports'
        };

        navItems.forEach(btn => {
            btn.addEventListener('click', function() {
                navItems.forEach(b => b.classList.remove('active'));
                sections.forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('section-' + this.dataset.section).classList.add('active');
                document.getElementById('pageTitle').textContent = titles[this.dataset.section];
                closeSidebar();
            });
        });

        // ── Helpers ───────────────────────────────────────────────
        const fmtDate = str => new Date(str).toLocaleDateString('en-ZA', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        const fmtRand = n => 'R ' + parseFloat(n).toLocaleString('en-ZA', {
            minimumFractionDigits: 2
        });

        function badge(status) {
            const map = {
                active: 'badge--active',
                ban: 'badge--banned',
                inactive: 'badge--inactive',
                paid: 'badge--paid',
                shipped: 'badge--shipped',
                delivered: 'badge--delivered',
                sold: 'badge--sold'
            };
            return `<span class="admin-badge ${map[status] || ''}">${status}</span>`;
        }

        // ── Stats ─────────────────────────────────────────────────
        async function loadStats() {
            const data = await fetch('../../api/admin/stats.php').then(r => r.json());
            if (!data.success) return;

            document.getElementById('statUsers').textContent = data.stats.totalUsers;
            document.getElementById('statListings').textContent = data.stats.totalListings;
            document.getElementById('statOrders').textContent = data.stats.totalOrders;
            document.getElementById('statVolume').textContent = fmtRand(data.stats.totalVolume);

            document.getElementById('recentUsersBody').innerHTML = data.recentUsers.length ?
                data.recentUsers.map(u => `<tr><td>${u.username}</td><td>${u.email}</td><td>${fmtDate(u.createdAt)}</td></tr>`).join('') :
                '<tr><td colspan="3" class="table-empty">No users yet</td></tr>';

            document.getElementById('recentOrdersBody').innerHTML = data.recentOrders.length ?
                data.recentOrders.map(o => `<tr><td>${o.listingTitle}</td><td>${o.buyerName}</td><td>${fmtRand(o.amount)}</td><td>${badge(o.status)}</td></tr>`).join('') :
                '<tr><td colspan="4" class="table-empty">No orders yet</td></tr>';
        }

        // ── Users ─────────────────────────────────────────────────
        async function loadUsers() {
            const data = await fetch('../../api/admin/user_ratings.php').then(r => r.json());
            if (!data.success) return;

            document.getElementById('usersBody').innerHTML = data.users.length ?
                data.users.map(u => `
                <tr id="user-row-${u.userID}">
                    <td><strong>${u.username}</strong></td>
                    <td>${u.email}</td>
                    <td>${u.rating !== null ? `<span class="rating-val">${parseFloat(u.rating).toFixed(1)} / 5</span>` : '<span class="table-na">No ratings</span>'}</td>
                    <td>${badge(u.accountStatus)}</td>
                    <td>${fmtDate(u.createdAt)}</td>
                    <td><button class="admin-action-btn ${u.accountStatus === 'ban' ? 'btn--unban' : 'btn--ban'}"
                            onclick="toggleBan('${u.userID}', this)">
                            ${u.accountStatus === 'ban' ? 'Unban' : 'Ban'}
                        </button></td>
                </tr>`).join('') :
                '<tr><td colspan="6" class="table-empty">No users found</td></tr>';
        }

        async function toggleBan(userID, btn) {
            btn.disabled = true;
            const data = await fetch('../../api/admin/ban_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    userID
                })
            }).then(r => r.json());

            if (data.success) {
                const row = document.getElementById('user-row-' + userID);
                const banned = data.newStatus === 'ban';
                row.cells[3].innerHTML = badge(data.newStatus);
                btn.textContent = banned ? 'Unban' : 'Ban';
                btn.className = `admin-action-btn ${banned ? 'btn--unban' : 'btn--ban'}`;
            }
            btn.disabled = false;
        }

        // ── Listings ──────────────────────────────────────────────
        async function loadListings() {
            const data = await fetch('../../api/admin/get_listings.php').then(r => r.json());
            if (!data.success) return;

            document.getElementById('listingsBody').innerHTML = data.listings.length ?
                data.listings.map(l => `
                <tr id="listing-row-${l.listingID}">
                    <td><strong>${l.title}</strong></td>
                    <td>${l.sellerName}</td>
                    <td>${l.category}</td>
                    <td>${fmtRand(l.price)}</td>
                    <td>${badge(l.status)}</td>
                    <td>${l.status === 'active'
                        ? `<button class="admin-action-btn btn--ban" onclick="removeListing('${l.listingID}', this)">Remove</button>`
                        : '<span class="table-na">—</span>'}</td>
                </tr>`).join('') :
                '<tr><td colspan="6" class="table-empty">No listings found</td></tr>';
        }

        async function removeListing(listingID, btn) {
            if (!confirm('Remove this listing from the platform?')) return;
            btn.disabled = true;
            const data = await fetch('../../api/admin/remove_listing.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    listingID
                })
            }).then(r => r.json());

            if (data.success) {
                const row = document.getElementById('listing-row-' + listingID);
                row.cells[4].innerHTML = badge('inactive');
                btn.replaceWith(document.createTextNode('—'));
            } else {
                btn.disabled = false;
            }
        }

        // ── Orders ────────────────────────────────────────────────
        async function loadOrders() {
            const data = await fetch('../../api/admin/get_orders.php').then(r => r.json());
            if (!data.success) return;

            document.getElementById('ordersBody').innerHTML = data.orders.length ?
                data.orders.map(o => `
                <tr>
                    <td><strong>${o.listingTitle}</strong></td>
                    <td>${o.buyerName}</td>
                    <td>${o.sellerName}</td>
                    <td>${fmtRand(o.amount)}</td>
                    <td>${badge(o.status)}</td>
                    <td>${fmtDate(o.createdAt)}</td>
                </tr>`).join('') :
                '<tr><td colspan="6" class="table-empty">No orders yet</td></tr>';
        }

        // ── Reports ───────────────────────────────────────────────
        async function loadReports() {
            const data = await fetch('../../api/admin/get_reports.php').then(r => r.json());
            if (!data.success) return;

            document.getElementById('reportsBody').innerHTML = data.reports.length ?
                data.reports.map(r => `
                <tr>
                    <td><strong>${r.listingTitle}</strong></td>
                    <td>${r.sellerName}</td>
                    <td>${r.reporterName}</td>
                    <td><span class="admin-badge">${r.reason}</span></td>
                    <td>${fmtDate(r.createdAt)}</td>
                </tr>`).join('') :
                '<tr><td colspan="5" class="table-empty">No reports yet</td></tr>';
        }

        loadStats();
        loadUsers();
        loadListings();
        loadOrders();
        loadReports();
    </script>

</body>

</html>