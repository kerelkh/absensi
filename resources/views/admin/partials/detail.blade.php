<div id="detail-user" class="mt-2 bg-white rounded-lg py-4 px-5 shadow bg-cover bg-top" style="background-image: url('{{ asset('images/backgrounds/avatar-bg.png') }}')">
    <div class="w-full flex justify-between items-center">
        <div class="flex justify-center items-center">
            <div class="w-36 h-36 p-1">
                <img id="avatar" src="{{ asset('images/avatars/avatar-male.png') }}" alt="avatar" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="p-1 text-2xl font-medium text-gray-700" id="username-title">-</p>
                <p class="p-1 text-gray-500 italic">Role: <span id="role-title" class="font-medium">-</span> <br>Last Seen: <span id="last-seen-title" class="font-medium"></span> <br>OPD: <span id="opd-title"></span> <br> Shift: <span id="shift-title"></span></p>
            </div>
        </div>
        <div>
            <button class="px-5 py-4 rounded-lg shadow-lg bg-green-500 hover:bg-green-600 text-white flex justify-center items-center gap-3 text-sm" type="button" data-modal-toggle="modalChangePasswordUser"><i class="fa-solid fa-pen-to-square"></i> Change Password</button>
            @include('admin.partials.modalChangePassword')
        </div>
    </div>

</div>
