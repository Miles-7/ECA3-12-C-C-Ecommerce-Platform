<?php
/*
=============================================================
  RESPONSIVE CSS — REFERENCE EXAMPLES
  Stack: Vanilla CSS media queries + JS class toggling
=============================================================

  This file is a reference guide, NOT a real page.
  All examples follow the patterns used in this project.

  CONTENTS
  ─────────────────────────────────────────────────────────
  1.  Breakpoints        — the sizes used in this project
  2.  Grid collapsing    — 4-col → 2-col → 1-col
  3.  Off-canvas sidebar — slide-in panel with overlay
  4.  Sticky footer      — footer pinned to bottom
  5.  Mobile tables      — horizontal scroll wrapper
  6.  Flex wrapping      — row that stacks on small screens
  7.  Responsive images  — images that don't overflow
  8.  Common mistakes    — things to avoid
=============================================================
*/


/* ============================================================
   1. BREAKPOINTS
   ─────────────────────────────────────────────────────────
   This project uses desktop-first breakpoints.
   Write base styles for large screens, then override
   downward with max-width media queries.

   Breakpoint reference:
     > 900px   — desktop (default, no query needed)
     ≤ 900px   — tablet landscape / small desktop
     ≤ 768px   — tablet portrait / large phone
     ≤ 480px   — phone

   Syntax:
     @media (max-width: Xpx) { ... }
============================================================ */

/*

    .my-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);   // default: 4 columns (desktop)
    }

    @media (max-width: 900px) {
        .my-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 480px) {
        .my-grid { grid-template-columns: 1fr; }
    }

*/


/* ============================================================
   2. GRID COLLAPSING
   ─────────────────────────────────────────────────────────
   Use when: a row of cards needs to stack on smaller screens.
   Pattern: start with many columns, reduce at each breakpoint.
============================================================ */

/*

    // ── CSS ─────────────────────────────────────────────────

    .card-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);  // 4 on desktop
        gap: 1.25rem;
    }

    @media (max-width: 900px) {
        .card-grid { grid-template-columns: repeat(2, 1fr); }  // 2 on tablet
    }

    @media (max-width: 480px) {
        .card-grid { grid-template-columns: 1fr; }             // 1 on phone
    }


    // ── Two-column layout (side by side → stacked) ──────────

    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    @media (max-width: 768px) {
        .two-col { grid-template-columns: 1fr; }  // stack vertically
    }

*/


/* ============================================================
   3. OFF-CANVAS SIDEBAR
   ─────────────────────────────────────────────────────────
   Use when: a desktop sidebar should become a slide-in drawer
   on mobile instead of squishing the page.

   How it works:
   - Desktop: sidebar is a normal flex column beside main content
   - Mobile:  sidebar is fixed off-screen (translateX(-100%)),
              slides in when .open class is added
   - An overlay darkens the page behind the open sidebar
   - Clicking the overlay or a nav item closes the sidebar
============================================================ */

/*

    // ── HTML structure ───────────────────────────────────────

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="layout">

        <aside class="sidebar" id="sidebar">
            <nav>...</nav>
        </aside>

        <main class="main-content">

            <button class="hamburger" id="hamburgerBtn">☰</button>

            <!-- page content -->
        </main>

    </div>


    // ── CSS ─────────────────────────────────────────────────

    // Desktop layout — sidebar and main sit side by side
    .layout {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 240px;
        flex-shrink: 0;
        background: #333;
        position: sticky;
        top: 0;
        height: 100vh;
    }

    .main-content {
        flex: 1;
        min-width: 0;          // prevents flex child from overflowing
    }

    // Hamburger — hide on desktop, show on mobile
    .hamburger {
        display: none;
        background: none;
        border: none;
        font-size: 1.4rem;
        cursor: pointer;
    }

    // Overlay backdrop
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;              // shorthand for top/right/bottom/left: 0
        background: rgba(0, 0, 0, 0.4);
        z-index: 99;
    }
    .sidebar-overlay.open { display: block; }


    @media (max-width: 768px) {

        // Sidebar becomes fixed and slides off-screen by default
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            transform: translateX(-100%);          // hidden to the left
            transition: transform 0.25s ease;
        }

        // .open slides it into view
        .sidebar.open {
            transform: translateX(0);
        }

        .hamburger { display: block; }             // show hamburger
    }


    // ── JavaScript ──────────────────────────────────────────

    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const hamburger = document.getElementById('hamburgerBtn');

    function openSidebar()  { sidebar.classList.add('open'); overlay.classList.add('open'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); }

    hamburger.addEventListener('click', () =>
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar()
    );

    overlay.addEventListener('click', closeSidebar);

    // Close when a nav link is tapped on mobile
    document.querySelectorAll('.nav-item').forEach(item =>
        item.addEventListener('click', closeSidebar)
    );

*/


