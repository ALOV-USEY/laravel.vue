<?php

namespace App\Providers;

use App\Http\Controllers\Contracts\Chat\IndexChatActionContract;
use App\Http\Controllers\Contracts\Chat\MessagesChatActionContract;
use App\Http\Controllers\Contracts\Chat\SendChatActionContract;
use App\Http\Controllers\Actions\Chat\IndexChatAction;
use App\Http\Controllers\Actions\Chat\MessagesChatAction;
use App\Http\Controllers\Actions\Chat\SendChatAction;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        IndexChatActionContract::class => IndexChatAction::class,
        MessagesChatActionContract::class => MessagesChatAction::class,
        SendChatActionContract::class => SendChatAction::class,
        IndexBookingActionContract::class => IndexBookingAction::class,
        StoreBookingActionContract::class => StoreBookingAction::class,
        ShowBookingActionContract::class => ShowBookingAction::class,
        UpdateBookingActionContract::class => UpdateBookingAction::class,
        DestroyBookingActionContract::class => DestroyBookingAction::class,
    ];
}
