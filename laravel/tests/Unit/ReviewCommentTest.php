<?php

namespace Tests\Unit;

use App\Support\ReviewComment;
use Illuminate\Support\Js;
use PHPUnit\Framework\TestCase;

class ReviewCommentTest extends TestCase
{
    public function test_it_removes_html_tags_and_control_characters(): void
    {
        $comment = "  Dobry produkt.\0 <img src=x onerror=alert(1)><script>alert('xss')</script>  ";

        $normalized = ReviewComment::normalize($comment);

        $this->assertSame("Dobry produkt. alert('xss')", $normalized);
        $this->assertStringNotContainsString('<script', $normalized);
        $this->assertStringNotContainsString('onerror', $normalized);
    }

    public function test_sql_like_content_remains_plain_text(): void
    {
        $comment = "Robert'); DROP TABLE reviews; --";

        $this->assertSame($comment, ReviewComment::normalize($comment));
    }

    public function test_null_comment_becomes_an_empty_string(): void
    {
        $this->assertSame('', ReviewComment::normalize(null));
    }

    public function test_review_json_cannot_break_out_into_executable_markup(): void
    {
        $encoded = Js::encode([
            ['content' => "'><script>alert('xss')</script>"],
        ]);

        $this->assertStringNotContainsString('<script', $encoded);
        $this->assertStringContainsString('\u003Cscript\u003E', $encoded);
    }
}
