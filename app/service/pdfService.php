<?php

namespace App\service;

use Exception;
use FPDF;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class pdfService
{
    public function createTicket($ticket){
        try {
            $pdf = new FPDF();
            $pdf->AddPage();

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Ticket Information', 0, 1, 'C');
            //name of customer
            $pdf->Cell(0, 10, 'Customer Name: ' . $ticket['firstName'] . " " . $ticket['lastName'], 0, 1, 'L');
            //name of event
            $pdf->Cell(0, 10, 'Event Name: ' . $ticket['eventName'], 0, 1, 'L');
            //date and time of event
            $pdf->Cell(0, 10, 'Date: ' . $ticket['date'] . $ticket['startTime'], 0, 1, 'L');
            //QR code
            $qrCodeBuilder = Builder::create()
                ->writer(new PngWriter())
                ->data($ticket['qrHash'])
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(100) // Adjust size as needed
                ->margin(5) // Adjust margin as needed
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin);

            // Generate QR code image in PNG format
            $qrCodeImage = $qrCodeBuilder->build();

            //Save QR code image to file
            $qrCodeImagePath = '../qrCodes/' . uniqid() . '.png';
            file_put_contents($qrCodeImagePath, $qrCodeImage->getString());

            // Embed the QR code image into the PDF
            $pdf->Image($qrCodeImagePath, null, null, 50);

            $fileName = 'ticket_' . uniqid() . '.pdf';
            $pdfPath = '../tickets/' . $fileName;
            //output PDF
            $pdf->Output($pdfPath, 'F');

            return $pdfPath;
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}