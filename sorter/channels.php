<?php

$sql = 'SELECT * FROM `Channel`';
$res = mysqli_query($connect, $sql);

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Канал</th>
            <th scope="col">Описание</th>
            <th scope="col">Like/Dislike</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <th scope="row"><?= $row['id']; ?></th>
                <td><?= $row['name']; ?></td>
                <td><?= $row['Description']; ?></td>
                <td><?= $row['fav'] == 1 ? 'like' : 'dislike'; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="container">
    <form action="index.php" method="POST">
        <input type="hidden" name="add-channel">
        <div class="form-group">
            <label for="name">Название</label>
            <input required type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="description">Описание канала</label>
            <textarea required class="form-control" id="description" rows="3" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="fav">Fav</label>
            <select class="form-control" id="fav" name="fav">
                <option value="1">like</option>
                <option value="0">dislike</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Добавить</button>
    </form>
</div>