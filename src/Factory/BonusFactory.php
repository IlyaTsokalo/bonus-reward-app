<?php

namespace App\Factory;

use App\Entity\Bonus;
use App\Repository\BonusRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Bonus>
 *
 * @method        Bonus|Proxy                     create(array|callable $attributes = [])
 * @method static Bonus|Proxy                     createOne(array $attributes = [])
 * @method static Bonus|Proxy                     find(object|array|mixed $criteria)
 * @method static Bonus|Proxy                     findOrCreate(array $attributes)
 * @method static Bonus|Proxy                     first(string $sortedField = 'id')
 * @method static Bonus|Proxy                     last(string $sortedField = 'id')
 * @method static Bonus|Proxy                     random(array $attributes = [])
 * @method static Bonus|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BonusRepository|RepositoryProxy repository()
 * @method static Bonus[]|Proxy[]                 all()
 * @method static Bonus[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Bonus[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Bonus[]|Proxy[]                 findBy(array $attributes)
 * @method static Bonus[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Bonus[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class BonusFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(255),
            'rewardId' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Bonus $bonus): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Bonus::class;
    }
}
