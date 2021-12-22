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
            'YsGroups\\Admin\\Admin' => 'getAdminService',
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
            'YsGroups\\Admin\\GroupsList' => true,
            'YsGroups\\Admin\\Helpers' => true,
            'YsGroups\\Admin\\OnPluginActivation' => true,
            'YsGroups\\Admin\\Options' => true,
            'YsGroups\\Admin\\PostStates' => true,
            'YsGroups\\Container' => true,
            'YsGroups\\Model\\Db' => true,
            'YsGroups\\Model\\DbSchema' => true,
            'YsGroups\\Model\\Groups' => true,
            'YsGroups\\Model\\PluginPosts' => true,
            'YsGroups\\ViewRenderer\\View' => true,
            'YsGroups\\YsGroups' => true,
        ];
    }

    /**
     * Gets the public 'YsGroups\Admin\Admin' shared autowired service.
     *
     * @return \YsGroups\Admin\Admin
     */
    protected function getAdminService()
    {
        return $this->services['YsGroups\\Admin\\Admin'] = new \YsGroups\Admin\Admin(new \YsGroups\Admin\PostStates(), new \YsGroups\Admin\Options());
    }
}
