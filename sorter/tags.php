<div class="container">
    <form action="index.php" method="GET">
        <h4>Выберите области знаний</h4>
        <div class="container">
            <select name="field_id" id="field_id" class="form-control fix">
                <?php
                if (isset($_GET['field_id'])) {
                    $field_id = $_GET['field_id'];
                }
                $sql = "SELECT `id`, `name` FROM `Field`";
                $res = mysqli_query($connect, $sql);
                while ($row = $res->fetch_assoc()) {
                    if ($field_id === $row['id']) {
                        echo '<option value="' . $row['id'] . '" selected>' . $row['name'] . '</option>';
                    } else {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-primary mb-3">Отфильтровать посты</button>
    </form>
</div>

<div class="container">
    <?php
    $field_id = 1;
    $descriptionsAndChannels = [];
    if (isset($_GET['field_id'])) {
        $field_id = $_GET['field_id'];
    }
    $sql = "SELECT `hash_id` FROM `hash_connect` WHERE `field_id` = '$field_id'";
    $res = mysqli_query($connect, $sql);
    $hash_ids = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $hash_ids[] = $row['hash_id'];
    }
    if (!empty($hash_ids)) {
        $hash_ids_string = implode(',', $hash_ids);
        $sql = "SELECT p.Description, c.name AS channel_name FROM SMS p JOIN Channel c ON p.channel_id = c.id WHERE p. 	hashtag_id  IN ($hash_ids_string)";
        $res = mysqli_query($connect, $sql);

        while ($row = mysqli_fetch_assoc($res)) {
            $descriptionsAndChannels[] = [
                'description' => $row['Description'],
                'channel_name' => $row['channel_name']
            ];
        }
    }
    foreach ($descriptionsAndChannels as $item) {
        echo "<hr>";
        echo "<h5>{$item['channel_name']}</h5>";
        echo "<p>{$item['description']}</p>";
    }
    ?>
</div>