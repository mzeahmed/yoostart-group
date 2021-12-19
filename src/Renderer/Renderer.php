<?php

namespace YsGroups\Renderer;

class Renderer
{
    /**
     * @param string     $template
     * @param array|null $data
     *
     * @return false|string
     */
    public static function render(string $template, array $data = null): bool|string
    {
        $data ?: extract($data);

        $path = self::getTemplatePath() . $template . '.php';

        if ($path) {
            ob_start();
            require($path);

            return ob_get_contents();
        }

        return false;
    }

    /**
     * @return string
     */
    private static function getTemplatePath(): string
    {
        return YS_GROUPS_PATH . '/templates/';
    }
}
