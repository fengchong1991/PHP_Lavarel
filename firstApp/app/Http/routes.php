
<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
use App\Task;
use Illuminate\Http\Request;
    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    });
    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:5',
        ]);
        if ($validator->fails()) {
        	
        	//The ->withErrors($validator) call will flash the errors from the given validator instance into the session so that they can be accessed via the $errors variable in our view.

            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        $task = new Task;
        $task->name = $request->name;
        $task->save();
        return redirect('/');
    });
    /**
     * Delete Task
     */
    Route::delete('/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();
        return redirect('/');
    });
