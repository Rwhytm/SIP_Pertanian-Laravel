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
                                                <img src="{{ asset($produk->produkImages->first()->path) }}" alt="" style="width:500px; height:300px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 col-12">
                        <div class="product-details-content">
                            <h3>{{$produk->nama_produk}}</h3>
                            <div class="details-price">
                                <span >{{'Rp. '.$produk->harga}}</span>
                                <p>Tersedia : {{$produk->jumlah}} {{$produk->satuan}}</p>
                            </div>
                            <p>{{$produk->deskripsi}}</p>
                            <div class="quickview-plus-minus">
                                <form action="{{route('keranjang')}}" method="post">
                                @csrf
                                <div class="cart-plus-minus">
                                    
                                    <input type="text" value="1" name="jumlah" class="cart-plus-minus-box" min="1"> 
                                    
                                    
                                </div>
                                
                                    
                                
                                @if ($produk->jumlah != 0)
                                    <br>
                                    
                                    <button type="submit" class="btn btn-dark btn-lg">Tambah Ke Keranjang</button>
                                    <div class="invisible">
                                        <input  name="user_id" type="text" value="{{Auth::user()->id}}" readonly>
                                        <input  name="id_produk" type="text" value="{{$produk->id}}" readonly>
                                        <input  name="harga" type="text" value="{{$produk->harga}}" readonly>
                                    </div>
                                </form>
                                @else
                                <div class="quickview-btn-cart">
                                    <a class="btn-hover-red" href="#">Pre-order</a>
                                </div>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection