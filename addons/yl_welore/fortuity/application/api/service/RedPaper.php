<?php

//decode by http://www.yunlu99.com/
namespace app\api\service;

use app\common\Tension;
use think\Exception;
use think\Request;
class RedPaper
{
	public $amount;
	public $num;
	public $paper_min;
	public $items = array();
	public function handle()
	{
		if ($this->amount < ($validAmount = $this->paper_min * $this->num)) {
			throw new Exception("红包总金额必须≥" . $validAmount . "元");
		}
		$this->apportion();
		return ["items" => $this->items];
	}
	public function apportion()
	{
		$num = $this->num;
		$amount = $this->amount;
		while ($num >= 1) {
			if ($num == 1) {
				$coupon_amount = $this->decimal_number($amount);
			} else {
				$avg_amount = $this->decimal_number($amount / $num);
				$coupon_amount = $this->decimal_number($this->calcPaperAmount($avg_amount, $amount, $num));
			}
			$this->items[] = $coupon_amount;
			$amount -= $coupon_amount;
			--$num;
		}
		shuffle($this->items);
	}
	public function calcPaperAmount($avg_amount, $amount, $num)
	{
		if ($avg_amount <= $this->paper_min) {
			return $this->paper_min;
		}
		$coupon_amount = $this->decimal_number($avg_amount * (1 + $this->apportionRandRatio()));
		if ($coupon_amount < $this->paper_min || $coupon_amount > $this->calcPaperAmountMax($amount, $num)) {
			return $this->calcPaperAmount($avg_amount, $amount, $num);
		}
		return $coupon_amount;
	}
	public function calcPaperAmountMax($amount, $num)
	{
		return $this->paper_min + $amount - $num * $this->paper_min;
	}
	public function apportionRandRatio()
	{
		if (rand(1, 100) <= 60) {
			return rand(-70, 70) / 100;
		}
		return rand(-30, 30) / 100;
	}
	public function decimal_number($amount)
	{
		return sprintf("%01.2f", round($amount, 2));
	}
}