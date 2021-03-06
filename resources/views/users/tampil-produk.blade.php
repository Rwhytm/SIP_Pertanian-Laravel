@extends('users.tampil_p.layout_tampil')
@section('content')
<div class="product-details ptb-100 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-7 col-12">
                <div class="product-details-img-content">
                    <div class="product-details-tab mr-70">
                        <div class="product-details-large tab-content">
                            <div class="tab-pane active show fade" id="pro-details1" role="tabpanel">
                                @if ($produk->produkImages->first())
                                <img src="{{ asset($produk->produkImages->first()->path) }}" alt="" style="width:500px; height:300px">
                                @else
                                <img src="{{ asset('users/assets/img/noproduk.jpg') }}" alt="" style="width:500px; height:300px" >
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 col-12">
                <div class="product-details-content">
                    <h3>{{$produk->nama_produk}}</h3>
                    <div class="details-price">
                        <span >{{'Rp. '.number_format($produk->harga)}}</span>
                        <p>Tersedia : {{$produk->jumlah}} {{$produk->satuan}}</p>
                    </div>
                    <p>{{$produk->deskripsi}}</p>
                    <div class="quickview-plus-minus col-xs-2">
                        @if ($produk->jumlah != 0)
                        <form action="{{route('keranjang')}}" method="post">
                            @csrf
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="cart">
                                <input type="number" value="1" class="@error('jumlah') is-invalid @enderror" name="jumlah" class="" min="1" max="{{$produk->jumlah}}"> 
                            </div>
                            
                            <br>
                            <button type="submit" class="btn btn-dark btn-lg">Tambah Ke Keranjang</button>
                            <div class="invisible">
                                {{-- <input  name="user_id" type="text" value="{{Auth::user()->id}}" readonly> --}}
                                <input  name="id_produk" type="text" value="{{$produk->id}}" readonly>
                                <input  name="harga" type="text" value="{{$produk->harga}}" readonly>
                            </div>
                        </form>
                        @else
                        <div class="row">
                            <div class="cart">
                                <h2>SOLD OUT</h2>
                                {{-- <input type="number" value="0" class="@error('jumlah') is-invalid @enderror" name="jumlah" class="" min="1" > 
                            </div>
                            <div class="invisible">
                                <input  name="user_id" type="text" value="{{Auth::user()->id}}" readonly>
                                <input  name="id_produk" type="text" value="{{$produk->id}}" readonly>
                                <input  name="harga" type="text" value="{{$produk->harga}}" readonly>
                            </div>
                            <div class="container">
                                <form action="{{ route('preorder') }}" method="post">
                                    @csrf
                                    <button  type="submit" class="btn btn-dark">Pre-order</button>
                                    
                                </form> --}}
                            </div>
                        </div>
                        @endif
                    </div>
                    <a href="{{ url()->previous() }}">
                    <div class="btn btn-dark">Kembali</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection