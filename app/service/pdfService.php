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
            $pdf->Ln(15);
            $textY = $pdf->GetY();
            $pdf->SetFillColor(0, 109, 119);
            $pdf->Rect(5, ($textY-5), 140, 60, 'F');
            $pdf->SetFont('Courier', 'BI', 32);
            $pdf->SetTextColor(255, 255, 255);

            //name of event
            $pdf->Cell(0, 10, $ticket['eventName'], 0, 1, 'L');
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 12);
            //name of customer
            $pdf->Cell(0, 10, 'Customer Name: ' . $ticket['firstName'] . " " . $ticket['lastName'], 0, 1, 'L');
            //date and time of event
            $pdf->Cell(0, 10, 'Date and time: ' . date('d-m-Y', strtotime($ticket['date'])) . ' ' . date('H:i', strtotime($ticket['startTime'])), 0, 1, 'L');
            $pdf->Cell(0, 10, 'Valid for: ' . $ticket['numberOfTickets'] . ' People', 0, 1, 'L');
            //QR code
            $qrCodeBuilder = Builder::create()
                ->writer(new PngWriter())
                ->data($ticket['qrHash'])
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(100)
                ->margin(0)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin);

            // Generate QR code image in PNG format
            $qrCodeImage = $qrCodeBuilder->build();

            //Save QR code image to file
            $qrCodeImagePath = '../qrCodes/' . uniqid() . '.png';
            file_put_contents($qrCodeImagePath, $qrCodeImage->getString());

            $qrCodeX = $pdf->GetPageWidth() - 60; // Right margin

            // Embed the QR code image into the PDF
            $pdf->Image($qrCodeImagePath, $qrCodeX, $textY, 50);

            $pdf->SetDrawColor(0, 109, 119);
            $pdf->SetLineWidth(0.5);
            $pdf->Rect(5, ($textY-5), 200, 60);



            $fileName = 'ticket_' . uniqid() . '.pdf';
            $pdfPath = '../tickets/' . $fileName;
            //output PDF
            $pdf->Output($pdfPath, 'F');

            return $pdfPath;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
            throw new Exception($e->getMessage());
        }
    }
}