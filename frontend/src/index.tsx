import React from 'react';
import ReactDOM from 'react-dom/client';
import ChatPage from './pages/ChatPage';

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);
root.render(
  <React.StrictMode>
    <ChatPage />
  </React.StrictMode>
);
