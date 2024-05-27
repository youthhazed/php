<!doctype html>
<html lang="en">

<head>
    <title>Course work</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Set active page -->
                    <?php if (isset($_GET['p']) && $_GET['p'] == 'tags')
                        echo '<li class="nav-item active">'; ?>
                    <a class="nav-link" href="?p=tags">Хэштеги</a>
                    </li>
                    <?php if (isset($_GET['p']) && $_GET['p'] == 'posts')
                        echo '<li class="nav-item active">'; ?>
                    <a class="nav-link" href="?p=posts">Посты</a>
                    </li>
                    <?php if (isset($_GET['p']) && $_GET['p'] == 'channels')
                        echo '<li class="nav-item active">'; ?>
                    <a class="nav-link" href="?p=channels">Каналы</a>
                    </li>
                    <?php if (isset($_GET['p']) && $_GET['p'] == 'fields')
                        echo '<li class="nav-item active">'; ?>
                    <a class="nav-link" href="?p=fields">Область знаний</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>