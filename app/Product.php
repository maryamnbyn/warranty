<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded =[];
    protected $appends =['image_url'];

    public function storeProduct($pic)
    {
        if (!empty(request()->file('image')))
        {
            $get_full_name_pic = $pic->getClientOriginalName();
            $get_path_pic = $pic->storeAs('upload', $get_full_name_pic,'asset');
            $product_Pic = pathinfo($get_path_pic, PATHINFO_BASENAME);
            $this->update([
                'image' => $product_Pic
            ]);
        }
    }

    public function updateProduct($pic)
    {
        if (!empty(request()->file('image')))
        {
            unlink(public_path('picture/upload/'.$this->image));
            $get_full_name_pic = $pic->getClientOriginalName();
            $get_path_pic = $pic->storeAs('upload', $get_full_name_pic,'asset');
            $ProductPic = pathinfo($get_path_pic, PATHINFO_BASENAME);
            $this->update([
                'image' => $ProductPic
            ]);
        }
    }

    public function deleteProduct()
    {
        unlink(public_path('picture/upload/'.$this->image));
        $this->delete();
    }

    public function getImageUrlAttribute()
    {
        $url =  URL('')."/api/v1/download/$this->image";
        return $url;
    }
}