/* ============================================================
   4. STICKY FOOTER
   ─────────────────────────────────────────────────────────
   Use when: a page with little content should still push
   the footer to the bottom of the viewport.

   IMPORTANT: if you also use an off-canvas sidebar on the
   same page, the body flex conflicts with the sidebar flex.
   Fix: add a class like .admin-body { display: block } to
   override body flex for pages that use a sidebar layout,
   then let the sidebar wrapper handle its own flex.
============================================================ */

/*

    // ── CSS ─────────────────────────────────────────────────

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;               // main grows to fill available space
    }

    footer {
        // no special rules needed — it naturally sits at the bottom
    }


    // ── Conflict fix for sidebar pages ───────────────────────
    // If a page uses its own flex layout (e.g. sidebar + main),
    // cancel body flex for that page:

    .sidebar-page-body {
        display: block;        // overrides body { display: flex }
    }

*/


/* ============================================================
   5. MOBILE TABLES
   ─────────────────────────────────────────────────────────
   Use when: a data table has too many columns to fit on a
   small screen. The table scrolls horizontally inside its
   container instead of breaking the page layout.
============================================================ */

/*

    // ── CSS ─────────────────────────────────────────────────

    .table-wrapper {
        overflow-x: auto;          // enables horizontal scroll on the container
        -webkit-overflow-scrolling: touch;   // smooth scroll on iOS
    }

    .my-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;          // table never shrinks below this — it scrolls instead
    }


    // ── Or apply directly to the card that holds the table ──

    @media (max-width: 768px) {
        .admin-card {
            overflow-x: auto;
        }
        .admin-table {
            min-width: 480px;
        }
    }

*/


/* ============================================================
   6. FLEX WRAPPING
   ─────────────────────────────────────────────────────────
   Use when: a horizontal row of items should wrap onto the
   next line on small screens without needing a media query.
   Let flex-wrap do the work automatically.
============================================================ */

/*

    // ── CSS ─────────────────────────────────────────────────

    .tag-row {
        display: flex;
        flex-wrap: wrap;           // items wrap naturally when they run out of space
        gap: 0.5rem;
    }

    // For a nav row that should stack on mobile:
    .nav-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
    }

    @media (max-width: 480px) {
        .nav-row {
            flex-direction: column;    // force vertical stacking on phone
            align-items: flex-start;
        }
    }

*/


/* ============================================================
   7. RESPONSIVE IMAGES
   ─────────────────────────────────────────────────────────
   Use when: images might overflow their containers on small
   screens, or need to maintain a fixed aspect ratio.
============================================================ */

/*

    // ── Prevent images from overflowing ─────────────────────
    img {
        max-width: 100%;
        height: auto;              // maintain aspect ratio
        display: block;
    }

    // ── Fixed aspect ratio container (e.g. listing card image) ──
    .img-wrap {
        aspect-ratio: 4 / 3;      // or 16/9, 1/1, etc.
        overflow: hidden;
        border-radius: 0.5rem;
    }

    .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;         // crop to fill without stretching
    }

    // ── Responsive hero image ────────────────────────────────
    .hero-img {
        width: 100%;
        height: 420px;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .hero-img { height: 240px; }
    }

*/


/* ============================================================
   8. COMMON MISTAKES
   ─────────────────────────────────────────────────────────
   These are easy errors that break responsive layouts.
============================================================ */

/*

    ✗ WRONG — fixed widths break small screens:
    ────────────────────────────────────────────
    .card { width: 400px; }           // overflows on phone
    .modal { width: 600px; }

    ✓ CORRECT — use max-width instead:
    ──────────────────────────────────
    .card { width: 100%; max-width: 400px; }
    .modal { width: 90%; max-width: 600px; }


    ✗ WRONG — body flex conflicts with sidebar flex:
    ─────────────────────────────────────────────────
    // body { display: flex; flex-direction: column } on every page,
    // then a sidebar page also tries to use display:flex on its wrapper.
    // Result: sidebar renders as a column instead of a row.

    ✓ CORRECT — override body display for sidebar pages:
    ─────────────────────────────────────────────────────
    .sidebar-body { display: block; }


    ✗ WRONG — forgetting min-width: 0 on flex children:
    ─────────────────────────────────────────────────────
    .main { flex: 1; }   // flex child can still overflow its container

    ✓ CORRECT:
    ───────────
    .main { flex: 1; min-width: 0; }   // forces child to respect container width


    ✗ WRONG — using px for font sizes (ignores user zoom):
    ────────────────────────────────────────────────────────
    p { font-size: 14px; }

    ✓ CORRECT — use rem (scales with root font size):
    ──────────────────────────────────────────────────
    p { font-size: 0.875rem; }   // 14px equivalent at default root 16px


    ✗ WRONG — setting Content-Type for FormData (breaks multipart):
    ─────────────────────────────────────────────────────────────────
    // See api_reference.php section 3 for this one.

*/
