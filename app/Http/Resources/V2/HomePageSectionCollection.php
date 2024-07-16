<?php

namespace App\Http\Resources\V2;

use App\Http\Resources\V2\BrandCollection as V2BrandCollection;
use App\Http\Resources\V2\ProductCollection as V2ProductCollection;
use App\Http\Resources\V2\Seller\BrandCollection;
use App\Http\Resources\V2\Seller\ProductCollection;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HomePageSectionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data"=> $this->collection->map(function ($item) {
                $data = [
                    "id"=>$item->id,
                    "title"=>$item->title,
                    "device_type"=>$item->device_type,
                    "section_type"=>$item->section_type,
                ];
                if($item->section_type == "product"){
                    $data["is_product"] = $item->is_product;
                   $data['products'] = new V2ProductCollection(Product::whereIn('id', $item->product_ids)->get());
                }
                if($item->section_type == 'category'){
                    $data['categories'] = new CategoryCollection(Category::whereIn('id', $item->category_ids)->get());
                }
                if($item->section_type == 'brand'){
                    $data['brands'] = new V2BrandCollection(Brand::whereIn('id', $item->brand_ids)->get());
                }
                return $data;
            }),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
