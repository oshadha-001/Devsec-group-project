<?php
final class GroupDns {
    public static function resolve($host): array {
        if (!is_string($host) || strlen($host) > 253 || $host === '') {
            throw new InvalidArgumentException('Invalid hostname or IP address.');
        }
        if (filter_var($host, FILTER_VALIDATE_IP)) { return [$host]; }
        if (!filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            throw new InvalidArgumentException('Invalid hostname or IP address.');
        }
        $addresses = gethostbynamel($host);
        return $addresses === false ? [] : $addresses;
    }
}
