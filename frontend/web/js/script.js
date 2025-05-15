import { cart } from "./cart.js"
import ProductService from "./ProductService.js";
import CardProduct from "./CardProduct.js";

document.addEventListener('DOMContentLoaded', function () {
    customElements.define('card-product', CardProduct);
    const cartPageElem = document.querySelector('.cart');
    if (cartPageElem) {
        CartPageUI.init()
    } else {
        CartUI.init()
    }
})

class CartPageUI {
    static state = {
        isLoading: false,
    };

    static set loading(value) {
        this.state.isLoading = value;
        this.changeLoadingState(value);
    }

    static get loading() {
        return this.state.isLoading;
    }

    /**
     * Изменяет состояние загрузки страницы.
     * @param {boolean} isLoading 
     */
    static changeLoadingState(isLoading) {
        if (isLoading) {
            this.container.classList.add('loading');
        } else {
            this.container.classList.remove('loading');
        }
    }

    static cacheElements() {
        this.container = document.querySelector('.cart');  // Контейнер, куда будет выводиться список товаров
    }

    static renderProducts() {
        // Пробегаемся по элементам корзины и формируем HTML-разметку для каждого товара
        cart.items.forEach(cartItem => {
            // Ищем подробные данные для товара по его id
            const product = this.productsData.find(prod => prod.id === cartItem.id);
            if (!product) return ''; // Если товар не найден, пропускаем
            const card = document.createElement('card-product');
            card.name = product.name;
            card.price = product.price;
            card.id = product.id;
            card.quantity = cartItem.quantity;
            this.container.appendChild(card);
        })
    }

    static updateProducts() {
        document.querySelectorAll('card-product').forEach(productEl => {
            const product = cart.getItemById(productEl.id);

            if (!product) {
                // Удаляем элемент, если его уже нет в корзине
                productEl.closest('card-product').remove();
            }
        });
    }

    static async fetchProducts() {
        this.loading = true;

        // Загружаем подробную информацию о продуктах корзины перед рендерингом
        const productIds = cart.items.map(item => item.id);
        try {
            this.productsData = await ProductService.fetchProductsByIds(productIds);
        } catch (error) {
            console.error('Ошибка загрузки данных о продуктах:', error);
            this.productsData = [];
        }

        this.loading = false;
    }

    static bindEvents() {
        document.addEventListener('cartUpdated', () => {
            this.updateProducts()
        });
    }

    static async init() {
        this.bindEvents();

        this.cacheElements();

        await this.fetchProducts()

        this.renderProducts();

        CartUI.init()
    }
}

// Паттерны для работы с UI
class CartUI {
    static init() {
        this.bindEvents();
        this.cacheElements();
        this.updateCounter();
        this.updateProducts()
    }

    static bindEvents() {
        document.addEventListener('click', e => {
            const addBtn = e.target.closest('.js-cart-add-item');
            const plusBtn = e.target.closest('.js-cart-increase');
            const minusBtn = e.target.closest('.js-cart-decrease');
            const clearCartBtn = e.target.closest('.js-cart-clear');

            if (addBtn) {
                const id = addBtn.dataset.itemId;
                cart.addItem(id);
            }

            if (plusBtn) {
                const product = plusBtn.closest('.product');
                const id = product.dataset.id;
                cart.incrementQuantity(id);
            }

            if (minusBtn) {
                const product = minusBtn.closest('.product');
                const id = product.dataset.id;
                cart.decrementQuantity(id);
            }

            if (clearCartBtn) {
                cart.clearCart();
            }
        });

        document.addEventListener('cartUpdated', () => {
            this.updateCounter()
            this.updateProducts()
        });
    }

    static cacheElements() {
        this.counterElements = document.querySelectorAll('.js-items-counter');
    }

    static updateCounter() {
        if (this.counterElements.length < 0) return;

        const itemCount = cart.items.length;
        this.counterElements.forEach(elem => {
            elem.innerHTML = `<span>${itemCount}</span>`;
        })
    }

    static updateProducts() {
        document.querySelectorAll('.product').forEach(productEl => {
            const id = productEl.dataset.id;
            const product = cart.getItemById(id);

            const addBtn = productEl.querySelector('.js-cart-add-item');
            const controls = productEl.querySelector('.quantity-controls');
            const quantityEl = productEl.querySelector('.js-cart-quantity');

            if (product && product.quantity > 0) {
                addBtn.classList.add('hidden');
                controls.classList.remove('hidden');
                quantityEl.textContent = product.quantity;
            } else {
                addBtn.classList.remove('hidden');
                controls.classList.add('hidden');
            }
        });
    }
}

