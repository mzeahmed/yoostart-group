<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
            'YsGroup\\Controller\\Admin\\Admin' => 'getAdminService',
            'YsGroup\\Controller\\Front\\Front' => 'getFrontService',
            'YsGroup\\Services\\FixSomeErrors' => 'getFixSomeErrorsService',
            'YsGroup\\Services\\Mailer' => 'getMailerService',
            'YsGroup\\Services\\NotLoggedInRedirections' => 'getNotLoggedInRedirectionsService',
            'YsGroup\\Services\\RestApi' => 'getRestApiService',
            'YsGroup\\Services\\RewriteRules' => 'getRewriteRulesService',
            'YsGroup\\Services\\Session' => 'getSessionService',
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
            'YsGroup\\Container' => true,
            'YsGroup\\Controller\\Admin\\AdminGroups' => true,
            'YsGroup\\Controller\\Admin\\GroupListTable' => true,
            'YsGroup\\Controller\\Admin\\Metaboxs\\PostMetas\\CoverPhotoMetaBox' => true,
            'YsGroup\\Controller\\Admin\\Metaboxs\\PostMetas\\GroupAdminMetabox' => true,
            'YsGroup\\Controller\\Admin\\Metaboxs\\PostMetas\\GroupIdMetaBox' => true,
            'YsGroup\\Controller\\Admin\\Metaboxs\\PostMetas\\StatusMetaBox' => true,
            'YsGroup\\Controller\\Admin\\Metaboxs\\TermMetas\\YsGroupsMemberTermMeta' => true,
            'YsGroup\\Controller\\Admin\\YsGroupCPT' => true,
            'YsGroup\\Controller\\Admin\\YsGroupPostCPT' => true,
            'YsGroup\\Controller\\Api\\YsGroupPostRestController' => true,
            'YsGroup\\Controller\\Front\\GroupPostsController' => true,
            'YsGroup\\Controller\\Front\\GroupsController' => true,
            'YsGroup\\Helpers\\Helpers' => true,
            'YsGroup\\Model\\Db' => true,
            'YsGroup\\Model\\DbSchema' => true,
            'YsGroup\\Model\\Groups' => true,
            'YsGroup\\Model\\GroupsMembers' => true,
            'YsGroup\\Model\\GroupsPosts' => true,
            'YsGroup\\Model\\PluginPosts' => true,
            'YsGroup\\OnPluginActivation' => true,
            'YsGroup\\YsGroup' => true,
        ];
    }

    /**
     * Gets the public 'YsGroup\Controller\Admin\Admin' shared autowired service.
     *
     * @return \YsGroup\Controller\Admin\Admin
     */
    protected function getAdminService()
    {
        return $this->services['YsGroup\\Controller\\Admin\\Admin'] = new \YsGroup\Controller\Admin\Admin(new \YsGroup\Controller\Admin\AdminGroups(), new \YsGroup\Controller\Admin\YsGroupCPT(), new \YsGroup\Controller\Admin\Metaboxs\PostMetas\StatusMetaBox(), new \YsGroup\Controller\Admin\Metaboxs\PostMetas\GroupAdminMetabox(), new \YsGroup\Controller\Admin\Metaboxs\PostMetas\CoverPhotoMetaBox(), new \YsGroup\Controller\Admin\YsGroupPostCPT(), new \YsGroup\Controller\Admin\Metaboxs\PostMetas\GroupIdMetaBox(), new \YsGroup\Controller\Admin\Metaboxs\TermMetas\YsGroupsMemberTermMeta());
    }

    /**
     * Gets the public 'YsGroup\Controller\Front\Front' shared autowired service.
     *
     * @return \YsGroup\Controller\Front\Front
     */
    protected function getFrontService()
    {
        return $this->services['YsGroup\\Controller\\Front\\Front'] = new \YsGroup\Controller\Front\Front(new \YsGroup\Controller\Front\GroupsController());
    }

    /**
     * Gets the public 'YsGroup\Services\FixSomeErrors' shared autowired service.
     *
     * @return \YsGroup\Services\FixSomeErrors
     */
    protected function getFixSomeErrorsService()
    {
        return $this->services['YsGroup\\Services\\FixSomeErrors'] = new \YsGroup\Services\FixSomeErrors();
    }

    /**
     * Gets the public 'YsGroup\Services\Mailer' shared autowired service.
     *
     * @return \YsGroup\Services\Mailer
     */
    protected function getMailerService()
    {
        return $this->services['YsGroup\\Services\\Mailer'] = new \YsGroup\Services\Mailer();
    }

    /**
     * Gets the public 'YsGroup\Services\NotLoggedInRedirections' shared autowired service.
     *
     * @return \YsGroup\Services\NotLoggedInRedirections
     */
    protected function getNotLoggedInRedirectionsService()
    {
        return $this->services['YsGroup\\Services\\NotLoggedInRedirections'] = new \YsGroup\Services\NotLoggedInRedirections();
    }

    /**
     * Gets the public 'YsGroup\Services\RestApi' shared autowired service.
     *
     * @return \YsGroup\Services\RestApi
     */
    protected function getRestApiService()
    {
        return $this->services['YsGroup\\Services\\RestApi'] = new \YsGroup\Services\RestApi(new \YsGroup\Controller\Api\YsGroupPostRestController());
    }

    /**
     * Gets the public 'YsGroup\Services\RewriteRules' shared autowired service.
     *
     * @return \YsGroup\Services\RewriteRules
     */
    protected function getRewriteRulesService()
    {
        return $this->services['YsGroup\\Services\\RewriteRules'] = new \YsGroup\Services\RewriteRules();
    }

    /**
     * Gets the public 'YsGroup\Services\Session' shared autowired service.
     *
     * @return \YsGroup\Services\Session
     */
    protected function getSessionService()
    {
        return $this->services['YsGroup\\Services\\Session'] = new \YsGroup\Services\Session();
    }
}
