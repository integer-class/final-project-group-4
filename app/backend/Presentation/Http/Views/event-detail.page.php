<?php

use Primitives\Models\Event;
use Primitives\Models\RoleName;
use Primitives\Models\User;

/** @var Event $event */
/** @var User[] $approvers */

$prefix = $_SESSION['user']['role'] == RoleName::Administrator ? 'admin' : 'approver';
?>
<div class="container mx-auto form-container">
    <div class="cover-image-container">
        <img class="cover-image" src="/uploaded_images/room/<?= $event->room->image ?>"
             alt="<?= $event->room->name ?>"/>
        <div class="white-shadow"></div>
        <a class="back-button" href="/<?= $prefix ?>/schedule">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="material-symbols:arrow-back">
                    <path
                            id="Vector" d="M15.65 26L26.85 37.2L24 40L8 24L24 8L26.85 10.8L15.65 22H40V26H15.65Z"
                            fill="white"
                    />
                </g>
            </svg>
        </a>
        <div class="room-detail">
            <h1><?= $event->room->code ?>: <?= $event->room->name ?></h1>
            <div class="d-flex text-capitalize" style="gap: 1rem">
                <p><strong>Capacity:</strong> <?= $event->room->capacity ?></p>
                <p><strong>Floor:</strong> <?= $event->room->floor ?></p>
                <p><strong>Side:</strong> <?= $event->room->side ?></p>
            </div>
        </div>
    </div>
    <form class="bordered-container">
        <h1 class="form-title">Event Details</h1>
        <div class="input-container">
            <div class="event-detail-item">
                <span>Full Name</span>
                <span><?= $event->pic->fullname ?></span>
            </div>
            <div class="event-detail-item">
                <span>Event Name</span>
                <span><?= $event->title ?></span>
            </div>
            <div class="event-detail-item">
                <span>Starts At</span>
                <span><?= $event->startsAt->format('D, d M Y H:i:s') ?></span>
            </div>
            <div class="event-detail-item">
                <span>Ends At</span>
                <span><?= $event->endsAt->format('D, d M Y H:i:s') ?></span>
            </div>
            <div class="event-detail-item event-description">
                <span>Event Details</span>
                <p>
                    <?= $event->description ?>
                </p>
            </div>
            <!-- Dynamic Form to add approver using a dropdown select -->
            <div class="event-approver">
                <span>Approver</span>
                <select name="approver" id="approver" class="input-text">
                    <?php foreach ($approvers as $approver): ?>
                        <option value="<?= $approver->id ?>"><?= $approver->fullname ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row mx-auto" style="gap: 1rem; max-width: 30rem">
                <button class="col button danger-button">Reject</button>
                <button class="col button primary-button">Approve</button>
            </div>
        </div>
    </form>
</div>
