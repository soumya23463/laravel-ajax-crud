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
        <h1 class="text-center">Laravel Ajax</h1>
        <div class="row mt-5">
            <div class="col">
                <form id="cityForm">
                    <div class="form-group">
                        <label for="state">Select State</label>

                        <select name="state" id="state" class="form-control">
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">Add City</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>


  </body>
</html>
