<div class="d-flex w-100 h-100">
    <?php

    use Primitives\Models\User;

    require_once __DIR__ . '/Components/sidenav.component.php';
    ?>
    <main class="dashboard-main">
        <?php
        require_once __DIR__ . '/Components/topbar.component.php';
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
                <?php
                /** @var User $user */
                foreach ($data['users'] as $user) {
                    ?>
                    <tr>
                        <td><?= $user->email ?></td>
                        <td><?= $user->registrationNumber ?></td>
                        <td><?= $user->fullname ?></td>
                        <td><?= $user->studyProgram->name ?></td>
                        <td><?= $user->role->name->value ?></td>
                        <td class="text-center">
                            <button type="button" class="button button-delete">Delete</button>
                            <button type="button" class="button button-edit">Edit</button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<script>
    $(function () {
        const table = new DataTable('#users-table', {
            scrollY: '38rem'
        });
    })
</script>
