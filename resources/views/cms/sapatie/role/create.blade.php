@extends('cms.parant')


@section('titel','Create  Roles')

@section('style')

@endsection
@section('Maintitel','Create Roles')

@section('subtitel','create Roles')

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Craet New Roles</h3>
    </div>

    <!-- /.card-header -->
    <!-- form start -->
    <form >
        @csrf

          <div class="card-body">
          <div class="form-group col-md-4">
            <label for="guard_name">Guard Name</label>
            <select class="form-control" style="width: 100%;" id="guard_name" name="guard_name"
                aria-label=".form-select-sm example">
                <option value="">All</option>
                <option value="admin">Admin</option>
                <option value="author">Author</option>
                <option value="web">Uesr</option>
            </select>
        </div>


        <div class="form-group col-md-4">
        <label for="name">Name of Roles</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter The Roles Name">
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="#" onclick="performstore()" type="button" class="btn btn-primary">Store</a>
        <a href="{{ route('roles.index') }}" type="button"
        class="btn btn-primary">Return to index</a>
      </div>
    </form>
  </div>


@endsection
@section('script')

    <script>
        function  performstore(){
            let formData = new FormData();
            formData.append('name' ,document.getElementById('name').value);
            formData.append('guard_name' ,document.getElementById('guard_name').value);
            store('/news/admin/roles',formData)
        }
    </script>

@endsection
