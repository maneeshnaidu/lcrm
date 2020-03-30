<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests\TaskRequest;
use App\Repositories\OptionRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    private $organizationRepository;
    private $taskRepository;
    private $optionRepository;

    /**
     * TaskController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        OrganizationRepository $organizationRepository,
        TaskRepository $taskRepository,
        OptionRepository $optionRepository
    ) {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->organizationRepository = $organizationRepository;
        $this->taskRepository = $taskRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'task');
    }

    public function index()
    {
        $title = trans('task.tasks');
        $users = $this->organizationRepository->getStaffWithUser()->get()
            ->map(function ($user) {
                return [
                    'name' => $user->full_name.' ( '.$user->email.' )',
                    'id' => $user->id,
                ];
            })
            ->pluck('name', 'id')->prepend(trans('task.user'), '');

        $totalTasks = $this->taskRepository->getAll()->count();
        $notStartedTasks = $this->taskRepository->getAll()->where('status','Not Started')->count();
        $inProgressTasks = $this->taskRepository->getAll()->where('status','In Progress')->count();
        $pendingTasks = $this->taskRepository->getAll()->where('status','Pending')->count();
        $completedTasks = $this->taskRepository->getAll()->where('status','Completed')->count();

        $user = $this->getUser();
        $totalTasksToMe = $this->taskRepository->getAll()->where('assigned_to',$user->id)->count();
        $notStartedTasksToMe = $this->taskRepository->getAll()->where('assigned_to',$user->id)->where('status','Not Started')->count();
        $inProgressTasksToMe = $this->taskRepository->getAll()->where('assigned_to',$user->id)->where('status','In Progress')->count();
        $pendingTasksToMe = $this->taskRepository->getAll()->where('assigned_to',$user->id)->where('status','Pending')->count();
        $completedTasksToMe = $this->taskRepository->getAll()->where('assigned_to',$user->id)->where('status','Completed')->count();

        return view('user.task.index', compact('title', 'users','totalTasks','notStartedTasks','inProgressTasks',
            'pendingTasks','completedTasks','totalTasksToMe','notStartedTasksToMe','inProgressTasksToMe',
            'pendingTasksToMe','completedTasksToMe'));
    }

    public function create()
    {
        $title = trans('task.new');
        $this->generateParams();

        return view('user.task.create', compact('title'));
    }

    public function store(TaskRequest $request)
    {
        $user = $this->userRepository->getUser();
        $organization = $this->userRepository->getOrganization();
        $request->merge(['user_id'=>$user->id,'organization_id'=> $organization->id]);
        $this->taskRepository->create($request->all());

        return redirect('task');
    }

    public function edit($task)
    {
        $this->generateParams();
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $title = trans('task.edit');

        return view('user.task.edit', compact('title', 'task'));
    }

    public function update($task, Request $request)
    {
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $task->update($request->all());
        return redirect('task');
    }

    public function show($task)
    {
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $this->generateParams();
        $title = trans('task.show');
        $action = trans('action.show');
        return view('user.task.show', compact('title', 'task', 'action'));
    }

    public function delete($task)
    {
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $this->generateParams();
        $title = trans('task.delete');
        return view('user.task.delete', compact('title', 'task'));
    }

    public function destroy($task)
    {
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $task->delete();
        return redirect('task');
    }

    public function data()
    {
        $orgRole = $this->getUser()->orgRole;
        $dateTimeFormat = config('settings.date_time_format');
        $tasks = $this->taskRepository->getAll();
        $tasks = $tasks->map(function ($task) use ($orgRole,$dateTimeFormat){
                return [
                    'id' => $task->id,
                    'assigned_to' => $task->taskAssignedTo?$task->taskAssignedTo->full_name:'',
                    'subject' => $task->subject,
                    'start_date' => date($dateTimeFormat,strtotime($task->start_date)),
                    'due_date' => date($dateTimeFormat,strtotime($task->due_date)),
                    'priority' => $task->priority,
                    'status' => $task->status,
                    'orgRole' => $orgRole,
                ];
            });

        return DataTables::of($tasks)
            ->addColumn('actions', '<a href="{{ url(\'task/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                     <a href="{{ url(\'task/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    <a href="{{ url(\'task/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>')
            ->rawColumns(['actions'])
            ->make();
    }

    public function updateStatus($task,Request $request){
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $task->status = $request->status;
        $task->save();
        return redirect('task');
    }

    public function tasksKanbanIndex(){
        $title = trans('task.tasks_kanban');
        $this->generateParams();
        $tasks = $this->taskRepository->getAll();
        return view('user.task.kanban', compact('title','tasks'));
    }

    public function storeKanbanTask(Request $request)
    {
        $user = $this->userRepository->getUser();
        $organization = $this->userRepository->getOrganization();
        $request->merge(['user_id'=>$user->id,'organization_id'=> $organization->id]);
        $this->taskRepository->create($request->all());
        flash(trans('task.created_successfully').'.')->success();
        return redirect('task/kanban');
    }

    public function tasksKanbanUpdate($task, Request $request){
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $task->status = $request->status;
        $task->save();
        echo '<div class="alert alert-success">' . trans('task.updated_successfully').'.' . '</div>';
    }

    public function kanbanShowTask($task){
        $task = $this->taskRepository->getAll()->find($task);
        if (!isset($task)){
            return view('errors.404');
        }
        $dateTimeFormat = config('settings.date_time_format');
        $task = [
            'id' => $task->id,
            'assigned_to' => $task->taskAssignedTo?$task->taskAssignedTo->full_name:'',
            'assigned_by' => $task->assignedBy?$task->assignedBy->full_name:'',
            'subject' => $task->subject,
            'start_date' => date($dateTimeFormat,strtotime($task->start_date)),
            'due_date' => date($dateTimeFormat,strtotime($task->due_date)),
            'priority' => $task->priority,
            'status' => $task->status,
            'description' => $task->description
        ];
        return $task;
    }

    private function generateParams()
    {
        $priority = $this->optionRepository->getAll()
            ->where('category', 'priority')->pluck('title','value')->prepend(trans('task.priority'), '');
        $status = $this->optionRepository->getAll()
            ->where('category', 'status')->pluck('title','value')->prepend(trans('task.status'), '');

        $assignedTo = $this->organizationRepository->getStaffWithUser()->get()
                ->map(function ($user) {
                    return [
                        'name' => $user->full_name.' ( '.$user->email.' )',
                        'id' => $user->id,
                    ];
                })
                ->pluck('name', 'id')->prepend(trans('task.assigned_to'), '');

        view()->share('priority',$priority);
        view()->share('status',$status);
        view()->share('assignedTo',$assignedTo);
    }
}
