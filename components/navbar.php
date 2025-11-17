<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="#">FlightBooking</a>

        <div class="collapse navbar-collapse">

            <ul class="navbar-nav ms-auto">

                <?php if (!isset($_SESSION['user_id'])):?>
                <li class="nav-item">
                    <a class="nav-link" href="../auth.php">Login</a>
                </li>
                <?php else:?>
                <li class="nav-item">
                    <span class="nav-link">Hi, <?= $_SESSION['name'] ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-light text-primary ms-2 px-3" id="logout-button"
                        href="../logout.php">Logout</a>
                </li>
                <?php endif;?>

            </ul>

        </div>

    </div>
</nav>
<style>
#logout-button {
    background-color: aliceblue !important;
}
</style>