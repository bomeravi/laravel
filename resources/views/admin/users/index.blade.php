@extends('adminlte::page')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Blog</div>
        <div class="panel-body">


            <br/>
            <br/>
            <table class="inputs">
                <tbody><tr>
                    <td>Minimum age:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>Maximum age:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
                <tr>
                    <td>Account Type:</td>
                    <td><select id="account_type">
                            <option value="">All</option>
                            <option value="freemium">Freemium</option>
                            <option value="premium">Premium</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td><select id="gender">
                            <option value="">All</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </td>
                </tr>
                </tbody></table>
            <table id="example" class="display" style="width:100%">
                <thead>

                <tr>
                    <th><input type="text" placeholder="Search Id" /></th>
                    <th><input type="text" placeholder="Search Name" /></th>
                    <th><input type="text" placeholder="Search Email" /></th>
                    <th></th>

                    <th></th>
                    <th></th>
                    <th></th>

                    <th><input type="text" placeholder="YYYY-MM-DD" /></th>

                </tr>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Distance</th>
                    <th>UserType</th>
                    <th>Created Date</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Distance</th>
                    <th>UserType</th>
                    <th>Created Date</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>


@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


    <script>
        $(document).ready(function () {

    //          var minEl = $('#min');
    // var maxEl = $('#max');
    //
    // // Custom range filtering function
    // $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    //     //  if ( settings.nTable.id !== 'example' ) {
    //     //     return true;
    //     // }
    //     var min = parseInt(minEl.val(), 10);
    //     var max = parseInt(maxEl.val(), 10);
    //     var age = parseFloat(data[4]) || null; // use data for the age column
    //
    //     if (
    //         (isNaN(min) && isNaN(max)) ||
    //         (isNaN(min) && age <= max) ||
    //         (min <= age && isNaN(max)) ||
    //         (min <= age && age <= max)
    //     ) {
    //         return true;
    //     }
    //
    //     return false;
    // });


           var table =    $('#example').DataTable({
                //stateSave: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url("/admin/ajax_users") }}',
                columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'gender', name: 'gender'},
            {data: 'age', name: 'age'},
            {data: 'distance', name: 'distance'},
            {data: 'user_type', name: 'user_type'},
            {data: 'created_at', name:'created_at'}

        ]
            });
         /*    minEl.on('input', function () {
        table.draw();
    });
    maxEl.on('input', function () {
        table.draw();
    });*/

             $('#min, #max').on('change', function(){
               table.column(4).search($('#min').val() + '-' + $('#max').val()).draw();
             });
             $("#account_type").on('change', function(){
                 console.log($('#account_type').val());
                 table.column(6).search($('#account_type').val()).draw();
             });
            $("#gender").on('change', function(){
                console.log($('#gender').val());
                table.column(3).search($('#gender').val()).draw();
            });
            $('#example thead input').on('keyup change', function() {
                table
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();
            });
        });
    </script>
@endsection
