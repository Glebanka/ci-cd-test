<div style="width: 100%; font-size: 12px;">
    <p>Заказ №<?=sprintf("%'.06d\n", $order)?> оформлен и ожидает модерации</p>
    <p>ФИО: <?=$full_user->fio?></p>
    <p>Телефон: <?=$full_user->tel?></p>
    <table border="1" style="border-collapse: collapse;border: 1px solid #000;">
        <tr>
            <td style="padding: 5px;width: 250px;">Наименование</td>
            <td style="padding: 5px;width: 130px;">Количество</td>
            <td style="padding: 5px;width: 90px;">Цена</td>
        </tr>
        <?
        foreach($session['cart'] as $id => $item){
            ?>
            <tr>
                <td style="padding: 5px;"><?=$item['name']?></td>
                <td style="padding: 5px;text-align: center;"><?=$item['qty']?></td>
                <td style="padding: 5px;text-align: center;"><?=number_format(($item['price'] * $item['qty']), 0, '.', ' ')?> руб</td>
            </tr>
            <?
        }
        ?>
        <tr>
            <td style="padding: 5px;text-align: right;">&nbsp;</td>
            <td style="padding: 5px;text-align: right;">Итого:</td>
            <td style="padding: 5px;text-align: center;"><?=number_format($session['cart.sum'], 0, '.', ' ')?> руб</td>
        </tr>
    </table>
</div>