import React, { useState } from 'react';
import { ModalPage, ModalPageHeader, Button, Input } from '@vkontakte/vkui';

interface Product {
  name: string;
  price: string;
}

interface ProductModalProps {
  onClose: () => void;
  onSave: (product: Product) => void;
  product?: Product;
}

const ProductModal: React.FC<ProductModalProps> = ({ onClose, onSave, product }) => {
  const [name, setName] = useState(product ? product.name : '');
  const [price, setPrice] = useState(product ? product.price : '');

  const handleSave = () => {
    onSave({ name, price });
    onClose();
  };

  return (
    <ModalPage
      id="product-modal"
      dynamicContentHeight
      header={
        <ModalPageHeader>
          {product ? 'Редактировать товар' : 'Добавить товар'}
          <Button onClick={handleSave}>Сохранить</Button>
        </ModalPageHeader>
      }
      onClose={onClose}
    >
      <form onSubmit={handleSave}>
        <div style={{ padding: '20px' }}>
          <Input
            type="text"
            placeholder="Название товара"
            value={name}
            onChange={(e) => setName(e.target.value)}
          />
          <Input
            type="number"
            placeholder="Цена"
            value={price}
            onChange={(e) => setPrice(e.target.value)}
          />
        </div>
        <Button size="l" stretched type="submit">
          Сохранить
        </Button>
      </form>
    </ModalPage>
  );
};

export default ProductModal;
