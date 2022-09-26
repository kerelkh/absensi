<!-- Main modal -->
<div id="modalChangePasswordUser" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow mx-auto">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-4 rounded-t border-b ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Change Password User
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-button-modal-change-password" data-modal-toggle="modalChangePasswordUser">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('change-password-all-user') }}" method="POST" id="form-change-password-user">
            @csrf
            <input type="hidden" name="username" id="username-id">
            <div class="p-6 space-y-6">
                <div class="relative z-0 mb-6">
                    <div class="flex items-center">
                        <input type="password" name="password" id="password-change" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required"/>
                        <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">password</label>
                        <div id="message-password"></div>
                        <button type="button" id="view-password" data-input="password-change"><i class='fa-solid fa-eye'></i></button>
                    </div>
                   <div id="message-password-change"></div>

                </div>
                <div class="relative z-0 mb-6">
                    <div class="flex items-center">
                        <input type="password" name="password_confirmation" id="password-confirmation-change" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required"/>
                        <label for="password_confirmation" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password Confirmation</label>
                        <button type="button" id="view-password-confirmation-change" data-input="password-confirmation-change"><i class='fa-solid fa-eye'></i></button>
                    </div>
                    <div id="message-password-confirmation-change"></div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end items-center p-6 space-x-2 rounded-b border-t border-gray-200">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Change Password</button>
                <button data-modal-toggle="modalChangePasswordUser" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 close-button-modal-change-password">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function togglePassword() {
            let target = $(this).data('input');
            let input = $('#' + target);
            let type = input.attr('type');
            if(type == 'password') {
                input.attr('type', 'text')
            }else{
                input.attr('type', 'password')
            }
        }
        function resetInputPassword() {
            $('#password-change').val('');
            $('#password-confirmation-change').val('');
        }

        $('#view-password').on('click', togglePassword);
        $('#view-password-confirmation-change').on('click', togglePassword);
        $('.close-button-modal-change-password').on('click', resetInputPassword);

    });

    $(document).on('submit', '#form-change-password-user', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            showCancelButton: true,
            confirmButtonText: 'Yes Change',
        }).then((result) => {
            if(result.isConfirmed){
                $('#message-password-change').html('');
                $('#message-password-confirmation-change').html('');
                // console.log([$('#password-change').val(),$('#password-confirmation-change').val(), $('#username-id').val()]);
                $.post({
                    url: $('#form-change-password-user').attr('action'),
                    data: {
                        'password': $('#password-change').val(),
                        'password_confirmation': $('#password-confirmation-change').val(),
                        'username': $('#username-id').val(),
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
                }).fail(function(data) {
                    if(data.status == 422) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Incorrect input',
                            text: 'Your input is incorrect!',
                        });
                        let errors = data.responseJSON.errors;
                        for(let e in errors){
                            $('#message-' + e + '-change').append(`<span class="text-red-600 text-xs italic">${errors[e]}</span>`);
                        }
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: data.responseJSON.status,
                            text: data.responseJSON.message,
                        })
                    }
                })
            }
        })
    });
</script>
