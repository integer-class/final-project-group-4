<div class="d-flex w-100 h-100">
    <?php

    use Primitives\Models\Room;

    require_once __DIR__ . '/Components/sidenav.component.php';
    ?>
    <main class="dashboard-main">
        <?php
        require_once __DIR__ . '/Components/topbar.component.php';
        ?>
        <div class="container mt-5">
            <div class="row mb-4">
                <div class="col-6">
                    <h1 class="list-title">List of All Rooms</h1>
                </div>
                <div class="col-6">
                    <button type="button" class="button button-add float-end">+ Add New Room</button>
                </div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col" class="name-row">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Capacity</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Side</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /** @var Room $room */
                foreach ($data['rooms'] as $room) {
                    ?>
                    <tr>
                        <td><?= $room->code ?></td>
                        <td><?= $room->name ?></td>
                        <td><?= $room->capacity ?></td>
                        <td><?= $room->floor ?></td>
                        <td><?= $room->side ?></td>
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
