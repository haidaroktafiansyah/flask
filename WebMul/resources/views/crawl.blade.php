@extends('template')

@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-xs-12">
            @if (isset($data))
            <table class="table table-bordered table-hover dt-responsive">
                <thead>
                    <tr>
                        <th> No </th>
                        <th> date </th>
                        <th> username </th>
                        <th> tweet </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0;
                    foreach ($data as $eachData) { ?>
                        <tr>
                            <td> <?php echo $count;
                                    $count++ ?></td>
                            <td> <?php echo date("Y-m-d H:i:s", substr($eachData['date'], 0, 10)); ?></td>
                            <td> <?php echo $eachData['username']; ?></td>
                            <td> <?php echo $eachData['tweet']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/query" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group">
                    <b>query</b><br />
                    <input type="text" name="inputQuery">
                </div>
                <div class="form-group">
                    <b>start :</b><br />
                    <input id="datepicker" name="start" width="276" />
                </div>

                <div class="form-group">
                    <b>end :</b><br />
                    <input id="datepicker2" name="end"  width="276" />
                </div>

                <input type="submit" value="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<script>
    $('table').DataTable();
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4'
    });
    $('#datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4'
    });
</script>

@endsection