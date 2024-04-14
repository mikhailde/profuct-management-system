import React from 'react';
import { Group, Header, Button } from '@vkontakte/vkui';

interface Product {
  name: string;
  price: string;
}

interface ProductTableProps {
  products: Product[];
  onEdit: (product: Product) => void;
  onDelete: (product: Product) => void;
}

const ProductTable: React.FC<ProductTableProps> = ({ products, onEdit, onDelete }) => {
  return (
    <Group>
      <Header mode="secondary">Таблица товаров</Header>
      <table>
        <thead>
          <tr>
            <th>Имя</th>
            <th>Цена</th>
            <th>Действия</th>
          </tr>
        </thead>
        <tbody>
          {products.map((product, index) => (
            <tr key={index}>
              <td>{product.name}</td>
              <td>{product.price}</td>
              <td>
                <Button size="m" mode="secondary" onClick={() => onEdit(product)}>
                  Редактировать
                </Button>
                <Button size="m" onClick={() => onDelete(product)}>
                  Удалить
                </Button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </Group>
  );
};

export default ProductTable;
