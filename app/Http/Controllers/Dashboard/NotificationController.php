<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\Controller;
use App\Traits\apiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use apiResponse;
    public function index(Request $request){
        $notifications = $request->user()->notifications()->latest()->paginate(10);
        return $this->apiResponse($notifications,"notifications retrived successfuly");
    }

    public function unread(Request $request){
        $notifications = $request->user()->unreadNotifications()->latest()->get();
        return $this->apiResponse($notifications,"unread notifications retrived successfuly");
    }

    public function markAsRead(Request $request ,string $notification){
        $notification = $request->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();
        return $this->apiResponse(null,"Notification marked as read.");
    }

    public function unReadCount(Request $request){
        $count = $request->user()->unreadNotifications()->count();
        return $this->apiResponse($count,"unread notifications count calculated successfuly");
    }
}
