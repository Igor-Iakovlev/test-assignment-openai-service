import React, { useState } from 'react';

import Chat from '../components/Chat';
import Input from '../components/Input';
import TokensInfo from '../components/TokensInfo';
import { Message, TokenUsage } from '../types/Types';

import styles from './ChatPage.module.scss';

export default function ChatPage(): React.JSX.Element {
  const [inputValue, setInputValue] = useState<string>('');
  const [messages, setMessages] = useState<Message[]>([]);
  const [tokens, setTokens] = useState<TokenUsage | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [isLoading, setIsLoading] = useState<boolean>(false);

  const handleSubmit = (value: string) => {
    if (!value.trim()) return;

    const userMessage: Message = { role: 'user', content: value };
    setMessages(prev => [...prev, userMessage]);
    setInputValue('');
    setError(null);
    setIsLoading(true);

    fetch('/api/create-chat-completion', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ messages: [...messages, userMessage] }),
    })
      .then(response => {
        console.log(response);
        if (!response.ok) {
          return response.text().then(errorText => {
            throw new Error(errorText || `${response.status}: ${response.statusText}`);
          });
        }
        return response.json();
      })
      .then(data => {
        const assistantMessage: Message = { role: 'assistant', content: data.answer };
        setMessages(prev => [...prev, assistantMessage]);
        setTokens(data.tokens);
      })
      .catch(err => {
        setError(err instanceof Error ? err.message : 'Unknown error');
        setMessages(prev => prev.slice(0, -1));
        setInputValue(value);
      })
      .finally(() => {
        setIsLoading(false);
      });
  };

  const clearError = () => setError(null);

  return (
    <div className={styles.main}>
      <div className={styles.title}>ChatGPT Assistant</div>
      <div className={styles.pageLayout}>
        <div className={styles.chatWrapper}>
          <Chat messages={messages} isLoading={isLoading} className={styles.chat} />
          <div className={styles.errorSlot}>
            {error && (
              <div className={styles.error} onClick={clearError}>
                Error: {error} (click to dismiss)
              </div>
            )}
          </div>
          <Input
            value={inputValue}
            onChange={setInputValue}
            disabled={isLoading}
            onSubmit={() => handleSubmit(inputValue)}
          />
        </div>
        <TokensInfo tokens={tokens} className={styles.tokens} />
      </div>
    </div>
  );
}
