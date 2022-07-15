<! DOCTYPE html>
    <html lang="en">

    <head>
        <title> WEBMUL</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"> </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"> </script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>


    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">DATA</a>
        </nav>
        <div class="container pt-5">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th> No </th>
                                <th> date </th>
                                <th> username </th>
                                <th> Steaming </th>
                                <th> label</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $eachData) { ?>
                                <tr>
                                    <td> <?php echo $eachData['Unnamed: 0']; ?></td>
                                    <td> <?php echo date('Y-m-d', strtotime($eachData['date'])); ?></td>
                                    <td> <?php echo $eachData['username']; ?></td>
                                    <td> <?php echo $eachData['Steaming']; ?></td>
                                    <td> <?php echo $eachData['label']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="/upload/proses" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <b>File CSV</b><br />
                            <input type="file" name="file">
                        </div>

                        <input type="submit" value="Upload" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        <script>
            $('table').DataTable();
        </script>
    </body>

    </html>