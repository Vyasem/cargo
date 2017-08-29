<table>
    <thead>
    <tr>
        <?php foreach($data[0] as $key => $val){?>
            <td><?=$val?></td>
        <?php }?>
    </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach($data[1] as $ikey => $ival){?>
                <td><?=$ival?></td>
            <?php }?>
        </tr>
    </tbody>
</table>