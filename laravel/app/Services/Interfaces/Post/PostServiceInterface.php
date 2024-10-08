<?php

namespace App\Services\Interfaces\Post;

interface PostServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);

    public function getAllPost();

    public function getPost(array $conditions = []);
}
