<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Repositories\OptionRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\TodoRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    private $userRepository;
    private $organizationRepository;
    private $todoRepository;
    private $optionRepository;

    public function __construct(
        UserRepository $userRepository,
        OrganizationRepository $organizationRepository,
        TodoRepository $todoRepository,
        OptionRepository $optionRepository
    ) {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->organizationRepository = $organizationRepository;
        $this->todoRepository = $todoRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'todo');
    }

    public function index()
    {
        $title = trans('todo.todo');
        $todoNew = $this->todoRepository->toDoForUser()->where('completed',0);
        $todoCompleted = $this->todoRepository->toDoForUser()->where('completed',1);
        return view('user.todo.index',compact('title','todoNew','todoCompleted'));
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->getUser();
        $organization = $this->userRepository->getOrganization();
        $request->merge(['user_id'=>$user->id,'organization_id'=> $organization->id]);
        $this->todoRepository->create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $todo)
    {
        $todo = $this->todoRepository->find($todo);
        $user = $this->userRepository->getUser();
        if ($todo->user_id!=$user->id){
            return view('errors.404');
        }
        $todo->update($request->all());
        echo '<div class="alert alert-success">' . trans('todo.updated_successfully') . '</div>';
    }

    public function delete($todo)
    {
        $todo = $this->todoRepository->find($todo);
        $user = $this->userRepository->getUser();
        if ($todo->user_id!=$user->id){
            return view('errors.404');
        }
        $todo->delete();
        return redirect()->back();
    }

    public function isCompleted(Request $request, $todo){
        $todo = $this->todoRepository->find($todo);
        $user = $this->userRepository->getUser();
        if ($todo->user_id!=$user->id){
            return view('errors.404');
        }
        if ($request->completed==1){
            $todo->completed_at = now();
        }else{
            $todo->completed_at = null;
        }
        $todo->completed = $request->completed;
        $todo->save();
        echo '<div class="alert alert-success">' . trans('todo.status_changed') . '</div>';
    }
}
