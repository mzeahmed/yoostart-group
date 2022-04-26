<?php

namespace YsGroups\Controller;

/**
 * @since 1.1.0
 */
abstract class AbstractController
{
    /**
     * Uri de la pages des groupes
     *
     * @var string
     */
    protected string $groupsDirectoryUri;

    /**
     * @var \WP_Query
     */
    protected \WP_Query $wpQuery;

    /**
     * @var string|mixed uri courrant
     */
    protected string $requestUri;

    /**
     * @var array|string[] elements de la requete segmentés dans un tableau
     */
    protected array $request;

    public function __construct()
    {
        $this->groupsDirectoryUri = YS_GROUP_URL;

        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->request = explode('/', $this->requestUri);
    }

    /**
     * Chargement des templates des custom post type
     *
     * @param string $template
     * @param string $varName
     * @param array  $params
     *
     * @return string
     * @example Exemple d'usage :
     *              $this->locateTemplate('nom-du-template', 'nom_de_la_variable', ['variable1' => $variable1])
     *          Pour récuperer la variable :
     *              global $wp_query; extract($wp_query->query_vars);
     *              echo $nom_de_la_variable['variable1'];
     * @since   1.2.3
     */
    protected function template(string $template, string $varName = '', array $params = []): string
    {
        $ysGPt = 'ys-group';
        $located = '';

        if (is_single() && get_post_type() === $ysGPt) {
            $located = $this->getTemplatePath() . $template . '-' . $ysGPt . '.php';
        } elseif (is_post_type_archive($ysGPt)) {
            $located = $this->getTemplatePath() . $template . '-' . $ysGPt . '.php';
        }

        set_query_var($varName, $params);

        return $located;
    }

    /**
     * Récupére le chemin du dossier des templates
     *
     * @return string|null
     * @since 1.0.0
     */
    private function getTemplatePath(): ?string
    {
        return YS_GROUP_PATH . 'templates/';
    }

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
        require_once($path);

        /**
         * @since 1.1.1
         */
        if (! is_admin()) {
            return ob_get_clean();
        }

        return ob_get_contents();
    }

    /**
     * Retourne le chemin du template avec possibilité d'envoyer des paramettres
     *
     * @param string $template
     * @param string $varName Nom de la variable
     * @param array  $params  Tableau des valeurs
     *
     * @return string
     * @example Exemple d'usage :
     *              $this->locateTemplate('nom-du-template', 'nom_de_la_variable', ['variable1' => $variable1])
     *          Pour récuperer la variable :
     *              global $wp_query; extract($wp_query->query_vars);
     *              echo $nom_de_la_variable['variable1'];
     *
     * @since   1.1.4
     */
    protected function locateTemplate(string $template, string $varName = '', array $params = []): string
    {
        $located = '';
        $file = $this->getTemplatePath() . $template . '.php';

        if (file_exists($file)) {
            $located = $file;
        }

        set_query_var($varName, $params);

        return $located;
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
