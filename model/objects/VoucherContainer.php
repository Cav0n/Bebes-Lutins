<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 13/12/2018
 * Time: 14:19
 */

class VoucherContainer
{
    private $voucher;

    /**
     * VoucherContainer constructor.
     * @param $voucher
     */
    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * @return Voucher
     */
    public function getVoucher(): Voucher
    {
        return $this->voucher;
    }

    /**
     * @param Voucher $voucher
     */
    public function setVoucher(Voucher $voucher): void
    {
        $this->voucher = $voucher;
    }
}