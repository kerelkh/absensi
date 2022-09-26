@extends('layout.index')

@section('content')
<div id="title" class="flex justify-between items-center">
    <div id="greetings">
        <h1 class="text-xl font-medium">Admin</h1>
        <p class="text-gray-600">Manage Operator, Duty, User.</p>
    </div>
    <div>
        <button class="px-5 py-4 rounded-lg shadow-lg bg-blue-500 hover:bg-blue-600 text-white flex justify-center items-center gap-3 text-sm" type="button" data-modal-toggle="modalCreateUser"><i class="fa-solid fa-plus"></i> Add New user</button>
        @include('admin.partials.modal')
    </div>
</div>

<div class="mt-2 bg-white rounded-lg py-4 px-5 shadow">
    <div>
        <label for="filter" class="mr-2 capitalize font-medium tracking-wider">filter</label>
        <select name="filter" id="filter" class="py-1 pr-10 outline-none rounded-lg">
            <option value="">All</option>
            @foreach($datas['roles'] as $role)
            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-2 bg-white rounded-lg py-4 px-5 shadow">
    <table id="myTable" class="w-full text-sm display">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Validation</th>
                <th>Last Seen</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody class="font-medium text-gray-500">
        </tbody>
    </table>
</div>

@include('admin.partials.detail')
@include('admin.partials.detail-user')

<script>
    $(document).ready(function() {
        let base_url = window.location.origin;
        let role_filter = $('#filter').val();
        let url = base_url+'/users/get-users?role='+role_filter;
        let table = $('#myTable').DataTable({
            ajax: url,
            columns: [
                { data: 'no'},
                { data: 'username' },
                { data: 'role' },
                { data: 'validation'},
                { data: 'last_seen' },
                { data: 'edit' },

            ]
        });

        $('#filter').on('change', function() {
            //clean sheet detail
            $('#detail-user').fadeOut(100);
            $('#detail-panel-user').fadeOut(100);
            let newUrl = base_url + '/users/get-users?role=' + $(this).val();
            table.ajax.url(newUrl).load();
        })

        $('#detail-user').hide();
        $('#detail-panel-user').hide();
    });

    $(document).on('click', '.show-user', function() {
        $('#detail-user').hide();
        $('#detail-panel-user').hide();
        let base_url = window.location.origin;
        let url = base_url+'/users/get-user/'+$(this).data('user');
        $.get(url).done(function(data) {
            $('#detail-user').fadeIn(100);
            $('#username-title').html(data.user.username);
            $('#role-title').html(data.user.role.role_name);
            $('#last-seen-title').html(data.user.last_seen);
            $('#username-id').val(data.user.username);
            $('#username-update-id').val(data.user.username);

            if(data.user.role.role_name === 'user') {
                $('#detail-panel-user').fadeIn(100);
                $('#detail-panel-user #detail_name').val(data.user.userdetail.name || '');
                $('#detail-panel-user #detail_email').val(data.user.userdetail.email || '');
                $('#detail-panel-user #detail_nik').val(data.user.userdetail.nik || '');
                $('#detail-panel-user #detail_nip').val(data.user.userdetail.nip || '');
                $('#detail-panel-user #detail_rank').val(data.user.userdetail.rank_id || '').change();
                $('#detail-panel-user #detail_position').val(data.user.userdetail.position || '');
            }
        }).fail(function(data) {
            Swal.fire({
                icon: 'error',
                title: `${data.responseJSON.status}`,
                text: `${data.responseJSON.message}`,
            });
        });
    })
</script>
@endsection
