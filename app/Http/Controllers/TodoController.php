<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function listTodo()
    {
        return Todo::all();
    }

    public function listOneTodo(int $id)
    {
        return Todo::find($id) ?? [];
    }

    public function listTodoUser(int $id)
    {
        $todo = Todo::where('user_id', $id)->get()->toArray();

        if (!empty($todo)) {
            return $todo;
        }

        return response()->json(['todo not found' => $id], 404);
    }

    public function createTodo(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'user_id' => 'required',
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'user_id' => $request->user_id
        ]);

        if ($todo->save()) {
            return response()->json(['inserted_id' => $todo->id], 201);
        }
    }

    public function updateTodo(Request $request, int $id)
    {
        $todo = Todo::find($id);

        if (!empty($todo)) {
            $this->validate($request, ['title' => 'required']);

            $todo->title = $request->title;

            if ($todo->save()) {
                return response()->json(['update_id' => $todo->id], 200);
            }
        }

        return response()->json(['todo not found' => $id], 404);
    }

    public function deleteTodo(int $id)
    {
        $todo = Todo::find($id);
        
        if (!empty($todo)) {
            $todo->delete();
            return response()->json(null, 204);
        }

        return response()->json(['todo not found' => $id], 404);
    }
}
