<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">


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

        });
    </script>
  </body>
</html>
