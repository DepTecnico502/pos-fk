<?php

namespace App\Http\Controllers;

use App\Models\DetalleVentas;
use App\Models\Ventas;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new Fpdf();
    }

    public function venta($id)
    {
        $detalleVentas = DetalleVentas::where('venta_id', $id)->get();
        $venta =  Ventas::find($id);

        $this->pdf->SetMargins(17,17,17);
        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();

        $this->pdf->SetDrawColor(23,83,201);

        // Logo
        $logo = public_path('assets/img/logo/logo.png');
        $this->pdf->Image($logo,78,12,60,15,'PNG');
  
        $this->pdf->Ln(9);

        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetTextColor(39,39,51);

        $this->pdf->Cell(182,9,iconv("UTF-8", "ISO-8859-1","Ave. Ismael Arriaza zona 3, Sanarate, El Progreso"),0,0,'C');
        $this->pdf->Ln(5);
        $this->pdf->Cell(182,9,iconv("UTF-8", "ISO-8859-1","(502) 5017 2353 / (502) 7796-7928"),0,0,'C');
        $this->pdf->Ln(5);
        $this->pdf->Cell(182,9,iconv("UTF-8", "ISO-8859-1","imagenyproduccionesfk@gmail.com"),0,0,'C');

        $this->pdf->Ln(13);

        // Datos del cliente
        $this->pdf->Cell(4);
        $this->pdf->SetFont('Arial','B',14);
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1","Datos del cliente:"),0,0,'C');

        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(144,7,iconv("UTF-8", "ISO-8859-1",strtoupper($venta->TipoDocumento->tipo_documento." #" . $venta->documento)),0,0,'R');

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(14,7,iconv("UTF-8", "ISO-8859-1","Nombre:"),0,0);
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$venta->cliente->nombre),0,0,'L');

        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(198,7,iconv("UTF-8", "ISO-8859-1",strtoupper(date('d-m-Y', strtotime($venta->created_at)))),0,0,'C');

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(8,7,iconv("UTF-8", "ISO-8859-1","NIT:"),0,0,'L');
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$venta->cliente->rut),0,0,'L');

        $this->pdf->Ln(7);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1","Telefono:"),0,0,'L');
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$venta->cliente->telefono),0,0,'L');

        $this->pdf->Ln(15);

        // Tabla de productos (header)
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetFillColor(23,83,201);
        $this->pdf->SetDrawColor(23,83,201);
        $this->pdf->SetTextColor(255,255,255);
        $this->pdf->Cell(20,8,iconv("UTF-8", "ISO-8859-1","Código"),1,0,'C',true);
        $this->pdf->Cell(90,8,iconv("UTF-8", "ISO-8859-1","Descripción"),1,0,'C',true);
        $this->pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Cantidad"),1,0,'C',true);
        $this->pdf->Cell(25,8,iconv("UTF-8", "ISO-8859-1","Precio Unit."),1,0,'C',true);
        $this->pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Desc %"),1,0,'C',true);
        $this->pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Total"),1,0,'C',true);

        $this->pdf->Ln(8);

        // Productos
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(39,39,51);
        foreach ($detalleVentas as $d)
        {
            $this->pdf->Cell(20,7,iconv("UTF-8", "ISO-8859-1",$d->Producto->cod_interno), 1, 0, 'C', 0);
            $this->pdf->Cell(90,7,iconv("UTF-8", "ISO-8859-1",$d->Producto->descripcion), 1, 0, 'L', 0);
            $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$d->cantidad), 1, 0, 'C', 0);
            $this->pdf->Cell(25,7,iconv("UTF-8", "ISO-8859-1",$d->precio_venta), 1, 0, 'C', 0);
            $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$d->descuento), 1, 0, 'C', 0);
            $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$d->precio_venta * $d->cantidad), 1, 0, 'C', 0);
            $this->pdf->Ln(7);

            if($d->observacion != null)
            {
                $this->pdf->MultiCell(180,7,iconv("UTF-8", "ISO-8859-1","Nota: ".$d->observacion),1,0,false);
            }
        }

        // Subtotal
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(22,10,iconv("UTF-8", "ISO-8859-1","SUBTOTAL: "),0,0,'C');
        $this->pdf->Cell(32,10,iconv("UTF-8", "ISO-8859-1","Q." . $venta->monto_total),0,0,'L');

        if($venta->estado === 0)
        {
            $this->pdf->Ln(10);
            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->Cell(180,5,iconv("UTF-8", "ISO-8859-1","ANULADA"),0,0,'C');
        }

        // Nombre del pdf
        $this->pdf->Output("I","PDF_Nro_".$venta->id.".pdf",true);

        exit();
    }
}
