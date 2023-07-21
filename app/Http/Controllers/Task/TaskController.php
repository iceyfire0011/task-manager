<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Requests\Task\UserTaskAssignRequest;
use App\Models\Task\Task;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Common\HasResponseStructure;
use App\Models\User;
use App\Mail\NewTaskMail;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{

    use HasResponseStructure;

    public function create(TaskCreateRequest $request): JsonResponse
    {

        try {
            DB::beginTransaction();
            $task = Task::create($request->all());
            DB::commit();

            return $this->getTokenResponse('success', $task);
        } catch (Exception $e) {
            DB::rollback();
            return $this->getErrorBag('', 500, $e->getMessage());
        }
        return $this->getSuccessBag('Task created successfully', 200);
    }

    public function list(Request $request)
    {
        $limit = $request->get('limit', 20);
        $task = Task::paginate($limit);
        return $this->getSuccessResponse($task, 200);
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update($request->all());
        return $this->getSuccessBag('Task updated successfully', 200);
    }

    public function view(Task $task)
    {
        return $this->getSuccessResponse($task, 200);
    }

    public function delete(Task $task)
    {
        $task->delete();
        return $this->getSuccessBag('Task deleted successfully', 200);
    }

    public function assign(UserTaskAssignRequest $request, Task $task)
    {
        $assingeUser = User::find($request->assignee_id);
        $assignedTask = $assingeUser->sync($task);
        Mail::to($assingeUser->email)->queue(new NewTaskMail($assignedTask));
        return $this->getSuccessBag('Task assigned successfully', 200);
    }
}
