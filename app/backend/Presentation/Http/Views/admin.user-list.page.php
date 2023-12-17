<?php

use Primitives\Models\User;

/** @var User[] $users */
?>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="list-title">List of All Users</h1>
        </div>
        <div class="col-6">
            <button type="button" class="button button-add float-end">+ Add New User</button>
        </div>
    </div>

    <table class="table" id="users-table">
        <thead>
        <tr>
            <th scope="col" class="name-row">Email</th>
            <th scope="col">NIM</th>
            <th scope="col">Fullname</th>
            <th scope="col">Study Program</th>
            <th scope="col">Role</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?= $user->email ?></td>
                <td><?= $user->registrationNumber ?></td>
                <td><?= $user->fullname ?></td>
                <td><?= $user->studyProgram?->name ?? '-' ?></td>
                <td><?= $user->role->name ?></td>
                <td class="text-center">
                    <?php if ($_SESSION['user']['id'] !== $user->id) { ?>
                        <button
                                type="button" class="button button-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal"
                                data-bs-room-id="<?= $user->id ?>"
                        >
                            Delete
                        </button>
                    <?php } ?>
                    <button type="button" class="button button-edit">Edit</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</main>
</div>

<div
        class="modal fade"
        id="deleteUserModal"
        tabindex="-1"
        aria-labelledby="deleteUserModalLabel"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteUserModalLabel">Delete this user?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    This action is irreversible. Are you sure you want to delete this user? Any reservations made by
                    this user will be deleted as well. Please confirm.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="form" action="/users" method="post">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        const table = new DataTable('#users-table', {
            scrollY: '38rem'
        });

        const deleteUserModal = document.getElementById('deleteUserModal')
        deleteUserModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const roomId = button.getAttribute('data-bs-room-id')
            const modalForm = deleteUserModal.querySelector('#form')
            modalForm.action = `/users?id=${roomId}&_method=DELETE`
        })
    })
</script>
