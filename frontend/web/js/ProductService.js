
class ProductService {
    /**
    * Загружает данные о продуктах по их ID.
    * 
    * @param {string[]} ids - Массив ID продуктов, которые нужно загрузить.
    * @returns {Promise<{id: string, name: string, price: number}[]>}
    * @throws {Error} Если произошла ошибка при загрузке данных.
    */
    static async fetchProductsByIds(ids) {
        // Формируем строку из id (например, id1,id2,...)
        const queryString = ids.join(',');

        // const response = await fetch(`/api/products?ids=${encodeURIComponent(queryString)}`);
        
        // Фейковая задержка на 1 секунду
        await new Promise(resolve => setTimeout(resolve, 1000));

        // Фейковые данные
        const products = [
            { id: '1', name: 'Product A', price: 100 },
            { id: '2', name: 'Product B', price: 200 },
            { id: '3', name: 'Product C', price: 300 },
        ];

        // Фильтруем продукты по переданным ID
        const response = {
            ok: true,
            json: async () => products.filter(product => ids.includes(product.id))
        };
        
        if (!response.ok) {
            throw new Error('Ошибка загрузки данных о продуктах');
        }
        return response.json();
    }
}
export default ProductService;