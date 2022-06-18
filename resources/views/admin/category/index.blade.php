@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('main/mdi/css/materialdesignicons.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Category Table</h4>

                        <div class="row my-3">
                            <div class="col-md-9 col-sm-12">
                                <a href="{{route('category.create')}}" class="btn btn-primary btn-sm my-2"><i class="mdi mdi-plus-circle"></i> Category</a>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <form class="form-inline" action="{{route('category.search')}}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <button type="submit" class="input-group-text text-white bg-primary"><span><i class="mdi mdi-account-search"></i></span></button>
                                        <input type="text" name="search" value="{{request('search')}}" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category as $c)
                                    <tr class="text-center myTable-{{$c->id}}">
                                        <td>{{$c->id}}</td>
                                        <td>{{$c->name}}</td>
                                        <td>
                                            <a href="{{route('category.edit',$c->id)}}" class="btn btn-warning btn-sm text-white"><i class="mdi mdi-tooltip-edit"></i> Edit</a>
                                            <a href="" class="btn btn-danger btn-sm delete_btn" data-id="{{$c->id}}"><i class="mdi mdi-delete"></i> Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{$category->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function($){
            @if(session('create'))
            Toast.fire({
                icon: 'success',
                title: "{{session('create')}}"
            })
            @endif

            @if (session('update'))
            Toast.fire({
                icon: 'success',
                title: "{{session('update')}}"
            })
            @endif

            $(document).on('click','.delete_btn',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                    text: "Are you sure to want to delete this category...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/admin/category/${id}`,
                        })
                        .done(function(res){
                            $(".myTable-"+id).remove();
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })
        });
    </script>
@endsection

