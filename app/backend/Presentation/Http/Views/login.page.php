<div class="h-100 d-flex justify-content-center align-items-center">
    <form method="post" action="/login"
          class="form d-flex flex-column align-items-center justify-content-center bg-white p-4"
          data-ajax="false">
        <img src="/jti-logo.png" alt="jti_logo" class="mb-4">
        <h1 class="mb-4 app-title">Room Reservation</h1>
        <div class="mb-4 w-100">
            <label for="username-input" class="form-label">Email address</label>
            <input type="email" class="input-text" id="username-input" name="username">
        </div>
        <div class="mb-4 w-100">
            <label for="password-input" class="form-label">Password</label>
            <input type="password" class="input-text" id="password-input" name="password">
        </div>
        <button type="submit" class="btn mt-4 primary-button">Login</button>
    </form>
</div>
