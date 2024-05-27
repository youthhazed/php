<?php
$sql = 'SELECT * FROM `Channel`';
$res = mysqli_query($connect, $sql);
?>

<div class="container">
    <form action="index.php" method="POST">
        <input type="hidden" name="add-post">
        <div class="form-group">
            <label for="description">Текст поста</label>
            <textarea required class="form-control" id="description" rows="5" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="channel">Канал</label>
            <select class="form-control" id="channel" name="channel">
                <?php while ($row = mysqli_fetch_assoc($res)): ?>
                    <option><?= $row['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Написать пост</button>
    </form>
</div>