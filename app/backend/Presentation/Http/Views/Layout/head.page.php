<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $__layout_title__ ?> | Room Tenant System</title>

    <!--  custom fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap"
            rel="stylesheet"
    >

    <!-- custom css -->
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
    >
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/b-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.style.css">


    <!-- custom javascript -->
    <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
            defer
    ></script>
    <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
            defer
    ></script>
    <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"
            defer
    ></script>
    <script
            src="https://cdn.datatables.net/v/bs5/dt-1.13.8/b-2.4.2/r-2.5.0/datatables.min.js"
            defer
    ></script>
    <script>
        // execute all functions after page load, this is needed since jquery is loaded using the defer attribute
        const executeLater = [];

        function $(func) {
            executeLater.push(func);
        }

        document.addEventListener('DOMContentLoaded', function () {
            console.log("DOM loaded");
            for (let c = 0; c < executeLater.length; c++) {
                executeLater[c]();
            }
        })
    </script>

    <!--  load custom css according to route name, if any  -->
    <?php
    \Presentation\Http\Helpers\View::autoloadCss();
    ?>
</head>

<body class="h-100">

<?php if ($withLayout): ?>
<div class="d-flex w-100 h-100">
    <?php
    require_once __DIR__ . '/../Components/sidenav.component.php';
    ?>
    <main class="dashboard-main">
        <?php
        require_once __DIR__ . '/../Components/topbar.component.php';
        ?>
<?php endif; ?>
