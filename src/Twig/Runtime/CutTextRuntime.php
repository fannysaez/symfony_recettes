<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class CutTextRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function doSomething($value)
    {
        // ...
    }

    public function cut_text($value, $length = 60)
    {
        // Vérifie si la longueur du texte dépasse la limite
        if (strlen($value) > $length) {
            return substr($value, 0, $length) . '...';
        }
        return $value;
    }
}
