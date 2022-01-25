<?php

namespace YsGroups\Helpers;

use YsGroups\Model\Groups;
use YsGroups\Controller\AbstractController;

/**
 * @since 1.1.0
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

            if ($page_object && 'page' === $page_object->post_type
                && ! in_array(
                    $page_object->post_status,
                    ['pending', 'trash', 'future', 'auto-draft'],
                    true
                )
            ) {
                // Une page valide est déjà en place.
                return $page_object->ID;
            }
        }

        if (strlen($page_content) > 0) {
            // Recherche d'une page existante avec le contenu de page spécifié (généralement un shortcode).
            $shortcode = str_replace(['<!-- wp:shortcode -->', '<!-- /wp:shortcode -->'], '', $page_content);
            $valid_page_found = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT ID FROM $wpdb->posts 
                        WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) 
                        AND post_content LIKE %s LIMIT 1;",
                    "%{$shortcode}%"
                )
            );
        } else {
            // Recherche d'une page existante avec le slug spécifié
            $valid_page_found = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT ID FROM $wpdb->posts 
                        WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  
                        AND post_name = %s LIMIT 1;",
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
            $trashed_page_found = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT ID FROM $wpdb->posts 
                        WHERE post_type='page' 
                        AND post_status = 'trash' 
                        AND post_content LIKE %s LIMIT 1;",
                    "%{$page_content}%"
                )
            );
        } else {
            // Search for an existing page with the specified page slug.
            $trashed_page_found = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT ID FROM $wpdb->posts 
                        WHERE post_type='page' 
                        AND post_status = 'trash' 
                        AND post_name = %s LIMIT 1;",
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

    /**
     * Récuperation du nom des groupes en fonction des ids passés en parametres
     *
     * @param array|string $gid
     *
     * @return array
     * @since 1.1.0
     */
    public static function getGroupsName(array|string $gid): array
    {
        $groupsName = (new Groups())->getGroupsName($gid);

        $name = [];
        foreach ($groupsName as $groupName) {
            $obj_vars = get_object_vars($groupName);

            foreach ($obj_vars as $var) {
                $name[] = $var;
            }
        }

        return $name;
    }

    /**
     * Recupere les donnéesd'un group en fonction de son slug
     *
     * @param string $slug
     *
     * @return array
     * @since 1.1.5
     */
    public static function getGroupDatasBySlug(string $slug): array
    {
        return (new Groups())->getGroupDatasBySlug($slug);
    }

    /**
     * Lorsqu'on utilise WP_List_Table, recuperons l'action actuellement sélectionnée.
     *
     * @return string|null
     * @since 1.1.0
     */
    public static function listTableCurrentBulkAction(): ?string
    {
        $action = ! empty($_REQUEST['action']) ? $_REQUEST['action'] : '';

        if (! empty($_REQUEST['action2']) && $_REQUEST['action2'] != '-1') {
            $action = $_REQUEST['action2'];
        }

        return $action;
    }

    /**
     * Calcul du temps écoulé
     *
     * @param \DateTime $date
     * @param bool      $isDetails retourne un array avec les details si set a true
     *
     * @return array|string temps écoulé
     * @since 1.1.2
     */
    public static function timeElapsed(\DateTime $date, bool $isDetails = false): array|string
    {
        $months = [];
        for ($i = 1; $i < 13; $i++) {
            $month = date('F', mktime(0, 0, 0, $i));
            $months += [substr($month, 0, 3) => $i];
        }

        $dateYear = date('Y', strtotime($date)); // Année de la date
        $dateMonth = date('m', strtotime($date)); // Mois de la date
        $dateDay = date('d', strtotime($date)); // Jour de la date
        $dateHour = date('G', strtotime($date)); // Heure de la date
        $dateMinute = date('i', strtotime($date)); // Minute de la date
        $currentYear = date('Y'); // Année courrante

        // Secondes passés entre la date donnée et la date actuelle
        $secondsPassed = round((time() - strtotime($date)), 0);

        // Minutes passés entre la date donnée et la date actuelle
        $minutesPassed = round((time() - strtotime($date)) / 60, 0);

        // Heures passés entre la date donnée et la date actuelle
        $hoursPassed = round((time() - strtotime($date)) / 3600, 0);

        // Jours passés entre la date donnée et la date actuelle
        $daysPassed = round((time() - strtotime($date)) / 86400, 0);

        $output = '';
        $outputDetails = [];

        if ($secondsPassed < 60) {
            $outputDetails['text'] = __("Ago ", YS_GROUPS_TEXT_DOMAIN);
            $outputDetails['time'] = $secondsPassed;
            $outputDetails['unite'] = "s";
            $output = sprintf(__('%u s ago', YS_GROUPS_TEXT_DOMAIN), $secondsPassed);
        } elseif ($minutesPassed < 60) {
            $outputDetails['text'] = __("Ago ", YS_GROUPS_TEXT_DOMAIN);
            $outputDetails['time'] = $minutesPassed;
            $outputDetails['unite'] = "min";
            $output = sprintf(__('%u min ago', YS_GROUPS_TEXT_DOMAIN), '');
        } elseif ($hoursPassed < 24) {
            $outputDetails['text'] = __("Ago ", YS_GROUPS_TEXT_DOMAIN);
            $outputDetails['time'] = $hoursPassed;
            $outputDetails['unite'] = "h";
            $output = sprintf(__('%u h go', YS_GROUPS_TEXT_DOMAIN), '');
        } elseif ($daysPassed < 2) {
            $outputDetails['text'] = __("Hier à ", YS_GROUPS_TEXT_DOMAIN);
            $outputDetails['time'] = $dateHour . ":" . $dateMinute;
            $outputDetails['unite'] = "";
            $output = sprintf(__('Yesterday at %1$u : %2$u', YS_GROUPS_TEXT_DOMAIN), $dateHour, $dateMinute);
        } else {
            if ($currentYear != $dateYear) {
                foreach ($months as $monthName => $monthNumber) {
                    if ($monthNumber == $dateMonth) {
                        $outputDetails['text'] = "";
                        $outputDetails['unite'] = "";
                        $outputDetails['time'] =
                            $dateDay . " " . $monthName . ", " . $dateYear . " " . $dateHour . ":" . $dateMinute;
                        $output = $dateDay . " " . $monthName . ", " . $dateYear . " " . $dateHour . ":" . $dateMinute;
                    }
                }
            } else {
                foreach ($months as $monthName => $monthNumber) {
                    if ($monthNumber == $dateMonth) {
                        $outputDetails['text'] = "";
                        $outputDetails['unite'] = "";
                        $outputDetails['time'] = $dateDay . " " . $monthName . ", " . $dateHour . ":" . $dateMinute;
                        $output = $dateDay . " " . $monthName . ", " . $dateHour . ":" . $dateMinute;
                    }
                }
            }
        }

        if ($isDetails) {
            $output = $outputDetails;
        }

        return $output;
    }

    /**
     * Calcul du temps restant entre maintenant et une date à venir
     *
     * @param \DateTime $date
     *
     * @return int|string
     * @throws \Exception
     * @since 1.1.2
     */
    public static function timeRemaining(\DateTime $date): int|string
    {
        $now = new \DateTime();
        $futureDate = new \DateTime($date);

        $interval = $futureDate->diff($now);

        $days = $interval->format('%a');
        $hours = $interval->format('%h');
        $min = $interval->format('%i');
        $sec = $interval->format('%s');

        if ($days > 0) {
            return sprintf(__('In %s days', YS_GROUPS_TEXT_DOMAIN), $days);
        } elseif ($hours > 0) {
            return sprintf(__("In %sh", YS_GROUPS_TEXT_DOMAIN), $hours);
        } elseif ($min > 0) {
            return sprintf(__("In %smin", YS_GROUPS_TEXT_DOMAIN), $min);
        } elseif ($sec > 0) {
            return sprintf(__("In %ss", YS_GROUPS_TEXT_DOMAIN), $sec);
        } else {
            return 0;
        }
    }
}
