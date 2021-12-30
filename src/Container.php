<?php

namespace YsGroups;

use YsGroups\Admin\Admin;
use YsGroups\Front\Front;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Container de service pour la mise en place de l'injection de dependanec
 *
 * @since 1.0.7
 */
class Container
{
    /**
     * @return void
     */
    public static function load()
    {
        if (file_exists(dirname(__DIR__) . '/cache/container.php')) {
            require_once dirname(__DIR__) . '/cache/container.php';
            $container = new \YsGroupsCacheContainer();
        } else {
            $container = new ContainerBuilder();

            // Chargement de la configuration des services
            $loader = new YamlFileLoader(
                $container,
                new FileLocator(dirname(__DIR__) . '/config')
            );
            try {
                $loader->load('services.yml');
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            $container->compile();

            /**
             * creation du fichier de cache du container
             *
             * @todo supprimmer le fichier '/cache/container.php' à chaque modification du fichier de configuration 'config/services.yaml'
             * il sera generé automatiquement avec les nouvelles configurations
             */
            $dumper = new PhpDumper($container);
            file_put_contents(
                dirname(__DIR__) . '/cache/container.php',
                $dumper->dump(['class' => 'YsGroupsCacheContainer'])
            );
        }

        try {
            $container->get(Admin::class);
            $container->get(Session::class);
            $container->get(Front::class);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
