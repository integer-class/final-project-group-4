<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['__layout_title__'] ?> | Room Tenant System</title>

    <!--  custom fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Open+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- custom css -->
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous">
    <link rel="stylesheet" href="/css/app.style.css">

    <!--  load custom css according to route name, if any  -->
    <?php
    \Presentation\Http\Helpers\View::autoloadCss();
    ?>
</head>

<body class="h-100">

