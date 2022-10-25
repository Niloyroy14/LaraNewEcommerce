@extends('admin.layouts.master')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-header">
                Manage Brand
            </div>
            <div class="card-body">

                @include('admin.partial.messages')

                <table class="table table-bordered" id="brandTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Brand Name</th>
                            <th>Brand Image</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>
<!-- main-panel ends -->
@endsection


@section('scripts')

<script>
    $(function() {
        $('#brandTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('/admin/brand')}}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'Action'
                }
            ]
        });
    });
</script>

@endsection