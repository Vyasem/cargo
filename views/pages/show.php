<table>
    <thead>
    <tr>
        <td>Контейнер</td>
        <td>Клиент</td>
        <td>Менеджер</td>
        <td>Дата прибытия</td>
        <td>Статус</td>
        <td>Назначить исполнителем</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $ikey => $ival){?>
         <tr>
             <?php foreach($ival as $key => $val){?>
                <?php if($key == 'manager_id' && $val == 0) $val = 'Не назначен'?>
                <?php if($key == 'id') continue;?>
                <td><?=$val?></td>
            <?php }?>
                <td><a href="/?manager_cargo=<?=$data[$ikey]['id']?>">Назначить</a></td>
         </tr>
    <?php }?>
    </tbody>
</table>