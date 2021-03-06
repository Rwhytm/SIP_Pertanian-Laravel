<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Kategori;
use App\User;
use illuminate\Support\Facedes\Storage;
use App\Models\ProdukImage;
use DB;
use \App\Mail\TestMail;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        
    }
    public function index(){
        $image =  ProdukImage::orderBy('id', 'ASC');
        $produk = Produk::orderBy('nama_produk', 'ASC')->paginate(20);
        return view('users\home',['produk' => $produk, 'image' => $image]);
    }
    
    
    #filter untuk menampilkan produk
    public function terbaru(){
        $produk = Produk::orderBy('id', 'DESC')->paginate(15); 
        return view('users\filter\pterbaru',['produk' => $produk]);
    }
    public function terlama(){
        $produk = Produk::orderBy('id', 'ASC')->paginate(15); 
        return view('users\filter\pterlama',['produk' => $produk]);
    }
    public function daritinggi(){
        $produk = Produk::orderBy('harga', 'DESC')->paginate(15); 
        return view('users\filter\ptermahal',['produk' => $produk]);
    }
    public function darirendah(){
        $produk = Produk::orderBy('harga', 'ASC')->paginate(15); 
        return view('users\filter\ptermurah',['produk' => $produk]);
    }
    public function produk($id){
        $produk = Produk::find($id);
        return view('users.tampil-produk', ['produk' => $produk]);
    }
    
    public function tambah(Request $request){
        $this->validate($request,
        ['jumlah' => ['required'],]);
        $keranjang = Keranjang::create([
            'user_id' => auth()->user()->id,
            'produk_id' => $request->id_produk, 
            'total' =>  $request->jumlah * $request->harga,
            'jumlah' => $request->jumlah,
        ]);
        return redirect(route('home user'));
    }
    public function checkout(Request $request){
        $user_id = auth()->user()->id;
        $keranjang = Keranjang::where(['user_id' => $user_id, 'status' => 'belum bayar'])->update([
            'nomor_transaksi' => 'TRX-' . time(),
            'status' => 'pending'
        ]);
        
        return redirect()->route('home user');
    }
    public function keranjang($id){
        $user = User::find($id);
        $keranjang = Keranjang::where(['user_id'=> $user->id, 'status' => 'belum bayar'])->get();
        return view('users.keranjang',['keranjang' => $keranjang]);
    }
    
    public function kategori($id){
        $produk = Kategori::find($id)->products[0]->id;
        return view('users.filter.hasilfilter', ['produk' => $produk]);
    }
    
    public function hapus($id){
        $userid = auth()->user()->id;
        $keranjang = Keranjang::find($id)->delete();
        return  redirect(route("tampil keranjang", $userid));
    }
    public function bayar(){
        $user_id = auth()->user()->id;
        $keranjang = Keranjang::where(['user_id' => $user_id, 'status' => 'belum bayar'])->get();
        $order_total = Keranjang::where(['user_id' => $user_id, 'status' => 'belum bayar'])->sum('total');
        
        
        return view('users.pesanan', compact('keranjang', 'order_total'));
    }
    
    
    
    public function pesanansaya(){
        $user_id = auth()->user()->id;
        
        $pesanansaya = Keranjang::where(['user_id' => $user_id, 'status' => 'pending'])->whereNotNull('nomor_transaksi')->get()->unique('nomor_transaksi');
        
        return view('users.list-pesanan', ['pesanan' => $pesanansaya]);
    }
    
                    public function riwayatpesanan(){
                        $user_id = auth()->user()->id;
                        
                        $pesanansaya = Keranjang::where(['user_id' => $user_id, 'status' => 'sukses'])->whereNotNull('nomor_transaksi')->get()->unique('nomor_transaksi');
                        
                        return view('users.list-pesanan', ['pesanan' => $pesanansaya]);
                    }
                    public function pesananterkonfirmasi(){
                        $user_id = auth()->user()->id;
                        
                        $pesanansaya = Keranjang::where(['user_id' => $user_id, 'status' => 'konfirmasi'])->whereNotNull('nomor_transaksi')->get()->unique('nomor_transaksi');
                        
                        return view('users.list-pesanan', ['pesanan' => $pesanansaya]);
                    }
                    public function pesanandiproses(){
                        $user_id = auth()->user()->id;
                        
                        $pesanansaya = Keranjang::where(['user_id' => $user_id, 'status' => 'proses'])->whereNotNull('nomor_transaksi')->get()->unique('nomor_transaksi');
                        
                        return view('users.list-pesanan', ['pesanan' => $pesanansaya]);
                    }
                    public function konfirmasi($id){
                        $nomor = Keranjang::where(['nomor_transaksi' => $id])->get();
                        return view('users.pembayaran',['nomor' => $nomor]);
                    }
                    
                    public function konfirmasipesanan(Request $request, $id){
                        $this->validate($request,
                        ['bukti' => ['required'],
                    ],
                    $message = [
                        'bukti.required' => 'Bukti pembayaran harus di upload',
                    ]
                );
                
                if ($request->hasFile('bukti')){ 
                    $image = $request->file('bukti');
                    $name = time().$request->file('bukti')->getClientOriginalName();
                    $folder = 'storage/uploads/bukti';
                    $filePath = 'storage/uploads/bukti/'. $name; 
                    $request->file('bukti')->move('storage/uploads/bukti', $name);
                }
                $nomor = Keranjang::where(['nomor_transaksi' => $id])->update([
                    'nomor_rekening' => $request->nomor_rekening,
                    'nama_rekening' => $request->atasnama,
                    'path' => $name,
                    'nama_bank' => $request->bankanda,
                    'tanggal_transfer' => $request->tf,
                    'jumlah_dibayar' => $request->jumlahdb,
                    'status' => 'konfirmasi',
                    'pengiriman' => $request->pengiriman,
                    
                ]);
                $id_produk = Keranjang::where(['nomor_transaksi' => $id])->get();
                foreach($id_produk as $id){
                    $id_p = $id->produk_id;
                    $produk = Produk::find($id_p);
                    $jumlahproduk = $produk->jumlah - $id->jumlah;
                    Produk::where('id', $id_p)->update(['jumlah' => $jumlahproduk]);
                }
                $detail = [
                    'title' => 'Konfirmasi Pesanan',
                    'body' => 'Pesanan Anda sudah terkonfirmasi, mohon menunggu untuk pengiriman produk'
                ];
                \Mail::to(auth()->user()->email)->send(new TestMail($detail));
                return redirect()->route('home user');
            }
            public function terimapesanan(Request $request, $id){
                $nomor = Keranjang::where(['nomor_transaksi' => $id])->update([
                    'status' => 'sukses',
                ]);
                return redirect()->route('home user');
            }
            
            
            
            
            
            
            
            
            // Mencari produk
            public function cari(Request $request){
                $cari = $request->cari;
                $produk = Produk::where('nama_produk', 'like',"%". $cari."%")->paginate(10);
                return view('users\filter\hasilcari', ['produk' => $produk]);
            }
            
            public function invoice($id){
                $idu = auth()->user()->id;
                $user = User::where('id' , $idu);
                $transaksi = Keranjang::where('nomor_transaksi', $id)->get();
                
                return view('users.invoice', ['user' => $user, 'transaksi' => $transaksi]);
            }
            
        }
        