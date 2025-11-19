<?php

namespace backend\dto;

class ChatCompletionResult
{
    public function __construct(
        public string $answer,
        public TokensUsage $tokens,
    ) {}
}
