<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Hydration;

/**
 * @template T of object
 *
 * @implements \IteratorAggregate<int,T>
 */
abstract class HydratableFromArray implements \IteratorAggregate, \Countable
{
    /** @var array<int,T> */
    private array $items = [];

    protected static function targetClass(): string
    {
        return static::class;
    }

    /** @param T ...$items */
    public function __construct(object ...$items)
    {
        $target = static::targetClass();
        foreach ($items as $i) {
            if (!$i instanceof $target) {
                $got = get_debug_type($i);
                throw new \TypeError("Expected instances of {$target}, got {$got}");
            }
            $this->items[] = $i;
        }
    }

    /** @param array<int,array<string,mixed>> $data */
    public static function fromArray(array $data): static
    {
        $objs = array_map(
            static fn (array $row) => Hydrator::hydrate(static::targetClass(), $row, static::class),
            $data
        );

        return new static(...$objs);
    }

    /** @return array<int,T> */
    public function all(): array
    {
        return $this->items;
    }

    /** @return \Traversable<int,T> */
    public function getIterator(): \Traversable
    {
        yield from $this->items;
    }

    public function count(): int
    {
        return \count($this->items);
    }
}
