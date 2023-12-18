<?php

use Primitives\Models\User;

/** @var User $user */
?>

<div class="container mx-auto form-container">
    <div class="cover-image-container">
        <a class="back-button" href="/admin/user-list">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="material-symbols:arrow-back">
                    <path
                            id="Vector" d="M15.65 26L26.85 37.2L24 40L8 24L24 8L26.85 10.8L15.65 22H40V26H15.65Z"
                            fill="#020617"
                    />
                </g>
            </svg>
        </a>
    </div>
    <form class="bordered-container" method="POST" action="/users">
        <h1 class="form-title">Add New User</h1>
        <div class="input-container">
            <div class="mb-4 image-input">
                <svg id="camera-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#888888"
                          d="M12 18q2.075 0 3.538-1.462Q17 15.075 17 13q0-2.075-1.462-3.538Q14.075 8 12 8Q9.925 8 8.463 9.462Q7 10.925 7 13q0 2.075 1.463 3.538Q9.925 18 12 18Zm0-2q-1.25 0-2.125-.875T9 13q0-1.25.875-2.125T12 10q1.25 0 2.125.875T15 13q0 1.25-.875 2.125T12 16Zm6-6q.425 0 .712-.288Q19 9.425 19 9t-.288-.713Q18.425 8 18 8t-.712.287Q17 8.575 17 9t.288.712Q17.575 10 18 10ZM4 21q-.825 0-1.412-.587Q2 19.825 2 19V7q0-.825.588-1.412Q3.175 5 4 5h3.15L8.7 3.325q.15-.15.337-.238Q9.225 3 9.425 3h5.15q.2 0 .388.087q.187.088.337.238L16.85 5H20q.825 0 1.413.588Q22 6.175 22 7v12q0 .825-.587 1.413Q20.825 21 20 21Z"/>
                </svg>
                <img id="image-preview" src="" alt="Image Preview">
                <svg id="edit-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="white"
                          d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8.925l-2 2H5v14h14v-6.95l2-2V19q0 .825-.587 1.413T19 21zm4-6v-4.25l9.175-9.175q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4q0 .375-.137.738t-.438.662L13.25 15zM21.025 4.4l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/>
                </svg>
                <input id="image-input-file" type="file" name="image" accept="image/*">
            </div>
            <div class="mb-4 w-100">
                <label for="name-input" class="form-label">Full Name</label>
                <input type="text" class="input-text" id="name-input" name="fullname">
            </div>
            <div class="mb-4 w-100">
                <label for="registration-number-input" class="form-label">Registration Number</label>
                <input
                        type="text"
                        class="input-text"
                        id="registration-number-input"
                        name="registration_number"
                        min="10"
                        max="10"
                >
            </div>
            <div class="mb-4 w-100">
                <label for="code-input" class="form-label">Email</label>
                <input type="text" class="input-text" id="code-input" name="code">
            </div>
            <div class="row">
                <div class="col mb-4 w-100">
                    <label for="new-password-input" class="form-label">Password</label>
                    <input type="password" class="input-text" id="new-password-input" name="new_password">
                </div>
                <div class="col mb-4 w-100">
                    <label for="confirm-new-password-input" class="form-label">Confirm Password</label>
                    <input type="password" class="input-text" id="confirm-new-password-input"
                           name="confirm_new_password">
                </div>
            </div>
            <div class="row mx-auto" style="gap: 1rem; max-width: 30rem">
                <button class="col button secondary-button">Cancel</button>
                <button class="col button primary-button">Save</button>
            </div>
        </div>
    </form>
</div>


<script>
    $(function () {
        const fileInputContainer = $('.image-input');
        const fileInput = $('#image-input-file');
        const imagePreview = $('#image-preview');
        const cameraIcon = $('#camera-icon');

        fileInput.on("click", function (e) {
            e.stopPropagation();
        });

        fileInput.on("change", function (e) {
            const file = e.target.files[0];

            if (file === null || file === undefined) {
                imagePreview.css('display', 'none');
                cameraIcon.css('display', 'block');
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.attr('src', e.target.result);
                imagePreview.css('display', 'block');
                cameraIcon.css('display', 'none');
            };

            reader.readAsDataURL(file);
        });

        fileInputContainer.on("click", function () {
            fileInput.click();
        });
    });
</script>