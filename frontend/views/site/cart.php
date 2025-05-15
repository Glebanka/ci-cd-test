<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Корзина (<span class="js-items-counter"></span>)</h2>
<div class="cart">

</div>
<button class="mt-2 js-cart-clear">Очистить корзину</button>

<a class="mt-5 d-block" href="/frontend/web/index.php?r=site%2Forder">Перейти на страницу заказа</a>