import React from 'react';

import classNames from 'classnames';

import { TokenUsage } from '../types/Types';

import styles from './TokensInfo.module.scss';

interface TokensInfoProps {
  tokens?: TokenUsage | null;
  className?: string;
}

const defaultTokens = {
  prompt: 0,
  completion: 0,
  total: 0,
}

export default function TokensInfo({tokens, className}: TokensInfoProps) {
  return (
    <div className={classNames(styles.main, className)}>
      <div className={styles.title}>Token Usage</div>
      <div className={styles.tokenGrid}>
        <div className={styles.tokenItem}>
          <span>Prompt Tokens</span>
          <strong>{tokens?.prompt ?? defaultTokens.prompt}</strong>
        </div>
        <div className={styles.tokenItem}>
          <span>Completion Tokens</span>
          <strong>{tokens?.completion ?? defaultTokens.completion}</strong>
        </div>
        <div className={styles.tokenItem}>
          <span>Total Tokens</span>
          <strong>{tokens?.total ?? defaultTokens.total}</strong>
        </div>
      </div>
    </div>
  );
}
