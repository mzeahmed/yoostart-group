<?php

namespace YsGroups\Controller;

/**
 * @since 1.1.0
 */
abstract class AbstractController
{
    /**
     * Rendu du template
     *
     * @param string $template
     * @param array  $params
     *
     * @return string|null
     * @since 1.0.0
     */
    protected function render(string $template, array $params = []): ?string
    {
        $path = $this->getTemplatePath() . $template . '.php';

        ob_start();
        extract($params);
        require($path);

        /**
         * @since 1.1.1
         */
        if (! is_admin()) {
            return ob_get_clean();
        }

        return ob_get_contents();
    }

    /**
     * Récupére le chemin du dossier des templates
     *
     * @return string|null
     * @since 1.0.0
     */
    private function getTemplatePath(): ?string
    {
        return YS_GROUPS_PATH . '/templates/';
    }

    /**
     * Ajout de message flash en session
     * Utilisation des classes Bootstrap pour le $type
     *
     * @param string $type @see https://getbootstrap.com/docs/5.0/components/alerts/
     * @param string $message
     *
     * @return void
     */
    protected function addFlash(string $type, string $message)
    {
        $_SESSION['ys_flash']['type'] = $type;
        $_SESSION['ys_flash']['message'] = $message;
    }
}
