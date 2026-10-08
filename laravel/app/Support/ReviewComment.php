<?php

namespace App\Support;

final class ReviewComment
{
    public const MAX_LENGTH = 2000;

    public static function normalize(?string $comment): string
    {
        if ($comment === null) {
            return '';
        }

        $comment = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $comment);

        if ($comment === null) {
            return '';
        }

        return trim(strip_tags($comment));
    }
}
