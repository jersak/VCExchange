<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Notification;
use App\Models\NotificationType;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function createNotification($to_user, $type)
    {
        $user = User::where('id', $to_user)->first();

        if (empty($user)) {
            return response()->json(
                'Destinatary not found.',
                404
            );
        }

        $notificationType = NotificationType::where('id', $type)->first();

        if (empty($notificationType)) {
            return response()->json(
                'Notification type not found.',
                404
            );
        }

        try {
            $notification = new Notification;

            $notification->to_user = $user->id;
            $notification->notification_type_id = $type;
            $notification->save();

            return response()->json($notification);
        } catch (\Exception $e) {
            return response()->json(array("errorCode" => $e->getCode(), "errorMessage" => $e->getMessage()), 500);
        }
    }

    public function getNotifications($user_id, $unread = false)
    {
        $user = User::where('id', $user_id)->first();

        if (empty($user)) {
            return response()->json(
                'User not found.',
                404
            );
        }

        try {
            $notifications = Notification::where('to_user', $user_id)
                ->when($unread, function ($q) use ($unread) {
                        return $q->where('is_read', false);
                })->paginate();

            if (!empty($notifications)) {
                return $notifications;
            }

            return response()->json(
                'No notifications found.',
                404
            );
        } catch (Exception $e) {
            return response()->json(array("errorCode" => $e->getCode(), "errorMessage" => $e->getMessage()), 500);
        }
    }

    public function markUserNotificationsAsRead($user_id)
    {
        $user = User::where('id', $user_id)->first();

        if (empty($user)) {
            return response()->json(
                'User not found.',
                404
            );
        }

        try {
            $notifications = Notification::where('to_user', $user_id)->where('is_read', false)->get();

            if (!empty($notifications)) {
                $notifications->each(
                    function ($item, $key) {
                        $item->is_read = 1;
                        $item->save();
                    }
                );
            }

            return response()->json('', 204);
        } catch (\Exception $e) {
            return response()->json(array("errorCode" => $e->getCode(), "errorMessage" => $e->getMessage()), 500);
        }
    }
}
