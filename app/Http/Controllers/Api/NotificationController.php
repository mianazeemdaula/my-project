<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = Notification::with('user')->where('user_id', $user->id)->orderBy('id', 'desc')->paginate();
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = Notification::find($id);
        $data->is_read = true;
        $data->save();
        return $this->index();
    }

    public function destroy($id)
    {
        $data = Notification::find($id)->delete();
        return $this->index();
    }

    public function deleteAll(Request $request)
    {
        $user = $request->user();
        Notification::where('user_id', $user->id)->delete();
        return $this->index();
    }
}