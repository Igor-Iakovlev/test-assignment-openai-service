import React from 'react';

import classNames from 'classnames';

import { Message } from '../types/Types';

import styles from './Chat.module.scss';

interface ChatProps {
  messages: Message[],
  isLoading: boolean,
  className?: string,
}

export default function Chat({messages, isLoading, className = ''}: ChatProps)
{
  const renderMessage = (message: Message) => {
    return (
      <div className={classNames(styles.message, styles[message.role])}>
        <div className={classNames(styles.bubble)}>
          <p>{message.content}</p>
        </div>
      </div>
    )
  }

  return (
    <div className={classNames(styles.main, className)}>
      {messages.map(renderMessage)}
      {isLoading && <div className={styles.loader} />}
    </div>
  )
}
