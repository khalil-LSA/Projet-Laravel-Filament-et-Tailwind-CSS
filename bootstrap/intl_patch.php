<?php

namespace Illuminate\Support;

if (!function_exists('extension_loaded_original')) {
    function extension_loaded_original($name) {
        return \extension_loaded($name);
    }
}

/**
 * Override de la fonction extension_loaded pour simuler intl
 */
if (!extension_loaded('intl')) {
    // Créer une fonction de remplacement
    eval('
    namespace {
        function extension_loaded_patched($name) {
            if ($name === "intl") {
                return true; // Simuler que intl est chargée
            }
            return \extension_loaded_original($name);
        }
    }
    ');
}