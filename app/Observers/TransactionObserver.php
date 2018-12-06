<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Listen to the created event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $notification = new Notification;

        $notification->to_user = $transaction->to_user;
        $notification->notification_type_id = 1;
        $notification->save();
    }


    /**
     * Listen to the updated event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        //
    }


    /**
     * Listen to the deleted event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }


    /**
     * Listen to the saved event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function saved(Transaction $transaction)
    {
        //
    }


    /**
     * Listen to the restored event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Listen to the restoring event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function restoring(Transaction $transaction)
    {
        //
    }
}
