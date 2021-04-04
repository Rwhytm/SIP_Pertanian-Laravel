@extends('admin.layout')
@section('content')
        <div class="content">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-dafult">
                        <div class="card-header card-header-border-bottom">
                            <h2>Form</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{route('kategori.update',$kategori->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama_kategori">Nama Kategori</label>
                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Nama Kategori" value="{{ $kategori->nama_kategori }}">
                            </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection