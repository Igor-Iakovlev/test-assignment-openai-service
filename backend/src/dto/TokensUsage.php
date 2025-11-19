<?php

namespace backend\dto;

class TokensUsage
{
    public function __construct(
        public int $prompt,
        public int $completion,
        public int $total,
    ) {}
}
