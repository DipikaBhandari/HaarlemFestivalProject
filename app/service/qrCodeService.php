<?php

namespace App\service;


class qrCodeService
{
    public function generateQrCode($orderHash){
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($orderHash)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin);
        return $result;
    }
}