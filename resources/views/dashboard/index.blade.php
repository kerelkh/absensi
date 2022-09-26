@extends("layout.index")

@section('content')
    <div id="title" class="flex justify-between items-center">
        <div id="greetings">
            <h1 class="text-xl font-medium">Dashboard</h1>
            <p class="text-gray-600">Welcome Back, {{ auth()->user()->username }}.</p>
        </div>
        <div>
            <button class="px-5 py-4 rounded-lg shadow-lg bg-blue-500 hover:bg-blue-600 text-white flex justify-center items-center gap-3 text-sm" type="button" data-modal-toggle="modalCreateUser"><i class="fa-solid fa-plus"></i> Add New user</button>
            @include('dashboard.partials.modal')
        </div>
    </div>
    <div class="grid grid-cols-5 gap-5 mt-5">
        <div class="col-span-3">
            <div class="w-full grid grid-col-2 lg:grid-cols-3 gap-2">
                @foreach($datas['roles'] as $role)
                <div class="col-span-1 rounded-xl shadow bg-white p-5 flex items-stretch gap-2">
                    <div class="w-1/2 text-6xl @if($role->id == 1)bg-blue-300 @elseif($role->id == 2)bg-green-300 @elseif($role->id == 3)bg-orange-300 @elseif($role->id == 4)bg-yellow-300 @elseif($role->id == 5)bg-purple-300 @else bg-red-300 @endif text-gray-500 px-3 pt-2 rounded-lg text-center"><i class="fa-solid fa-user"></i></div>
                    <div class="w-1/2 flex flex-col items-stretch justify-between">
                        <p class="text-sm font-medium tracking-wide text-gray-500 text-center">{{ $role->role_name }}</p>
                        <p class="text-2xl text-center">{{ count($role->users) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-span-2 bg-white rounded-xl p-5">
            <p class="text-lg font-medium capitalize tracking-wide text-gray-600 mb-2">Information</p>
            <div class="w-full text-sm font-medium tracking-wide">
                @include('dashboard.partials.date')
            </div>
            <div class="mt-5">
                <p class="text-lg font-medium capitalize tracking-wide text-gray-600 mb-2">Online user</p>
                <div class="w-full text-sm font-medium tracking-wide flex flex-wrap gap-1">
                    @foreach($datas['superadmins'] as $superadmin)
                    @if(Cache::has('user-is-online-'. $superadmin->id))
                    <div class="flex items-center justify-center gap-2">
                        <div class="w-2 h-2 bg-green-400 ring-2 ring-green-200 rounded-full"></div>
                        <p>{{ $superadmin->username }} <span class="text-xs italic">({{ $superadmin->last_seen }})</span></p>
                    </div>
                    @else
                    <div class="flex items-center justify-center gap-2">
                        <div class="w-2 h-2 bg-gray-400 ring-2 ring-gray-200 rounded-full"></div>
                        <p>{{ $superadmin->username }} <span class="text-xs italic">({{ $superadmin->last_seen }})</span></p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
