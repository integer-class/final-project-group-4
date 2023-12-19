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
            <div class="button-group">
                <input type="password" class="input-text input-text-left" id="password-input" name="password">
                <button id="toggle-password" class="button-small button-right" type="button">
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="display: none">
                        <g fill="none" stroke="#888888" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M21.257 10.962c.474.62.474 1.457 0 2.076C19.764 14.987 16.182 19 12 19c-4.182 0-7.764-4.013-9.257-5.962a1.692 1.692 0 0 1 0-2.076C4.236 9.013 7.818 5 12 5c4.182 0 7.764 4.013 9.257 5.962"/>
                            <circle cx="12" cy="12" r="3"/>
                        </g>
                    </svg>
                    <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="#888888" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M6.873 17.129c-1.845-1.31-3.305-3.014-4.13-4.09a1.693 1.693 0 0 1 0-2.077C4.236 9.013 7.818 5 12 5c1.876 0 3.63.807 5.13 1.874"/>
                            <path d="M14.13 9.887a3 3 0 1 0-4.243 4.242M4 20L20 4M10 18.704A7.124 7.124 0 0 0 12 19c4.182 0 7.764-4.013 9.257-5.962a1.694 1.694 0 0 0-.001-2.078A22.939 22.939 0 0 0 19.57 9"/>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
        <button type="submit" class="btn mt-4 button primary-button">Login</button>
    </form>
</div>

<script>
    $(function () {
        const togglePassword = $('#toggle-password');
        const passwordInput = $('#password-input');
        const eyeOpen = $('#eye-open');
        const eyeClosed = $('#eye-closed');

        togglePassword.on('click', function () {
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                eyeOpen.show();
                eyeClosed.hide();
            } else {
                passwordInput.attr('type', 'password');
                eyeClosed.show();
                eyeOpen.hide();
            }
        });
    });
</script>