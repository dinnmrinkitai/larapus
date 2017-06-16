<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Author extends Model
{
    //
    protected $fillable = ['name'];

    public function books()
    {
    	return $this->hasMany('App\Book');
    }

    public static function boot()
    {
    	parent::boot();

    	self::deleting(function($author) {
    		//mengecek Apakah Penulis Masih Punya Buku
    		if ($author->books->count() > 0) {
    			//Menyiapkan Pesan Error
    			$html = 'Penulis tidak bisa Dihapus Karena Masih Memiliki Buku : ';
    			$html .= '<ul>';
    			foreach ($author->books as $book) {
    				$html .= "<li>$book->title</li>";
    			}
    			$html .= '</ul>';

    			Session::flash("flash_notification", ["level"=>"danger","message"=>$html]);

    			//Membatalkan Proses Penghapusan
    			return false;
    		}
    	});
    }
}
