@extends('template')

@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-bordered table-hover dt-responsive">
                <thead>
                    <tr>
                        <th> date </th>
                        <th> username </th>
                        <th> Steaming </th>
                        <th> label</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $eachData) { ?>
                        <tr>
                            <td> <?php echo date('Y-m-d', strtotime($eachData['date'])); ?></td>
                            <td> <?php echo $eachData['username']; ?></td>
                            <td> <?php echo $eachData['tweet']; ?></td>
                            <td> <?php echo $eachData['label']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $('table').DataTable();
</script>
@endsection