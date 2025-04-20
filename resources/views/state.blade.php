<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >

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
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
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
        })
    </script>
  </body>
</html>
