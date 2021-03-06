<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Book;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        //
        if ($request->ajax()) {
            $books = Book::with(['author']);
            return Datatables::of($books)
            ->addColumn('action',function($book){
                return view('datatable._action',[
                    'model'    => $book,
                    'form_url' => route('books.destroy', $book->id),
                    'edit_url' => route('books.edit',$book->id),
                    'confirm_message' => 'Yakin Mau Menghapus'.$book->title.'?'
                ]);
            })->make(true);

            }

        $html = $htmlBuilder
        ->addColumn(['data'=>'title', 'name'=>'title', 'title'=>'Judul'])
        ->addColumn(['data'=>'amount', 'name'=>'amount', 'title'=>'Jumlah'])
        ->addColumn(['data'=>'author.name', 'name'=>'author.name', 'title'=>'Penulis'])
        ->addColumn(['data'=>'action', 'name'=>'action', 'title'=>'', 'orderable'=>false,'searchable'=>false]);
        return view('books.index')->with(compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('books.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        //

        $book = Book::create($request->except('cover'));

        //Isi Field Cover Jika ada Cover yang Diupload
        if ($request->hasFile('cover')) {
            //Mengambil File yang Diupload
            $uploaded_cover = $request->file('cover');

            //Mengambil Extension File
            $extension = $uploaded_cover->getClientOriginalExtension();

            //Membuat Nama File Random berikut Extension
            $filename = md5(time()).'.'.$extension;

            //Menyimpan Cover ke Folder Public/img
            $destinationPath = public_path().DIRECTORY_SEPARATOR.'img';
            $uploaded_cover->move($destinationPath,$filename);

            //Mengisi Field Cover di Book dengan filename yang baru Dibuat
            $book->cover = $filename;
            $book->save();
        }

        Session::flash("flash_notification",["level"=>"success","message"=>"Berhasil Menyimpan $book->title"]);

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $book = Book::find($id);
        return view('books.edit')->with(compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id)
    {
        //

        $book = Book::find($id);
        $book->update($request->all());

        if($request->hasFile('cover')) {
            //Mengambil Cover yang Diupload berikut Ekstensinya
            $filename = null;
            $uploaded_cover = $request->file('cover');
            $extension = $uploaded_cover->getClientOriginalExtension();

            //Membuat Nama File Random dengan Extention
            $filename = md5(time()).'.'.$extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR. 'img';

            //Memindahkan File ke Folder Public/img
            $uploaded_cover->move($destinationPath, $filename);

            //Hapus Cover Lama,jika ada
            if ($book->cover) {
                $old_cover = $book->cover;
                $filepath = public_path().DIRECTORY_SEPARATOR. 'img' .DIRECTORY_SEPARATOR. $book->cover;

                try{
                    File::delete($filepath);
                } catch (FileNotFoundException $e) {
                    //File sudah Dihapus/tidak ada
                }
            }

            //Ganti Field Cover dengan Cover yang Baru
            $book->cover = $filename;
            $book->save();
            }

            Session::flash("flash_notification",["level"=>"success","message"=>"Berhasil Menyimpan $book->title"]);

            return redirect()->route('books.index');
        }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        //Hapus Cover Lama,Jika ada
        if ($book->cover) {
                $old_cover = $book->cover;
                $filepath = public_path().DIRECTORY_SEPARATOR. 'img' .DIRECTORY_SEPARATOR. $book->cover;

                try{
                    File::delete($filepath);
                } catch (FileNotFoundException $e) {
                    //File sudah Dihapus/tidak ada
                }
            }

            $book->delete();

            Session::flash("flash_notification",["level"=>"success","message"=>"Buku Berhasil Dihapus"]);

            return redirect()->route('books.index');
        }
    }

