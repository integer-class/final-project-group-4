<div class="d-flex w-100 h-100">
    <?php

    use Primitives\Models\Room;

    /** @var Room[] $rooms */

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

            <table class="table" id="rooms-table">
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
                <?php foreach ($rooms as $room) { ?>
                    <tr>
                        <td><?= $room->code ?></td>
                        <td><?= $room->name ?></td>
                        <td><?= $room->capacity ?></td>
                        <td><?= $room->floor ?></td>
                        <td><?= $room->side ?></td>
                        <td class="text-center d-flex justify-content-center">
                            <button
                                    type="button" class="button button-delete"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteRoomModal"
                                    data-bs-room-id="<?= $room->id ?>"
                            >
                                Delete
                            </button>
                            <a href="/admin/room?id=<?= $room->id ?>" class="button button-edit">Edit</a>
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
        id="deleteRoomModal"
        tabindex="-1"
        aria-labelledby="delete_room_modal_label"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteRoomModalLabel">Are you sure?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    This action is irreversible. Are you sure you want to delete this room? Any reservations made for
                    this room will be deleted as well. Please confirm.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="form" action="/rooms" method="post">
                    <button type="button" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        const table = new DataTable('#rooms-table', {
            scrollY: '38rem'
        });

        const deleteRoomModal = document.getElementById('deleteRoomModal')
        deleteRoomModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const roomId = button.getAttribute('data-bs-room-id')
            const modalForm = deleteRoomModal.querySelector('#form')
            modalForm.action = `/rooms?id=${roomId}&_method=DELETE`
        })
    })
</script>
