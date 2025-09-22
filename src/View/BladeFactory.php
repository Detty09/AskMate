<?php

namespace App\View;

use eftec\bladeone\BladeOne;

class BladeFactory {
    private static ?BladeOne $blade = null;

    public static function init(): void {
        if (self::$blade == null) {
            $viewsPath = __DIR__ . "/../../views";
            $cachePath = __DIR__ . "/../../cache";
            self::$blade = new BladeOne($viewsPath, $cachePath, BladeOne::MODE_AUTO);
        }
    }

    public static function getBlade(): BladeOne {
        if (self::$blade == null) {
            self::init();
        }
        return self::$blade;
    }
}