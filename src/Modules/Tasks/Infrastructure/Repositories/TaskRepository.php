<?php

namespace Src\Modules\Tasks\Infrastructure\Repositories;

use Illuminate\Container\Attributes\Auth;
use Src\Common\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Tasks\Infrastructure\Database\Task;
use Src\Modules\Tasks\Domain\Contracts\ITaskRepository;
use Src\Modules\Tasks\Infrastructure\Exceptions\TaskException;

class TaskRepository extends BaseRepository implements ITaskRepository
{
    public function __construct(private readonly Task $task) { parent::__construct(); }

    public function getbyId(array $data): int|Task
    {
        try {
            $q = $this->task->query();

            $task = $q->where(column: 'id', value: $data['id'])->where('user_id', '=', $data['user_id'])->first();

            if (!$task) throw new TaskException('No se encontro la tarea', 422);

            return $task;
        } catch (TaskException $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);
            
            return $e->getCode();
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return 500;
        }
    }

    // public function get(array $data): int|Task
    // {
    //     try {
    //         // DB::beginTransaction();

    //         // $q = $this->task;
    //         // dd($data);
    //         // $task = 
    //         $task = collect($data)->reduce(function ($query, $filter) {
    //             return $query->where($filter[0], '=', $filter[1]);
    //         }, DB::table('tasks'));
    //         dd($task->get());
    //         if (!$task) throw new TaskException('No se encontro la tarea', 422);

    //         return $task;
    //     } catch (TaskException $e) {
    //         // DB::rollBack();
    //         $this->log->create(['class' => self::class, 'line' => $e->getLine()]);
            
    //         return $e->getCode();
    //     } catch (\Exception $e) {
    //         // DB::rollBack();
    //         $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

    //         return 500;
    //     }
    // }

    public function collection(array $data): int|Collection
    {
        try {
            $q = $this->task->query();

            return $q->where('user_id', $data['user_id'])->get();
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return 500;
        }
    }

    public function create(array $data): int|Task
    {
        $input = [
            'user_id' => auth()->userOrFail()->id ?? $data['user_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'],
        ];

        try {
            $task = Task::create($input);

            if (!$task) throw new TaskException('No se ha podido crear la tarea', 422);

            return $task;
        } catch (TaskException $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);
            
            return $e->getCode();
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return 500;
        }
    }

    public function update(Task $task, array $data): int|Task
    {
        try {
            $task->update($data);

            if ($task->wasChanged()) return $task->refresh();

            throw new TaskException('No se ha podido actualizar', 422);

        } catch (TaskException $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);
            
            return $e->getCode();
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return 500;
        }
    }

    public function delete(Task $task): int|Task
    {
        try {
            return $task->delete();
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return 500;
        }
    }
}