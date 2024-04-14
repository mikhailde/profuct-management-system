import React, { useState } from 'react';
import { View, Panel, PanelHeader } from '@vkontakte/vkui';
import '@vkontakte/vkui/dist/vkui.css';
import ProductTable from './components/ProductTable';
import ProductModal from './components/ProductModal';

interface Product {
  name: string;
  price: string;
}

const App = () => {
  const [activePanel, setActivePanel] = useState('main');
  const [products, setProducts] = useState<Product[]>([]);
  const [showModal, setShowModal] = useState(false);

  const openModal = () => {
    setShowModal(true);
  };

  const closeModal = () => {
    setShowModal(false);
  };

  const handleSaveProduct = (product: Product) => {
    setProducts([...products, product]);
    closeModal();
  };

  return (
    <div>
      <Panel id="main">
        <PanelHeader>
          Магазин товаров
        </PanelHeader>
        <ProductTable
          products={products}
          onEdit={openModal}
          onDelete={() => {}}
        />
      </Panel>
      {showModal && (
        <ProductModal
          onClose={closeModal}
          onSave={handleSaveProduct}
        />
      )}
    </div>
  );
};

export default App;
