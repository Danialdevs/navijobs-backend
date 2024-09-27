@extends('Layouts.app')
@section('content')
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Уведомления</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        @if($notifications->isEmpty())
            <p>Нет новых уведомлений.</p>
        @else
            <ul class="list-disc pl-6">
                @foreach($notifications as $notification)
                    <li class="{{ $notification->is_read ? 'text-gray-500' : 'text-black' }}">
                        <strong>{{ $notification->message }}</strong>
                        <small class="text-gray-400">({{ $notification->created_at->diffForHumans() }})</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
