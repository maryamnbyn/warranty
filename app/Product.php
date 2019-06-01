<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded =[];

    public function storeProduct($pic)
    {
        if (!empty(request()->file('image')))
        {
            $picName = $pic->store('upload', 'asset');
            $product_Pic = pathinfo($picName, PATHINFO_BASENAME);
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
            $picName = $pic->store('upload', 'asset');
            $ProductPic = pathinfo($picName, PATHINFO_BASENAME);
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
}
