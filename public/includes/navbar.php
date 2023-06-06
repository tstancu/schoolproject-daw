<!-- navbar.php -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_role = null;

if (isset($_SESSION['role_id'])) $user_role = $_SESSION['role_id'];

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
    <img src="../img/transparent-rocket.png" alt="Logo" width="auto" height="35" class="d-inline-block align-top">
    <span style="font-family: 'Lucida Console', monospace;">sci-fi short</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
            </li>
            <?php if ($user_role > 1) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="submit-article.php">Edit</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.bundle.min.js"></script> -->

<script>
    // Initialize the navbar functionality
    document.addEventListener("DOMContentLoaded", function () {
        var navToggler = document.querySelector(".navbar-toggler");
        var navbar = document.querySelector(".navbar-collapse");

        navToggler.addEventListener("click", function () {
            navbar.classList.toggle("show");
        });
    });
</script>