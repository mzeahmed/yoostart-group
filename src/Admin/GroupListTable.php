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
     * @return array
     * @see \WP_List_Table::single_row_columns()
     */
    public function get_columns(): array
    {
        return [
            'cb' => '<input type="checkbox"/>',
            'name' => _x('Name', 'Column label', YS_GROUPS_TEXT_DOMAIN),
        ];
    }

    /**
     * @return array[]
     */
    public function get_sortable_columns(): array
    {
        return [
            'name' => ['name', false],
        ];
    }

    /**
     * @param object $item
     * @param string $column_name
     *
     * @return string
     */
    protected function column_default($item, $column_name): string
    {
        switch ($column_name) {
            case 'name':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    /**
     * @param $item
     *
     * @return string
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
     */
    protected function column_name($item): string
    {
        $page = wp_unslash($_REQUEST['page']);

        $edit_query_args = [
            'page' => $page,
            'action' => 'edit',
            'ysgroup' => $item['id'],
        ];

        $actions['edit'] = sprintf(
            '<a href="%1$s">%2$s</a>',
            esc_url(
                wp_nonce_url(add_query_arg($edit_query_args, 'admin.php'), 'editysgroup_' . $item['id'])
            ),
            _x('Edit', 'List table row action', YS_GROUPS_TEXT_DOMAIN)
        );

        $delete_query_args = [
            'page' => $page,
            'action' => 'delete',
            'ysgroup' => $item['id'],
        ];

        $actions['delete'] = sprintf(
            '<a href="%1$s">%2$s</a>',
            esc_url(
                wp_nonce_url(add_query_arg($delete_query_args, 'admin.php'), 'deleteysgroup_' . $item['id'])
            ),
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
     * @return array
     */
    protected function get_bulk_actions(): array
    {
        return [
            'delete' => _x('Delete', 'List table bulk action', YS_GROUPS_TEXT_DOMAIN),
        ];
    }

    /**
     * @return void
     * @see $this->prepare_items()
     */
    protected function process_bulk_action()
    {
        if ('delete' === $this->current_action()) {
            // Methode de suppression ici
        }
    }

    public function prepare_items()
    {
        $perPage = 5;

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];
        $this->process_bulk_action();

        $data = (new Groups())->getGroups();
        // dump($data);
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data, (($current_page - 1) * $perPage), $perPage);
        $this->items = $data;

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $perPage,
            'total_pages' => ceil($total_items / $perPage),
        ]);
    }
}
