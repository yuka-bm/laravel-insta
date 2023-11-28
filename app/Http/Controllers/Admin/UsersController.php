<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $all_users = $this->user->withTrashed()->latest()->paginate(5);
        return view('admin.users.index')->with('all_users', $all_users);
    }

    public function sort($user_status)
    {
        $user_status = $this->toggleStatus($user_status);
        if (1 == $user_status) {
            $all_users = $this->user->withTrashed()->orderBy('deleted_at', 'desc')->latest()->paginate(5);
        }
        else if (2 == $user_status) {
            $all_users = $this->user->withTrashed()->orderBy('deleted_at', 'asc')->latest()->paginate(5);
        }
        else {
            $all_users = $this->user->withTrashed()->latest()->paginate(5);
        }

        return view('admin.users.index')->with('all_users', $all_users)
                                        ->with('user_status', $user_status);
    }

    private function toggleStatus($status)
    {
        if (0 == $status) {
            $status = 1;
        }
        else if (1 == $status) {
            $status = 2;
        }
        else if (2 == $status) {
            $status = 1;
        }

        return $status;
    }

    public function deactivate($id)
    {
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id)
    {
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $all_users = $this->user->withTrashed()->where('name', 'like', '%' . $request->search . '%')->paginate(5);

        return view('admin.users.index')->with('all_users', $all_users)
                                        ->with('search', $request->search);
    }
}
