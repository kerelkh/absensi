<div id="detail-user" class="mt-2 bg-white rounded-lg py-4 px-5 shadow">
    <div class="w-full flex justify-between items-center">
        <div>
            <p class="border-l-4 border-blue-600 px-2 py-1 text-2xl font-medium tracking-wider text-gray-700" id="username-title">-</p>
            <p class="p-1 text-gray-500 italic">Role: <span id="role-title" class="font-medium">-</span> | Last Seen: <span id="last-seen-title" class="font-medium"></span></p>
        </div>
        <div>
            <button class="px-5 py-4 rounded-lg shadow-lg bg-green-500 hover:bg-green-600 text-white flex justify-center items-center gap-3 text-sm" type="button" data-modal-toggle="modalChangePasswordUser"><i class="fa-solid fa-pen-to-square"></i> Change Password</button>
            @include('admin.partials.modalChangePassword')
        </div>
    </div>

</div>
