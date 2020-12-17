<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li>
                    <span class="navbar-brand mb-0 h1">KOMIK</span>
                </li>
                <li>
                    <a class="nav-link active" href="/">Home</a>
                </li>
                <li>
                    <a class="nav-link active" href="/komik">Daftar Komik</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (logged_in()) : ?>
                    <li>
                        <a class="nav-link active" href="/logout"> Logout</a>
                    </li>
                <?php else : ?>
                    <li>
                        <a class="nav-link active" href="/login"> Login</a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>