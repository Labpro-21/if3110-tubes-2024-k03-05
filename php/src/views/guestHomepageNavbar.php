<!-- navbar.php -->
<header>
    <nav>
        <div class="logo-search">
            <button class="menu-toggle" aria-label="Toggle menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4 5h16v2H4zm0 6h16v2H4zm0 6h16v2H4z"/>
                </svg>
            </button>
            <a href="homepage.html"><img src="../public/images/logo.webp" alt="Logo"></a>
            <div class="search-bar">
                <input type="search" name="search" placeholder="Search jobs" class="form-control" autocomplete="off"
                       value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       id="searchInput"
                />
            </div>
        </div>
        <div class="nav-links">
            <ul>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-navbar" width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1"/>
                    </svg>
                    <a href="/">Home</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-navbar" width="28px" height="28px" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.11 0-2 .89-2 2v4h2V5h14v14H5v-4H3v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-8.92 12.58L11.5 17l5-5l-5-5l-1.42 1.41L12.67 11H3v2h9.67z"/></svg>
                    <a href="/login">Login</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-navbar" width="28px" height="28px" viewBox="0 0 24 24"><path fill="currentColor" d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4"/></svg>
                    <a href="/register">Register</a>
                </li>
            </ul>
        </div>
    </nav>
    <script src="../public/JS/navbarResponsif.js"></script>
</header>