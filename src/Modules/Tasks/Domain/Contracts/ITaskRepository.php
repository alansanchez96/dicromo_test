<?php

namespace Src\Modules\Tasks\Domain\Contracts;

use Src\Modules\Tasks\Infrastructure\Database\Task;

interface ITaskRepository
{
    public function getById(array $data): int|Task;

    // public function get(array $data): int|Task;

    public function collection(array $data);

    public function create(array $data): int|Task;

    public function update(Task $task, array $data): int|Task;

    public function delete(Task $task): int|Task;
}