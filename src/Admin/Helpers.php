<?php

namespace YsGroups\Admin;

/**
 * @package YsGroups
 * @since   1.0.0
 */
class Helpers
{
    /**
     * Défini une constante si elle n'est pas défini
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     * @since 1.0.0
     */
    public static function maybeDefineConstant(string $name, mixed $value)
    {
        if (! defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Créé une page et persist l'ID en base de données
     *
     * @param string $slug         Slug de la nouvelle  page
     * @param string $option       Nom de l'option pour stocker l'ID de la page. (valeur de l'option == Id de la page)
     * @param string $page_title   Titre de la nouvelle page (Défaut: '')
     * @param string $page_content Contenu de la nouvelle page (Défaut: '')
     * @param int    $post_parent  Parent de la nouvelle page (Default: 0)
     * @param string $post_status  Le status de la page (Défault: publiée)
     *
     * @return int
     * @thanks WooCommerce
     * @since  1.0.0
     */
    public static function createPage(
        string $slug,
        string $option = '',
        string $page_title = '',
        string $page_content = '',
        int $post_parent = 0,
        string $post_status = 'publish'
    ): int {
        global $wpdb;

        $option_value = get_option($option);

        if ($option_value > 0) {
            $page_object = get_post($option_value);

            if (
                $page_object && 'page' === $page_object->post_type && ! in_array(
                    $page_object->post_status,
                    ['pending', 'trash', 'future', 'auto-draft'],
                    true
                )
            ) {
                // Valid page is already in place.
                return $page_object->ID;
            }
        }

        if (strlen($page_content) > 0) {
            // Search for an existing page with the specified page content (typically a shortcode).
            $shortcode = str_replace(['<!-- wp:shortcode -->', '<!-- /wp:shortcode -->'], '', $page_content);
            $valid_page_found = $wpdb->get_var($wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;",
                "%{$shortcode}%"
            )
            );
        } else {
            // Search for an existing page with the specified page slug.
            $valid_page_found = $wpdb->get_var($wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;",
                $slug
            )
            );
        }

        $valid_page_found = apply_filters('ys_groups_create_page_id', $valid_page_found, $slug, $page_content);

        if ($valid_page_found) {
            if ($option) {
                update_option($option, $valid_page_found);
            }

            return $valid_page_found;
        }

        // Search for a matching valid trashed page.
        if (strlen($page_content) > 0) {
            // Search for an existing page with the specified page content (typically a shortcode).
            $trashed_page_found = $wpdb->get_var($wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;",
                "%{$page_content}%"
            )
            );
        } else {
            // Search for an existing page with the specified page slug.
            $trashed_page_found = $wpdb->get_var($wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;",
                $slug
            )
            );
        }

        if ($trashed_page_found) {
            $page_id = $trashed_page_found;
            $page_data = [
                'ID' => $page_id,
                'post_status' => $post_status,
            ];
            wp_update_post($page_data);
        } else {
            $page_data = [
                'post_status' => $post_status,
                'post_type' => 'page',
                'post_author' => 1,
                'post_name' => $slug,
                'post_title' => $page_title,
                'post_content' => $page_content,
                'post_parent' => $post_parent,
                'comment_status' => 'closed',
            ];
            $page_id = wp_insert_post($page_data);

            do_action('ys_groups_page_created', $page_id, $page_data);
        }

        if ($option) {
            update_option($option, $page_id);
        }

        return $page_id;
    }
}
