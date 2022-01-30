<?php

namespace YsGroups\Services;

/**
 * @since 1.1.4
 */
class RewriteRules
{
    public function __construct()
    {
        add_action('wp_loaded', [$this, 'flushRules']);
        add_filter('rewrite_rules_array', [$this, 'insertRewriteRules']);
        add_filter('query_vars', [$this, 'insertQueryVars']);
        // dump(get_option('rewrite_rules'));
    }

    /**
     * Vide les réécritures si nos règles n'ont pas encore été ajoutée.
     *
     * @since 1.1.4
     */
    public function flushRules()
    {
        $rules = get_option('rewrite_rules');

        if (! isset($rules['(groupes)/(.*)'])) {
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }
    }

    /**
     * Ajout des nouvelles régles de reécriture
     *
     * @param array $rules Régles existantes.
     *
     * @return array Liste modifiées des régles reécrites
     * @since 1.1.4
     */
    public function insertRewriteRules(array $rules): array
    {
        $newrules = [];
        $newrules['(groupe)/(.*)'] = 'index.php?pagename=$matches[1]&gslug=$matches[2]';

        return $newrules + $rules;
    }

    /**
     * Ajout des differentes variables de requêtes afin que WordPres les reconnaissent
     *
     * @param array $qvars
     *
     * @return array
     * @since 1.1.4
     */
    public function insertQueryVars(array $qvars): array
    {
        array_push($qvars, 'gslug');

        return $qvars;
    }
}
