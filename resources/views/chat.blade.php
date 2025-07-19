@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row" style="height: 90vh">
            <!-- قائمة الأصدقاء -->
            <div class="p-0 bg-white col-md-4 border-end">
                @livewire('chat-list')
            </div>

            <!-- المحادثة -->
            <div class="p-0 col-md-8 bg-light">
                @livewire('chat-box')
            </div>
        </div>
    </div>
@endsection
