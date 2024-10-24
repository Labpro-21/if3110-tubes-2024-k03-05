<!-- navbar.php -->
<header>
    <nav>
        <div class="logo-search">
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1"/>
                    </svg>
                    <a href="/dashboard">Home</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m19.65 20.35l.7-.7l-1.85-1.85V15h-1v3.2zM10 6h4V4h-4zm8 17q-2.075 0-3.537-1.463T13 18t1.463-3.537T18 13t3.538 1.463T23 18t-1.463 3.538T18 23M4 21q-.825 0-1.412-.587T2 19V8q0-.825.588-1.412T4 6h4V4q0-.825.588-1.412T10 2h4q.825 0 1.413.588T16 4v2h4q.825 0 1.413.588T22 8v4.275q-.875-.625-1.9-.95T18 11q-2.9 0-4.95 2.05T11 18q0 .775.163 1.538T11.675 21z"/>
                    </svg>
                    <a href="/riwayatLamaran">Jobs</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24"><path fill="currentColor" d="M5 22a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3h-2V4H6v16h12v-2h2v3a1 1 0 0 1-1 1zm13-6v-3h-7v-2h7V8l5 4z"/></svg>
                    <a href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</header>