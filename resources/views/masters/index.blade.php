@extends('layout.index')

@section('content')
<div id="title" class="flex justify-between items-center">
    <div id="greetings">
        <h1 class="text-xl font-medium">Masters</h1>
        <p class="text-gray-600">Manage Settings.</p>
    </div>
</div>

<div class="mt-2">
    <div class="flex-1 bg-white rounded-lg py-4 px-5 shadow mb-5">
        <div class="flex justify-between items-center">
            <div class="flex justify-center items-center gap-5">
                <div>
                    <button id="view-opd-button" class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center " type="button">
                        <i class="fa-solid fa-eye"></i> View OPD
                    </button>
                </div>
            </div>
            <div class="flex justify-center items-center gap-5">
                <div>
                    <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center " type="button" data-modal-toggle="modalOPD">
                        <i class="fa-solid fa-plus"></i> Add OPD
                    </button>
                    @include('masters.opd.modal')
                </div>
            </div>

        </div>
    </div>

    @include('masters.opd.view')
</div>

<script>
    $(document).ready(function() {
        $('#view-opd').hide();
        $('#view-opd-button').on('click', function() {
            $('#view-opd').fadeToggle(100);
        })
    })
</script>
@endsection
