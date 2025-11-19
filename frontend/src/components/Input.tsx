import React from 'react';

import classNames from 'classnames';

import styles from './Input.module.scss';

interface InputProps {
  value: string,
  onChange: (value: string) => void,
  onSubmit: () => void;
  disabled: boolean;
  className?: string;
  placeholder?: string;
}

export default function Input({
  value,
  onChange,
  onSubmit,
  disabled = false,
  className = '',
  placeholder = 'Enter your message...'
}: InputProps) {
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (value.trim() && onSubmit) {
      onSubmit();
    }
  };

  return (
    <form onSubmit={handleSubmit} className={classNames(styles.textInputForm, className)}>
      <textarea
        value={value}
        onChange={(e) => onChange(e.target.value)}
        placeholder={placeholder}
        className={styles.textarea}
        rows={1}
        disabled={disabled}
      />
      <button type="submit" className={styles.button} disabled={disabled || !value.trim()}>
        Send
      </button>
    </form>
  );
}
