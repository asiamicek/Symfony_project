<?php

namespace Container57IklxC;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPersistCacheHandlerService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Guides\Handlers\PersistCacheHandler' shared autowired service.
     *
     * @return \phpDocumentor\Guides\Handlers\PersistCacheHandler
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Guides/Handlers/PersistCacheHandler.php';
        include_once \dirname(__DIR__, 4).'/src/Guides/RestructuredText/Meta/CachedMetasLoader.php';
        include_once \dirname(__DIR__, 4).'/src/Guides/Metas.php';

        return $container->privates['phpDocumentor\\Guides\\Handlers\\PersistCacheHandler'] = new \phpDocumentor\Guides\Handlers\PersistCacheHandler(($container->privates['phpDocumentor\\Guides\\RestructuredText\\Meta\\CachedMetasLoader'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Meta\\CachedMetasLoader'] = new \phpDocumentor\Guides\RestructuredText\Meta\CachedMetasLoader())), ($container->privates['phpDocumentor\\Guides\\Metas'] ?? ($container->privates['phpDocumentor\\Guides\\Metas'] = new \phpDocumentor\Guides\Metas())));
    }
}
