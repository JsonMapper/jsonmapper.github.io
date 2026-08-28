<?php

/**
 * Classes the documentation refers to but this repository cannot install.
 *
 * Two kinds live here:
 *
 * - Classes standing in for the reader's own application (`App\…`). They are
 *   deliberately fictional; the examples exist to show the shape of the call.
 * - JsonMapper's companion packages whose own dependencies conflict with Hyde's,
 *   so they cannot be dev dependencies here. `json-mapper/laravel-package` and
 *   `monolog/monolog` do install, and are required in composer.json instead of
 *   being stubbed, so those pages are checked against the real classes.
 *
 * These are signatures only — nothing here is executed.
 */

declare(strict_types=1);

namespace App\Shapes {
    abstract class AbstractShape
    {
    }

    class ShapeInstanceFactory
    {
        public function __invoke(object $data): AbstractShape
        {
            throw new \LogicException('Stub.');
        }
    }

    class AbstractShapeWrapper
    {
        /** @var AbstractShape */
        public $shape;
    }
}

namespace App\Models {
    /** Stands in for the reader's Eloquent model. */
    class License
    {
        public function save(): bool
        {
            throw new \LogicException('Stub.');
        }
    }
}

namespace App {
    /** Stands in for the reader's own JsonMapper subclass. */
    class YourExtendedJsonMapper extends \JsonMapper\JsonMapper
    {
    }
}

namespace JsonMapper\EloquentMiddleware {
    /** json-mapper/eloquent-middleware — conflicts with Hyde's dependencies. */
    class EloquentMiddleware extends \JsonMapper\Middleware\AbstractMiddleware
    {
        /** @var \Psr\SimpleCache\CacheInterface */
        private $cache;

        public function __construct(\Psr\SimpleCache\CacheInterface $cache)
        {
            $this->cache = $cache;
        }

        public function handle(
            \stdClass $json,
            \JsonMapper\Wrapper\ObjectWrapper $object,
            \JsonMapper\ValueObjects\PropertyMap $map,
            \JsonMapper\JsonMapperInterface $mapper
        ): void {
        }
    }
}

namespace JsonMapper\SymfonyBundle {
    /** json-mapper/symfony-bundle — conflicts with Hyde's dependencies. */
    class JsonMapperBundle
    {
    }
}
