<?php
final class GroupCsrf {
    public static function token(): string {
        if (!isset($_SESSION['group-blog-token']) || !is_string($_SESSION['group-blog-token'])) {
            $_SESSION['group-blog-token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['group-blog-token'];
    }
    public static function valid($submitted): bool {
        $expected = $_SESSION['group-blog-token'] ?? null;
        return is_string($expected) && strlen($expected) === 64 && is_string($submitted)
            && strlen($submitted) === 64 && hash_equals($expected, $submitted);
    }
}
