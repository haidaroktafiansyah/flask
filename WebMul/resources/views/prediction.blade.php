@extends('template')

@section('content')
        <div class="container pt-5">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th> No </th>
                                <th> date </th>
                                <th> username </th>
                                <th> tweet </th>
                                <th> preprocessing</th>
                                <th> label</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $eachData) { ?>
                                <tr>
                                    <td> <?php echo $eachData['Unnamed: 0']; ?></td>
                                    <td> <?php echo date('Y-m-d', strtotime($eachData['date'])); ?></td>
                                    <td> <?php echo $eachData['username']; ?></td>
                                    <td> <?php echo $eachData['tweet']; ?></td>
                                    <td> <?php echo $eachData['preprocessing']; ?></td>
                                    <td> <?php echo ($eachData['label'] == 1) ? 'positif' : 'negatif'; ?></td>
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
@endsection