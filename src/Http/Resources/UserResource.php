<?php

namespace Perscom\Http\Resources;

use Perscom\Contracts\ResourceContract;
use Perscom\Http\Requests\Users\CreateUserRequest;
use Perscom\Http\Requests\Users\DeleteUserRequest;
use Perscom\Http\Requests\Users\GetUserRequest;
use Perscom\Http\Requests\Users\GetUsersRequest;
use Perscom\Http\Requests\Users\UpdateUserRequest;
use Saloon\Contracts\Response;

class UserResource extends Resource implements ResourceContract
{
    /**
     * @param int $page
     * @return Response
     */
    public function all(int $page = 1): Response
    {
        return $this->connector->send(new GetUsersRequest());
    }

    /**
     * @param int $id
     * @return Response
     */
    public function get(int $id): Response
    {
        return $this->connector->send(new GetUserRequest($id));
    }

    /**
     * @param array<string, mixed>  $data
     * @return Response
     */
    public function create(array $data): Response
    {
        return $this->connector->send(new CreateUserRequest($data));
    }

    /**
     * @param int $id
     * @param array<string, mixed>  $data
     * @return Response
     */
    public function update(int $id, array $data): Response
    {
        return $this->connector->send(new UpdateUserRequest($id, $data));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        return $this->connector->send(new DeleteUserRequest($id));
    }
}
