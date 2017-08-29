<table>
    <thead>
        <tr>
            <?php foreach($data[0] as $key => $val){?>
                <td><?=$val?></td>
            <?php }?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data[1] as $key => $val){?>
            <tr>
                <?php foreach($val as $iKey => $iVal){?>
                    <?php if($iKey == 'manager_id' || $iKey == 'client_id' || $iKey == 'id')continue; ?>
                    <?php switch($iKey)
                        {
                            case 'manager':
                                echo '<td>';
                                echo '<a href="/?user=' . $val['manager_id']. '&type=manager">';
                                echo $iVal;
                                echo '</a>';
                                echo '</td>';
                                break;
                            case 'company_name':
                                echo '<td>';
                                echo '<a href="/?user=' . $val['client_id']. '&type=clients">';
                                echo $iVal;
                                echo '</a>';
                                echo '</td>';
                                break;
                            default:
                                echo '<td>';
                                echo $iVal;
                                echo '</td>';
                        }
                    ?>
                <?php }?>
            </tr>
        <?php   }?>
    </tbody>
</table>
<a href="<?=$data[2]?>" download class="load_table">Выгрузить таблицу в Excel</a>