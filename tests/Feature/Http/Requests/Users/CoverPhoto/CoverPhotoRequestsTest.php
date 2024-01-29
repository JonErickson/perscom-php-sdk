<?php

use Perscom\Http\Requests\Users\ProfilePhoto\CreateUserProfilePhotoRequest;
use Perscom\Http\Requests\Users\ProfilePhoto\DeleteUserProfilePhotoRequest;
use Perscom\PerscomConnection;
use Saloon\Contracts\Request;
use Saloon\Data\MultipartValue;
use Saloon\Exceptions\SaloonException;
use Saloon\Helpers\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;

beforeEach(function () {
    Config::preventStrayRequests();

    $this->mockClient = new MockClient([
        CreateUserProfilePhotoRequest::class => MockResponse::make([
            'profile_photo' => 'foo'
        ], 200),
        DeleteUserProfilePhotoRequest::class => MockResponse::make([], 201),
    ]);

    $this->connector = new PerscomConnection('foo', 'bar');
    $this->connector->withMockClient($this->mockClient);
});

test('it will throw an exception if the file does not exist', function () {
    $this->connector->users()->cover_photo(1)->create('foobar');
})->expectException(SaloonException::class);

test('it can get set the users profile_photo', function () {
    $response = $this->connector->users()->profile_photo(1)->create(dirname(__FILE__).'/image.png');

    $data = $response->json();

    expect($response->status())->toEqual(200)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($response->getRequest()->query()->all())->toContainOnlyInstancesOf(MultipartValue::class)
        ->and($data)->toEqual([
            'profile_photo' => 'foo',
        ]);

    $this->mockClient->assertSent(CreateUserProfilePhotoRequest::class);
});

test('it can delete a users profile_photo', function () {
    $response = $this->connector->users()->profile_photo(1)->delete();

    $data = $response->json();

    expect($response->status())->toEqual(201)
        ->and($response)->toBeInstanceOf(Response::class)
        ->and($data)->toEqual([]);

    $this->mockClient->assertSent(function (Request $request) {
        return $request instanceof DeleteUserProfilePhotoRequest
            && $request->relationId === 1;
    });
});
