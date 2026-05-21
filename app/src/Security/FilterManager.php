<?php

namespace App\Security;

class FilterManager
{
    private array $allowedMethods;
    private array $allowedIps;
    private array $allowedBrowsers;

    public function __construct(array $config = []) {
        $this->allowedMethods = $config["methods"] ?? ["GET", "POST"];
        $this->allowedIps = $config["ips"] ?? [];
        $this->allowedBrowsers = $config["browsers"] ?? [];
    }

    public function checkAll(string $method, string $ip, string $userAgent): bool {
        return $this->checkMethod($method)
            && $this->checkIp($ip)
            && $this->checkBrowser($userAgent);
    }

    private function checkMethod(string $method): bool {
        return in_array(strtoupper($method), $this->allowedMethods);
    }

    private function checkIp(string $ip): bool {
        if (empty($this->allowedIps)) {
            return true;
        }
        return in_array($ip, $this->allowedIps);
    }

    private function checkBrowser(string $userAgent): bool {
        if (empty($this->allowedBrowsers)) {
            return true;
        }
        foreach ($this->allowedBrowsers as $allowedBrowser) {
            if (stripos($userAgent, $allowedBrowser) !== false) {
                return true;
            }
        }
        return false;
    }
}