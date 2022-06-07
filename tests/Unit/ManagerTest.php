<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\Exceptions\UnknownFeatureException;
use Illuminate\Support\Collection;
use Tests\Fakes\Components\RickRollComponent;
use Tests\Fakes\Components\RickRollContainer;

beforeEach(function () {
    $this->fez = createFez();
});

it('can assign / override an existing feature', function () {
    $rick = $this->fez->get('rick');

    $this->fez->assign('rick', RickRollContainer::make());

    expect($this->fez->get('rick'))->not->toBe($rick);
});

it('can clone itself with(out) the given features', function () {
    expect($this->fez->except('rick'))
        ->not->toBe($this->fez)
        ->has('rick')->toBeFalse()
        ->has('roll')->toBeTrue();

    expect($this->fez->only('roll'))
        ->not->toBe($this->fez)
        ->has('rick')->toBeFalse()
        ->has('roll')->toBeTrue();
});

it('can retrieve all features as a collection', function () {
    expect($this->fez->features())
        ->toBeInstanceOf(Collection::class)
        ->toHaveKeys(['rick', 'roll'])
        ->toHaveCount(2);
});

it('can flush all underlying components', function () {
    $container = $this->fez->get('roll');
    $container->push(RickRollComponent::make());

    expect($container)->toHaveCount(1);

    $this->fez->flush();

    expect($container)->toHaveCount(0);
});

it('can get a feature', function () {
    expect($this->fez->get('rick'))->toBeInstanceOf(RickRollComponent::class);
});

it('can __get a feature', function () {
    expect($this->fez->rick)->toBeInstanceOf(RickRollComponent::class);
});

it('can __set a feature', function () {
    $rick = $this->fez->get('rick');

    $this->fez->rick = RickRollComponent::make();

    expect($rick)->not->toBe($this->fez->rick);
});

it('can __call and get a feature', function () {
    expect($this->fez->rick())->toBeInstanceOf(RickRollComponent::class);
});

it('throws if an unknown feature is gotten', function () {
    $this->fez->get('gibberish');
})->throws(UnknownFeatureException::class);

it('can check if a feature exists', function () {
    expect($this->fez->has('rick'))->toBeTrue();
    expect($this->fez->has('gibberish'))->toBeFalse();
});

it('is arrayable', function () {
    $this->fez->get('roll')->pushMany([$this->fez->get('rick')]);

    expect($this->fez->toArray())->toBe([
        'rick' => ['type' => 'rick_roll', 'value' => 'Never Gonna Give You Up'],
        'roll' => [
            ['type' => 'rick_roll', 'value' => 'Never Gonna Give You Up'],
        ],
    ]);
});

it('is renderable', function () {
    $this->fez->get('roll')->pushMany([
       $this->fez->get('rick'),
       $this->fez->get('rick'),
    ]);

    expect($this->fez->render())->toBe(
        'Never Gonna Give You Up' . PHP_EOL . PHP_EOL . // rick
        'Never Gonna Give You Up' . PHP_EOL . // roll
        'Never Gonna Give You Up' // roll
    );
});
