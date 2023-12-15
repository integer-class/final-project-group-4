<div class="d-flex w-100 h-100">
    <?php

    use Primitives\Models\Room;

    require_once __DIR__ . '/Components/sidenav.component.php';
    ?>
    <main class="dashboard-main">
        <?php
        require_once __DIR__ . '/Components/topbar.component.php';
        ?>
        <div class="container mx-auto">
            <div class="cover-image-container">
                <div class="back-button">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="material-symbols:arrow-back">
                            <path id="Vector" d="M15.65 26L26.85 37.2L24 40L8 24L24 8L26.85 10.8L15.65 22H40V26H15.65Z"
                                  fill="white"/>
                        </g>
                    </svg>
                </div>
                <?php
                /** @var Room $room */
                ?>
                <h1><?= $room->code ?>: <?= $room->name ?></h1>
                <p>Capacity: <?= $room->capacity ?></p>
                <p>Floor: <?= $room->floor ?></p>
                <p>Side: <?= $room->side ?></p>
            </div>
        </div>
    </main>
</div>
