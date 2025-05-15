<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Shop';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
$products = [
    ['id' => 1, 'name' => 'Product A', 'price' => 100],
    ['id' => 2, 'name' => 'Product B', 'price' => 200],
    ['id' => 3, 'name' => 'Product C', 'price' => 300],
];
?>

<div class="shop">
    <?php foreach ($products as $product): ?>
        <div class="product" data-id="<?= $product['id'] ?>">
            <h3><?= $product['name'] ?></h3>
            <p>Price: <?= $product['price'] ?>р</p>
            <button data-item-id='<?= $product['id'] ?>' class="js-cart-add-item">
                Добавить товар
            </button>
            <div class="quantity-controls hidden">
                <button class="js-cart-decrease">−</button>
                <span class="js-cart-quantity">1</span>
                <button class="js-cart-increase">+</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>