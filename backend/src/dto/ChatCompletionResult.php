<?php

namespace backend\dto;

class ChatCompletionResult
{
    public function __construct(
        public string $messageText,
        public int $promptTokens,
        public int $completionTokens,
        public int $totalTokens,
    ) {}
}
