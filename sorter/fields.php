<?php
    $sql = 'SELECT * FROM `hashtags`';
    $res = mysqli_query($connect, $sql);
?>
<div class="container">
    <form action="index.php" method="POST">
        <input type="hidden" name="add-field">
        <h3>Создание области знаний</h3>
        <div class="form-group">
            <label for="field-name">Название области знаний</label>
            <input required type="text" class="form-control" id="field-name" name="field-name">
        </div>

        <div class="form-group">
            <label for="description">Описание области знаний</label>
            <textarea required class="form-control" id="description" rows="3" name="description"></textarea>
        </div>
        <div class="form-group">
        <?php
            while ($row = $res->fetch_assoc()) {
                echo '<input type="checkbox" class="form-check-input inp_fx" id="hashtag_' . $row['id'] . '" name="hashtags[]" value="' . $row['name'] . '">';
                echo '<label class="inp_fx fffix" for="hashtag_' . $row['id'] . '">' . $row['name'] . '</label><br>';
            }
        ?>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Создать область знаний</button>
    </form>
</div>
<div class="container">
    <form action="index.php" method="POST">
        <input type="hidden" name="update-field">

        <h3>Редактирование области знаний</h3>
        <div class="container">
            <select name="field_id" id="field_id" class="form-control fix">
                <?php
                    $sql = "SELECT `id`, `name` FROM `Field`";
                    $res = mysqli_query($connect, $sql);
                    while ($row = $res->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                ?>
            </select>
        </div>

        <div class="container" id='hashtags'>
            <?php
                $sql = "SELECT `id`, `name` FROM `hashtags`";
                $res = mysqli_query($connect, $sql);
                while ($row = $res->fetch_assoc()) {
                    echo
                        '<div class="form-check ffffix">
                            <input class="form-check-input update-checkbox ffix" name="hashtags[]" type="checkbox" id="inlineCheckbox' . $row['id'] . '" value="' . $row['name'] . '">
                            <label class="form-check-label ffix" for="inlineCheckbox' . $row['id'] . '">' . $row['name'] . '</label>
                        </div>';
                }
            ?>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Изменить область знаний</button>
    </form>
</div>
<script>
    let fieldId = document.getElementById('field_id');
    let checkboxes = document.querySelectorAll('#hashtags .form-check-input')
    function makeRequest() {
        fetch('list_tags.php', {
            method: 'POST',
            body: JSON.stringify({ fieldId: fieldId.value }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                let selectedHashtags = [];
                data.forEach(hashtag => {
                    selectedHashtags.push(hashtag);
                });
                checkboxes.forEach(checkbox => {
                    if (selectedHashtags.some(hashtag => hashtag.name === checkbox.value)) {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                });
            });
    };
    makeRequest();
    fieldId.addEventListener('change', makeRequest);
</script>