<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Laravel Ajax</title>
  </head>
  <body>
    <div class="container">
        <h1 class="text-center">Laravel Ajax Crud Operation</h1>
        <div class="row mt-5">
            <div class="col">
                <form id="cityForm">
                    @csrf
                    <div class="form-group">
                        <label for="state">Select State</label>

                        <select name="state_id" id="state_id" class="form-control">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="city_name">City Name</label>
                        <input type="text" name="city_name" id="city_name" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <button id="submit" class="btn btn-sm btn-success">Add City</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <table id="cities" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>State</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update City</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <form id="editCityForm">
                @csrf
                <input type="hidden" name="id" id="city_id">
                <div class="form-group">
                    <label for="state">Select State</label>
                    <select name="edit_state_id" id="edit_state_id" class="form-control">
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city_name">City Name</label>
                    <input type="text" name="edit_city_name" id="edit_city_name" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="edit_status" id="edit_status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="update" class="btn btn-primary">Update City</button>
        </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

       <script>
        $(document).ready(function(){
            $('#submit').click(function(e){
                e.preventDefault();

            $.ajax({
                type:'POST',
                url:"{{ route('city.store') }}",
                dataType : "json",
                data:$('#cityForm').serialize(),
                success:function(data){
                    console.log(data);
                    if(data.code == 200){
                        alert('City added successfully');
                        {{--  location.reload();  --}}
                        $('#cityForm')[0].reset();
                        table.ajax.reload();
                    }else{
                        alert('Failed to add city');
                    }
                },
                error:function(data){
                    console.log(data);
                    alert('Error occurred');
                }
            });
        });




        var table = $('#cities').DataTable( {
            ajax: "{{ route('city.index') }}",
            columns: [
                { "data": "city_name" },
                { "data": "state.state_name" },
                {
                    "data": null,
                    render: function(data, type, row) {
                        if(row.status == "Active") {
                            return `<button class="btn btn-sm btn-success">Active</button>`;
                        } else {
                            return `<button class="btn btn-sm btn-warning">Inactive</button>`;
                        }
                    }
                },
                {
                    "data": null,
                    render: function(data, type, row) {
                        return `<button data-id="${row.id}" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" id="edit"><i class="fa fa-edit"></i></button>`;
                    }
                },
                {
                    "data": null,
                    render: function(data, type, row) {
                        return `<button data-id="${row.id}" class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>`;
                    }
                }
            ]
        } );


        //edit city
        $(document).on('click', '#edit', function() {
            $.ajax({
                url: "{{ route('city.edit') }}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": $(this).data('id')
                },
                success: function(response) {
                    console.log(response);
                    $('input[name="id"]').val(response.data.id);
                    $('select[name="edit_state_id"]').val(response.data.state_id);
                    $('input[name="edit_city_name"]').val(response.data.city_name);
                    $('select[name="edit_status"]').val(response.data.status);
                }
            })
        })


        $(document).on('click', '#update', function() {
            if(confirm('Are you sure you want to update??')) {
                $.ajax({
                    url: '{{ route("city.update") }}',
                    type: 'post',
                    dataType: 'json',
                    data: $('#editCityForm').serialize(),
                    success: function(response) {
                        $('#editCityForm')[0].reset();
                        table.ajax.reload();
                        $('#exampleModal').modal('hide')
                    }
                })
            }
        })


        $(document).on('click', '#delete', function() {
            if(confirm('Are you sure you want delete??')){
                $.ajax({
                    url: "{{ route('city.destroy') }}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": $(this).data('id')
                    },
                    success: function(response) {
                        table.ajax.reload();
                    }
                })
            }
        })
        });
    </script>
  </body>
</html>
