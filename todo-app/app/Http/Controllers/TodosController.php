<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    //
    public function index(){
        // để lấy toàn bộ todos trong database
        //$todos = Todo::all();
        //with('todos',) todos ở đây là key
        return view('todos.index')->with('todos',Todo::all());
    }
    public function show($todoId){
        return view('todos.show')->with('todo', Todo::find($todoId));
    }

    public function create(){
        return view('todos.create');
    }

    public function store(){
        $this->validate(request(),[
            'name' => 'required|min:6|max:12',
            'description' => 'required'
        ]);
        $data = request()->all();

        $todo = new Todo();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->completed = false;

        $todo->save();

        session()->flash('success','Todo created successfully.');

        return redirect('/todos');
        }
        public function edit($todoId){
            return view('todos.edit')->with('todo', Todo::find($todoId));
        }
        public function update($todoId){
            $this->validate(request(), [
                'name' => 'required|min:6|max:12',
                'description' => 'required'
            ]);
            $data = request()->all();

            $todo = Todo::find($todoId);
            $todo->name = $data['name'];
            $todo->description = $data['description'];

            $todo->save();

            session()->flash('success','Todo update successfully.');

            return redirect('/todos');
        }
        public function destroy($todoId){
            $todo = Todo::find($todoId);
            $todo->delete();

            session()->flash('success','Todo delete successfully.');

            return redirect('/todos');
        }

        public function complete(Todo $todo){
            $todo->completed = true;
            $todo->save();

            session()->flash('success','Todo complete successfuly.');

            return redirect('/todos');
        }

}
