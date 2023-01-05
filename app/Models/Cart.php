<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	public $items = null;
	public $totalQty = 0;
	public $totalPrice = 0;

	public function __construct($oldCart){
		if($oldCart){
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}

	public function add($item, $id, $qty = 1){
		$giohang = ['qty'=>0, 'price' => ($item->promotion_price == 0)?$item->unit_price:$item->promotion_price, 'item' => $item];
		if($this->items){
			if(array_key_exists($id, $this->items)){
				$giohang = $this->items[$id];
			}
		}
		$giohang['qty']+=$qty;
		$giohang['price'] = ($item->promotion_price==0)?$item->unit_price:$item->promotion_price;
		$this->items[$id] = $giohang;
		$this->totalQty+=$qty;
		$this->totalPrice += $giohang['price']*$qty;
	}
    public function addMulti($item, $id, $qty = 1){
		$giohang = ['qty'=>0, 'price' => ($item->promotion_price == 0)?$item->unit_price:$item->promotion_price, 'item' => $item];
		if($this->items){
			if(array_key_exists($id, $this->items)){
				$giohang = $this->items[$id];
			}
		}
		$giohang['qty']+=$qty;
		$giohang['price'] = ($item->promotion_price==0)?$item->unit_price:$item->promotion_price * $giohang['qty'];
		$this->items[$id] = $giohang;
		$this->totalQty+=$qty;
		$this->totalPrice += $giohang['price']*$qty;
	}
	//xóa 1class="form-control"
	public function reduceByOne($id){
		$price = $this->items[$id]['price'];
        $this->items[$id]['qty']--;
		$this->items[$id]['price'] -= $price;
		$this->totalQty--;
		$this->totalPrice -= $price;
		if($this->items[$id]['qty']<=0){
			unset($this->items[$id]);
		}
	}
	//xóa nhiều
	public function removeItem($id){
		$this->totalQty -= $this->items[$id]['qty'];
		$this->totalPrice -= $this->items[$id]['price'];
		unset($this->items[$id]);
	}
}
