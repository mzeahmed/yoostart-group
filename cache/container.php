<?php

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\LogicException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class YsGroupsCacheContainer extends Container
{
    protected $parameters = [];

    public function __construct()
    {
        $this->services = $this->privates = [];
        $this->methodMap = [
            'YsGroups\\Api\\YsGroupsRestApi' => 'getYsGroupsRestApiService',
            'YsGroups\\Controller\\Admin\\Admin' => 'getAdminService',
            'YsGroups\\Controller\\Front\\Front' => 'getFrontService',
            'YsGroups\\Services\\Mailer' => 'getMailerService',
            'YsGroups\\Services\\NotLoggedInRedirections' => 'getNotLoggedInRedirectionsService',
            'YsGroups\\Services\\RewriteRules' => 'getRewriteRulesService',
            'YsGroups\\Services\\Session' => 'getSessionService',
        ];

        $this->aliases = [];
    }

    public function compile(): void
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled(): bool
    {
        return true;
    }

    public function getRemovedIds(): array
    {
        return [
            'Psr\\Container\\ContainerInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'YsGroups\\Container' => true,
            'YsGroups\\Controller\\Admin\\AdminGroups' => true,
            'YsGroups\\Controller\\Admin\\GroupListTable' => true,
            'YsGroups\\Controller\\Admin\\MetaBox' => true,
            'YsGroups\\Controller\\Front\\GroupsController' => true,
            'YsGroups\\Helpers\\Helpers' => true,
            'YsGroups\\Model\\Db' => true,
            'YsGroups\\Model\\DbSchema' => true,
            'YsGroups\\Model\\Groups' => true,
            'YsGroups\\Model\\GroupsMembers' => true,
            'YsGroups\\Model\\GroupsPosts' => true,
            'YsGroups\\Model\\PluginPosts' => true,
            'YsGroups\\OnPluginActivation' => true,
            'YsGroups\\YsGroups' => true,
            'YsGroups\\YsGroupsCustomPostType' => true,
        ];
    }

    /**
     * Gets the public 'YsGroups\Api\YsGroupsRestApi' shared autowired service.
     *
     * @return \YsGroups\Api\YsGroupsRestApi
     */
    protected function getYsGroupsRestApiService()
    {
        return $this->services['YsGroups\\Api\\YsGroupsRestApi'] = new \YsGroups\Api\YsGroupsRestApi();
    }

    /**
     * Gets the public 'YsGroups\Controller\Admin\Admin' shared autowired service.
     *
     * @return \YsGroups\Controller\Admin\Admin
     */
    protected function getAdminService()
    {
        return $this->services['YsGroups\\Controller\\Admin\\Admin'] = new \YsGroups\Controller\Admin\Admin(
            new \YsGroups\Controller\Admin\AdminGroups()
        );
    }

    /**
     * Gets the public 'YsGroups\Controller\Front\Front' shared autowired service.
     *
     * @return \YsGroups\Controller\Front\Front
     */
    protected function getFrontService()
    {
        return $this->services['YsGroups\\Controller\\Front\\Front'] = new \YsGroups\Controller\Front\Front(
            new \YsGroups\Controller\Front\GroupsController()
        );
    }

    /**
     * Gets the public 'YsGroups\Services\Mailer' shared autowired service.
     *
     * @return \YsGroups\Services\Mailer
     */
    protected function getMailerService()
    {
        return $this->services['YsGroups\\Services\\Mailer'] = new \YsGroups\Services\Mailer();
    }

    /**
     * Gets the public 'YsGroups\Services\NotLoggedInRedirections' shared autowired service.
     *
     * @return \YsGroups\Services\NotLoggedInRedirections
     */
    protected function getNotLoggedInRedirectionsService()
    {
        return $this->services['YsGroups\\Services\\NotLoggedInRedirections'] = new \YsGroups\Services\NotLoggedInRedirections();
    }

    /**
     * Gets the public 'YsGroups\Services\RewriteRules' shared autowired service.
     *
     * @return \YsGroups\Services\RewriteRules
     */
    protected function getRewriteRulesService()
    {
        return $this->services['YsGroups\\Services\\RewriteRules'] = new \YsGroups\Services\RewriteRules();
    }

    /**
     * Gets the public 'YsGroups\Services\Session' shared autowired service.
     *
     * @return \YsGroups\Services\Session
     */
    protected function getSessionService()
    {
        return $this->services['YsGroups\\Services\\Session'] = new \YsGroups\Services\Session();
    }
}
