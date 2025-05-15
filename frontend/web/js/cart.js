// Хранилище корзины
class CartManager {
    #items = [];
    #storageKey = 'cart';

    constructor() {
        this.#loadFromStorage();
    }

    // Загрузка из localStorage
    #loadFromStorage() {
        this.#items = JSON.parse(localStorage.getItem(this.#storageKey) || '[]');
    }

    // Сохранение в localStorage
    #saveToStorage() {
        localStorage.setItem(this.#storageKey, JSON.stringify(this.#items));
        document.dispatchEvent(new CustomEvent('cartUpdated'));
    }

    // Основные методы
    addItem(id) {
        // Проверяем, есть ли уже товар в корзине
        if (this.#items.some(item => item.id === id)) {
            return;
        }
        this.#items.push({
            id,
            quantity: 1,
        });
        this.#saveToStorage();
    }

    incrementQuantity(id) {
        const product = this.getItemById(id);
        product.quantity++
        this.#saveToStorage();
    }
    decrementQuantity(id) {
        const product = this.getItemById(id);
        if(product.quantity <= 1) {
            this.removeItem(product.id);
            return;
        }
        product.quantity--
        this.#saveToStorage();
    }

    removeItem(productId) {
        this.#items = this.#items.filter(item => item.id !== productId);
        this.#saveToStorage();
    }

    clearCart() {
        this.#items = [];
        this.#saveToStorage();
    }

    // Геттеры

    /**
     * Возвращает копию текущих элементов в корзине.
     * @returns {Array<{id: string, quantity: number}>} Массив элементов корзины, 
     * каждый из которых содержит `id` и `quantity`.
     */
    get items() {
        return [...this.#items]; // Возвращаем копию
    }

    /**
     * Вычисляет общую стоимость всех элементов в корзине.
     * @returns {number} Общая стоимость элементов корзины.
     */
    get totalPrice() {
        return this.#items.reduce((sum, item) => sum + item.price * item.quantity, 0);
    }

    /**
     * Находит и возвращает элемент корзины по его ID.
     * @param {string} id - ID элемента, который нужно найти.
     * @returns {{id: string, quantity: number} | undefined} Элемент корзины с 
     * указанным ID или `undefined`, если элемент не найден.
     */
    getItemById(id) {
        return this.#items.find(item => item.id === id);
    }
}

export const cart = new CartManager();