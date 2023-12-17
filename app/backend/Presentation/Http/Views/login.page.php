<div class="h-100 d-flex justify-content-center align-items-center">
    <form
            method="post" action="/login"
            class="form d-flex flex-column align-items-center justify-content-center bg-white p-4"
            data-ajax="false"
    >
        <img src="/jti-logo.png" alt="jti_logo" class="mb-4">
        <h1 class="mb-4 app-title">Room Reservation</h1>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="w-100 alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_message'] ?>
                <?php unset($_SESSION['error_message']) ?>
            </div>
        <?php endif; ?>
        <div class="mb-4 w-100">
            <label for="username-input" class="form-label">Username / Email / Registration Number</label>
            <input type="text" class="input-text" id="username-input" name="username">
        </div>
        <div class="mb-4 w-100">
            <label for="password-input" class="form-label">Password</label>
            <input type="password" class="input-text" id="password-input" name="password">
        </div>
        <button type="submit" class="btn mt-4 primary-button">Login</button>
    </form>
</div>
