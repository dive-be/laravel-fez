<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\Container;
use Illuminate\Support\Traits\Conditionable;
use Tests\Fakes\Components\RickRollComponent;
use Tests\Fakes\Components\RickRollContainer;

beforeEach(function () {
    $this->container = RickRollContainer::make();
});

it('can be cleared', function () {
    $this->container->push(RickRollComponent::make());

    expect($this->container)->toHaveCount(1);

    $this->container->clear();

    expect($this->container)->toHaveCount(0);
});

it('can get a component', function () {
    $this->container->set('rick', $astley = RickRollComponent::make());

    expect($this->container->get('rick'))->toBe($astley);
    expect($this->container->get('astley'))->toBeNull();
});

it('can __get a component', function () {
    $this->container->set('rick', $astley = RickRollComponent::make());

    expect($this->container->rick)->toBe($astley);
    expect($this->container->astley)->toBeNull();
});

it('can __call and get a component', function () {
    $this->container->set('rick', $astley = RickRollComponent::make());

    expect($this->container->rick())->toBe($astley);
});

it('can check if a component exists', function () {
    $this->container->set('rick', RickRollComponent::make());

    expect($this->container->has('rick'))->toBeTrue();
    expect($this->container->has('astley'))->toBeFalse();
});

it('can push a component', function () {
    $this->container->push($rick = RickRollComponent::make());

    expect($this->container)->toHaveCount(1);
    expect($this->container->get(0))->toBe($rick);
});

it('can push many components', function () {
    $this->container->pushMany([
        $rick = RickRollComponent::make(),
        $astley = RickRollComponent::make(),
    ]);

    expect($this->container)->toHaveCount(2);
    expect($this->container->get(0))->toBe($rick);
    expect($this->container->get(1))->toBe($astley);
});

it('can remove a component', function () {
    $this->container->set('rick', RickRollComponent::make());
    $this->container->push(RickRollComponent::make());

    expect($this->container)->toHaveCount(2);

    $this->container->remove('rick');
    $this->container->remove(0);

    expect($this->container)->toHaveCount(0);
});

it('can set components', function () {
    $this->container->set('rick', RickRollComponent::make());

    expect($this->container)->toHaveCount(1);
});

it('can __set components', function () {
    $this->container->rick = RickRollComponent::make();

    expect($this->container)->toHaveCount(1);
});

it('can __call and set components', function () {
    $this->container->rick(RickRollComponent::make());

    expect($this->container)->toHaveCount(1);
});

it('is arrayable', function () {
    $this->container->push($rick = RickRollComponent::make());
    $this->container->push($rick);
    $this->container->push($rick);

    expect(
        $this->container->toArray()
    )->toMatchArray([
        $rick->toArray(),
        $rick->toArray(),
        $rick->toArray(),
    ]);
});

it('is conditionable', function () {
    expect(class_uses(Container::class))->toContain(Conditionable::class);
});

it('is countable', function () {
    expect($this->container)->toHaveCount(0);

    $this->container->push(RickRollComponent::make());

    expect($this->container)->toHaveCount(1);
});

it('is renderable', function () {
    $this->container->push($rick = RickRollComponent::make());
    $this->container->push($rick);
    $this->container->push($rick);

    expect(
        $this->container->render()
    )->toBe(
        $rick->render() . PHP_EOL .
        $rick->render() . PHP_EOL .
        $rick->render()
    );
});

test('array access', function () {
    $this->container->set('rick', $rick = RickRollComponent::make());

    expect(empty($this->container['rick']))->toBeFalse(); // offsetExists

    expect($this->container['rick'])->toBe($rick); // offsetGet

    $this->container['astley'] = $astley = RickRollComponent::make();

    expect($this->container->get('astley'))->toBe($astley); // offsetSet

    unset($this->container['rick']);

    expect(isset($this->container['rick']))->toBeFalse(); // offsetUnset
});

test('iterator aggregate', function () {
    $this->container->set('rick', $rick = RickRollComponent::make());

    foreach ($this->container as $key => $value) {
        expect($key)->toBe('rick');
        expect($value)->toBe($rick);
    }
});
