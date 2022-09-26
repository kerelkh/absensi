<div id="detail-panel-user" class="mt-2 bg-white rounded-lg py-4 px-5 shadow">
    <div class="w-full grid grid-cols-2">
        <div class="col-span-1">Last Activity:</div>
        <div class='col-span-1'>
            <p class="text-gray-700 font-medium text-lg mb-5">Information</p>
            <form action="{{ route('update-detail-user') }}" method="POST" id="form-update-detail-user" >
                @csrf
                <input type="hidden" name="username-update-id" id="username-update-id">
                <div class="grid grid-cols-2 gap-5">
                    <div class="col-span-1">
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="text" name="name" id="detail_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
                            <div id="message-name"></div>
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="number" name="nip" id="detail_nip" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="nip" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">NIP</label>
                            <div id="message-nip"></div>
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="email" name="email" id="detail_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                            <div id="message-email"></div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="number" name="nik" id="detail_nik" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="nik" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">NIK</label>
                            <div id="message-nik"></div>
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <label for="rank" class="sr-only">rank</label>
                            <select id="detail_rank" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                                <option value="">-- Rank --</option>
                                @foreach($datas['ranks'] as $rank)
                                <option value="{{ $rank->id }}" @if($rank->id == )>{{ $rank->rank_name }}</option>
                                @endforeach
                            </select>
                            <div id="message-rank"></div>
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="text" name="position" id="detail_position" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="position" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Position</label>
                            <div id="message-position"></div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="py-2 px-5 rounded-lg shadow-lg font-medium uppercase bg-blue-500 hover:bg-blue-600 text-white"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form-update-detail-user').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
            title: 'Are you sure?',
            showCancelButton: true,
            confirmButtonText: 'Save',
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $('#message-name').html('');
                $('#message-nik').html('');
                $('#message-nip').html('');
                $('#message-rank').html('');
                $('#message-email').html('');
                $('#message-position').html('');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'put',
                    data: {
                        'user_id': $('#username-update-id').val(),
                        'name': $('#detail_name').val(),
                        'nik': $('#detail_nik').val(),
                        'nip': $('#detail_nip').val(),
                        'rank': $('#detail_rank').val(),
                        'email': $('#detail_email').val(),
                        'position': $('#detail_position').val(),
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
    })
</script>
