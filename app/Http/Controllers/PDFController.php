<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class PDFController extends Controller
{
    /**
     * @var PDF
     */
    protected $pdf;

    /**
     * Create a new controller instance.
     *
     * @param PDF $pdf
     */
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Generate PDF.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to Laravel PDF',
            'date' => date('m/d/Y')
        ];

        return $this->pdf->loadView('pdf.invoice', $data)->download('invoice.pdf');
    }
}

