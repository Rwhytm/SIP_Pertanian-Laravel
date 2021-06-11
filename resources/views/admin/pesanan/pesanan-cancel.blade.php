@extends('admin.layout')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header card-header-">
                    <h2>Pesanan Cancel</h2>
                </div>
                <div class="col-md-11">
                    
                </div>
                <div class="card-body ">
                    <table class="table table-boardered table-striped">
                        <thead>
                            <th class="text-center">Nomor Tansakasi</th>
                            <th class="text-center">Tanggal</th>
                            {{-- <th class="text-center">Pembeli</th> --}}
                            {{-- <th class="text-center">Jumlah Pembayaran</th> --}}
                            <th class="text-center">Status</th>
                        </thead>
                        <tbody>
                            @foreach ($keranjang as $k)
                            @if ($k->status == 'sukses')
                            
                            
                            
                            @else
                            <tr>
                                <td class="text-center">{{ $k->nomor_transaksi }}</td>
                                <td class="text-center">{{ $k->updated_at }}</td>
                                {{-- <td class="text-center"></td> --}}
                                {{-- <td class="text-center">{{$k->jumlah_dibayar }}</td> --}}
                                <td class="text-center">{{ $k->status }}</td>
                                
                            </tr>
                            @endif
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                    {{-- {{ $kategori->links() }} --}}
                    <div class="table-footer text-right">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection