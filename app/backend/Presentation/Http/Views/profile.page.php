<?php

use Primitives\Models\User;

/** @var User $user */
?>

<div class="container mx-auto form-container">
    <div class="cover-image-container">
        <a class="back-button" href="/admin/room-list">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="material-symbols:arrow-back">
                    <path
                            id="Vector" d="M15.65 26L26.85 37.2L24 40L8 24L24 8L26.85 10.8L15.65 22H40V26H15.65Z"
                            fill="white"
                    />
                </g>
            </svg>
        </a>
    </div>
    <form class="bordered-container">
        <h1 class="form-title">Edit User Details</h1>
        <div class="input-container">
            <div class="mb-4 w-100">
                <label for="name-input" class="form-label">Full Name</label>
                <input type="text" class="input-text" id="name-input" name="name" value="<?= $user['fullname'] ?>">
            </div>
            <div class="mb-4 w-100">
                <label for="registration-number-input" class="form-label">Registration Number</label>
                <input
                        type="text"
                        class="input-text"
                        id="registration-number-input"
                        name="registration_number"
                        value="<?= $user['registrationNumber'] ?>"
                        readonly
                >
            </div>
            <div class="mb-4 w-100">
                <label for="code-input" class="form-label">Email</label>
                <input type="text" class="input-text" id="code-input" name="code" value="<?= $user['email'] ?>">
            </div>
            <div class="row">
                <div class="col mb-4 w-100">
                    <label for="new-password-input" class="form-label">New Password</label>
                    <input type="password" class="input-text" id="new-password-input" name="new_password">
                </div>
                <div class="col mb-4 w-100">
                    <label for="confirm-new-password-input" class="form-label">Confirm New Password</label>
                    <input
                            type="password" class="input-text" id="confirm-new-password-input"
                            name="confirm_new_password"
                    >
                </div>
                <div class="col mb-4 w-100">
                    <label for="current-password-input" class="form-label">Current Password</label>
                    <input type="password" class="input-text" id="current-password-input" name="current_password">
                </div>
            </div>
            <div class="row mx-auto" style="gap: 1rem; max-width: 30rem">
                <button class="col button secondary-button">Cancel</button>
                <button class="col button primary-button">Save</button>
            </div>
        </div>
    </form>
</div>
