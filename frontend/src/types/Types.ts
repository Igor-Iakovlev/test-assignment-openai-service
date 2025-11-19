export type Message = {
  role: 'assistant' | 'user',
  content: string,
}

export type TokenUsage = {
  prompt: number;
  completion: number;
  total: number;
}
