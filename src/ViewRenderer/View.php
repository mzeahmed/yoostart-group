<?php

namespace YsGroups\ViewRenderer;

/**
 * @since 1.0.0
 */
class View
{
    /**
     * @param string $template
     * @param array  $params
     *
     * @return string|null
     * @since 1.0.0
     */
    public static function render(string $template, array $params = []): ?string
    {
        extract($params);

        $path = self::getTemplatePath() . $template . '.php';

        ob_start();
        require($path);

        return ob_get_contents();
    }

    /**
     * @return string|null
     * @since 1.0.0
     */
    private static function getTemplatePath(): ?string
    {
        return YS_GROUPS_PATH . '/templates/';
    }
}
