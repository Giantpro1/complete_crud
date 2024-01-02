<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function productList(){
        return view('products.productlist');
    }
  public function addProducts(){
        return view('products.addproduct');
    }
}
