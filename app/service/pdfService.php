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

    public function createInvoice($invoiceData, $orderItems){
        try {
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFillColor(0, 109, 119); // Set background color
            $pdf->Rect(10, 10, 60, 10, 'F'); // Draw filled rectangle
            $pdf->Image('../public/img/festivalLogo.png', 10, 10, 60);

            $pdf->SetFont('Arial', '', 10);
            $pdf->Ln(15);
            $pdf->Cell(0, 5, 'Haarlem Festival Company', 0, 1, 'L');
            $pdf->Cell(0, 5, 'Bijdorplaan 15, 2015 CE Haarlem', 0, 1, 'L');
            $pdf->Cell(0, 5, 'haarlem.festival2024@gmail.com', 0, 1, 'L');
            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Invoice ' . $invoiceData['invoiceNr'], 0, 1, 'L');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, 'Invoice Date: ' . date('d-m-Y', strtotime($invoiceData['dateOfOrder'])), 0, 1, 'R');

            $pdf->Cell(0, 10, 'Invoice for: ', 0, 1, 'L');
            $pdf->SetFont('Arial', '', 10);
            //name of customer
            $pdf->Cell(0, 5, $invoiceData['firstName'] . " " . $invoiceData['lastName'], 0, 1, 'L');
            //address
            $pdf->Cell(0, 5, $invoiceData['address'], 0, 1, 'L');
            //telephone
            $pdf->Cell(0, 5, $invoiceData['phonenumber'], 0, 1, 'L');
            //email
            $pdf->Cell(0, 5, $invoiceData['email'], 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Ln(10);
            $pdf->Cell(0, 10, 'Order items: ', 0, 1, 'L');

            $pdf->SetFillColor(211, 211, 211); // Set background color
            $pdf->SetTextColor(0); // Text color
            $pdf->SetDrawColor(0); // Border color
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(70, 10, 'Event Name', 1, 0, 'L', true);
            $pdf->Cell(30, 10, 'Quantity', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Price', 1, 1, 'C', true);
            $pdf->SetFillColor(255); // Reset background color
            $pdf->SetTextColor(0); // Reset text color

            $pdf->SetFont('Arial', '', 10);
            foreach ($orderItems as $orderItem){
                $pdf->Cell(70, 6, $orderItem['eventName'], 1, 0, 'L');
                $pdf->Cell(30, 6, $orderItem['numberOfTickets'], 1, 0, 'C');
                $pdf->Cell(40, 6, chr(128) . ' ' . number_format($orderItem['price'], 2), 1, 1, 'R');
            }

            $pdf->Cell(100, 6, '9% VAT: ', 1, 0, 'R');
            $pdf->Cell(40, 6,chr(128) . ' ' . number_format($invoiceData['vatAmount'], 2), 1, 1, 'R');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(100, 6, 'Total Price: ', 1, 0, 'R');
            $pdf->Cell(40, 6,chr(128) . ' ' . number_format($invoiceData['totalPrice'], 2), 1, 1, 'R');

            $pdf->Ln(10);
            $pdf->Cell(0, 6, 'Paid on: ' . date('d-m-Y', strtotime($invoiceData['dateOfOrder'])), 0, 1, 'L');

            $fileName = 'invoice_' . $invoiceData['invoiceNr'] . '.pdf';
            $pdfPath = '../invoices/' . $fileName;
            //output PDF
            $pdf->Output($pdfPath, 'F');

            return $pdfPath;
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}