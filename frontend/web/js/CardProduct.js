class CardProduct extends HTMLElement {
    #name = '';
    #price = 0;
    #id = '';
    #quantity = '';

    set name(value) {
        this.#name = value;
        this.render();
    }

    get name() {
        return this.#name;
    }

    set price(value) {
        this.#price = value;
        this.render();
    }

    get price() {
        return this.#price;
    }

    set id(value) {
        this.#id = value;
        this.render();
    }

    get id() {
        return this.#id;
    }

    set quantity(value) {
        this.#quantity = value;
        this.render();
    }

    get quantity() {
        return this.#quantity;
    }

    connectedCallback() {
        this.render();
    }

    render() {
        this.textContent = ''; // очищаем

        const div = document.createElement('div');
        div.className = 'product';
        div.dataset.id = this.id;

        const h3 = document.createElement('h3');
        h3.textContent = this.name;

        const p = document.createElement('p');
        p.textContent = `Price: ${this.price}р`;

        const button = document.createElement('button');
        button.dataset.itemId = this.id;
        button.className = 'js-cart-add-item';
        button.textContent = 'Добавить товар';

        const controls = document.createElement('div');
        controls.className = 'quantity-controls';

        const btnDecrease = document.createElement('button');
        btnDecrease.className = 'js-cart-decrease';
        btnDecrease.textContent = '−';

        const spanQuantity = document.createElement('span');
        spanQuantity.className = 'js-cart-quantity';
        spanQuantity.textContent = this.quantity;

        const btnIncrease = document.createElement('button');
        btnIncrease.className = 'js-cart-increase';
        btnIncrease.textContent = '+';

        controls.append(btnDecrease, spanQuantity, btnIncrease);
        div.append(h3, p, button, controls);
        this.append(div);
    }
}

export default CardProduct;