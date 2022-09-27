<div id="view-opd" class="w-full mt-2 bg-white rounded-lg py-4 px-5 shadow">
    <table id="table-opd" class="text-sm display" data-url="{{ route('get-opds') }}" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>OPD Name</th>
                <th>Address</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Distance</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody class=" text-gray-500">
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        let tableOpd = $('#table-opd').DataTable({
            ajax: $("#table-opd").data('url'),
            columns: [
                { data: 'no'},
                { data: 'opd_name' },
                { data: 'opd_address' },
                { data: 'opd_longitude'},
                { data: 'opd_latitude' },
                { data: 'opd_distance' },
                { data: 'edit' },

            ]
        });
    })
</script>
