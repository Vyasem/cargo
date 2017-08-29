<form id="edit_cargo" action="" method="post" enctype="multipart/form-data">
    <h1>Изменить параметры</h1>
    <input type="hidden" name="EDIT_CARGO[ID]" value="<?=$data[0][0]['id']?>">
    <div>
        <label for="select_status">Измените статус</label>
        <select name="EDIT_CARGO[STATUS]" id="select_status">
            <?php foreach($data[1] as $key => $val){
                ($data[0][0]['status'] == $val) ? $selected = 'selected' : $selected = '';
            ?>
                <option <?=$selected?> value="<?=$val?>"><?=$val?></option>
            <?php }?>
        </select>
    </div>
    <div>
        <label for="input_edit">Измените дату</label>
        <input type="date" name="EDIT_CARGO[DATE]" id="input_edit" value="<?=$data[0][0]['delivery_date']?>">
    </div>
    <div>
        <button>Отправить</button>
    </div>
</form>