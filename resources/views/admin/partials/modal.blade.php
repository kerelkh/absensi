<!-- Main modal -->
<div id="modalCreateUser" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-4 rounded-t border-b ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Create User
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-toggle="modalCreateUser">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('create-user') }}" method="POST" id="form-create-user">
            @csrf
            <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-1">
                            <div class="relative z-0 mb-6 w-full group">
                                <input type="text" name="username" id="username" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required value="{{ old('username') }}"/>
                                <label for="username" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
                                <div id="message-username"></div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="relative z-0 mb-6 w-full group">
                                <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required"/>
                                <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">password</label>
                                <div id="message-password"></div>

                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-1">
                            <label for="role" class="sr-only">Role</label>
                            <select id="role" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                                <option value="" selected>-- select role --</option>
                                @if($datas['roles'] ?? false)
                                @foreach($datas['roles'] as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <div id="message-role"></div>

                        </div>
                        <div class="col-span-1">
                            <div class="relative z-0 mb-6 w-full group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required"/>
                                <label for="password_confirmation" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password Confirmation</label>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end items-center p-6 space-x-2 rounded-b border-t border-gray-200">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create</button>
                <button data-modal-toggle="modalCreateUser" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).on('submit', '#form-create-user', function(e) {
        e.preventDefault();
        Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Save',
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $('#message-username').html('');
            $('#message-password').html('');
            $('#message-role').html('');
            $.post({
                url: $(this).attr('action'),
                data: {
                    'username': $('#username').val(),
                    'password': $('#password').val(),
                    'role': $('#role').val(),
                    'password_confirmation': $('#password_confirmation').val()
                },
                processing: true,
            }).done(function(data) {
                Swal.fire({
                    icon: 'success',
                    title: `${data.status}`,
                    text: `${data.message}`,
                }).then(function() {
                    location.reload();
                });
            }).fail(function(data){
                // $('#loading').fadeOut(300);
                // console.log(data.responseJSON.message);
                if(data.status == 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incorrect input',
                        text: 'Your input is incorrect!',
                    });
                    let errors = data.responseJSON.errors;
                    for(let e in errors){
                        $('#message-' + e).append(`<span class="text-red-600 text-xs italic">${errors[e]}</span>`);
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: data.responseJSON.status,
                        text: data.responseJSON.message,
                    })
                }

            });
        }
        })

    })
</script>
