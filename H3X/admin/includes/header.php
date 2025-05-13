<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'H3X'; ?></title>
    <link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
            background-color: #F7F7F8;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background-color: #1c1c1e;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #333;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .table-container {
            max-height: 70vh;
            overflow-y: auto;
        }
        .table thead {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1;
        }
    </style>
</head>
<body>
