<?php

namespace YsGroups\Admin;

use YsGroups\Model\Groups;

class GroupListTable extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct([
            'singular' => 'Group',
            'plural' => 'Groups',
            'ajax' => false,
        ]);
    }

    /**
     * @return void
     * @since 1.0.7
     */
    public function prepare_items()
    {
        $perPage = 10;

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];
        // $this->process_bulk_action();

        $orderBy = (isset($_REQUEST['orderby'])) ? esc_sql($_REQUEST['orderby']) : 'created_at';
        $order = (isset($_REQUEST['order'])) ? esc_sql($_REQUEST['order']) : 'DESC';

        $items = (new Groups())->getGroups($orderBy, $order);

        $current_page = $this->get_pagenum();
        $total_items = count($items);
        $items = array_slice($items, (($current_page - 1) * $perPage), $perPage);
        $this->items = $items;

        $this->set_pagination_args([
            'per_page' => $perPage,
            'total_items' => $total_items,
            'total_pages' => ceil($total_items / $perPage),
        ]);
    }

    /**
     * Affiche un message si aucun élément n'a été trouvé
     *
     * @return void
     * @since 1.0.7
     */
    public function no_items()
    {
        _e('No groups found', YS_GROUPS_TEXT_DOMAIN);
    }

    /**
     * Récupére un tableau associatif d'actions de masse disponibles sur cette table.
     *
     * @return array
     * @since 1.0.7
     */
    protected function get_bulk_actions(): array
    {
        return [
            'delete' => _x('Delete', 'List table bulk action', YS_GROUPS_TEXT_DOMAIN),
        ];
    }

    /**
     * @return void
     * @see   $this->prepare_items()
     * @since 1.0.8
     */
    // protected function process_bulk_action()
    // {
    //     // Supression
    //     if ('do_delete' === $this->current_action()) {
    //         $groups_ids = $_REQUEST['gid'] ?? [];
    //
    //         if (is_array($groups_ids)) {
    //             $groups_ids = implode(',', $groups_ids);
    //         }
    //
    //         if (! empty($groups_ids)) {
    //             (new Groups())->deleteGroup($groups_ids);
    //         }
    //     }
    // }

    /**
     * @return array
     * @see   \WP_List_Table::single_row_columns()
     * @since 1.0.7
     */
    public function get_columns(): array
    {
        return apply_filters('ys_group_list_table_get_columns', [
            'cb' => '<input type="checkbox"/>',
            'name' => _x('Name', 'Column label', YS_GROUPS_TEXT_DOMAIN),
            'creator_id' => _x('Author', 'Column label', YS_GROUPS_TEXT_DOMAIN),
            'description' => _x('Description', 'Column label', YS_GROUPS_TEXT_DOMAIN),
            'created_at' => _x('Created at', 'Column label', YS_GROUPS_TEXT_DOMAIN),
            'status' => _x('Status', 'Column lable', YS_GROUPS_TEXT_DOMAIN),
        ]);
    }

    /**
     * @return array
     * @since 1.0.7
     */
    public function get_sortable_columns(): array
    {
        return apply_filters('ys_group_list_table_get_sortable_columns', [
            'name' => ['name', true],
            'created_at' => ['created_at', true],
        ]);
    }

    /**
     * @param object $item
     * @param string $column_name
     *
     * @return string
     * @since 1.0.7
     */
    protected function column_default($item, $column_name): string
    {
        return $item[$column_name];
    }

    /**
     * @param $item
     *
     * @return string
     * @since 1.0.7
     */
    protected function column_cb($item): string
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item['id']
        );
    }

    /**
     * @param $item
     *
     * @return string
     * @since 1.0.7
     */
    protected function column_name($item): string
    {
        $page = wp_unslash($_REQUEST['page']);

        $edit_query_args = [
            'page' => $page,
            'action' => 'edit',
            'gid' => $item['id'],
        ];

        $actions['edit'] = sprintf(
            '<a href="%1$s">%2$s</a>',
            esc_url(
                wp_nonce_url(add_query_arg($edit_query_args, 'admin.php'), 'edit' . $item['id'])
            ),
            _x('Edit', 'List table row action', YS_GROUPS_TEXT_DOMAIN)
        );

        $delete_query_args = [
            'page' => $page,
            'action' => 'delete',
            'gid' => $item['id'],
        ];

        $actions['delete'] = sprintf(
            '<a class="js-ys-group-delete" href="%1$s" data-group-id="%2$s">%3$s</a>',
            esc_url(
                wp_nonce_url(add_query_arg($delete_query_args, 'admin.php'), 'delete' . $item['id'])
            ),
            $item['id'],
            _x('Delete', 'List table row action', YS_GROUPS_TEXT_DOMAIN)
        );

        return sprintf(
            '%1$s <span style="color:silver;">(id:%2$s)</span>%3$s',
            $item['name'],
            $item['id'],
            $this->row_actions($actions)
        );
    }

    /**
     * @param array $item
     *
     * @return string
     * @since 1.0.7
     */
    protected function column_creator_id(array $item): string
    {
        $user = \WP_User::get_data_by('id', $item['creator_id']);

        return $user->display_name;
    }

    /**
     * @param $item
     *
     * @return string|null
     * @since 1.0.8
     */
    protected function column_description($item): ?string
    {
        if (strlen($item['description']) >= 50) {
            return substr($item['description'], 0, 50) . '...';
        }

        return $item['description'];
    }

    /**
     * @param $item
     *
     * @return string
     * @throws \Exception
     */
    protected function column_created_at($item): string
    {
        $date = new \DateTime($item['created_at']);

        return $date->format('d-m-Y H:i:s');
    }

    /**
     * @param $item
     *
     * @return void
     * @since 1.0.9
     */
    public function single_row($item)
    {
        echo '<tr class="ys-group-list-row">';
        $this->single_row_columns($item);
        echo '</tr>';
    }
}
