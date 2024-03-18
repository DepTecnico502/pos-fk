<?php

namespace App\Http\Controllers;

use App\Models\DetalleVentas;
use App\Models\Ventas;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new Fpdf('P','mm', array(80,297));
    }

    public function venta($id)
    {
        $detalleVentas = DetalleVentas::where('venta_id', $id)->get();
        $venta = Ventas::find($id);

        $this->pdf->SetMargins(4,10,4);
        $this->pdf->AddPage();
        
        # Encabezado y datos de la empresa #
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(0,0,0);

        // Logo
        $logo = public_path('assets/img/logo/logo.png');
        $this->pdf->Image($logo,10 ,5, 60 , 15,'PNG');
        $this->pdf->Ln(10);

        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Ave. Ismael Arriaza zona 3, Sanarate, El Progreso"),0,'C',false);
        // $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: (502) 5017 2353 / (502) 7796-7928"),0,'C',false);
        // $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: imagenyproduccionesfk@gmail.com"),0,'C',false);

        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);

        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".date('d-m-Y', strtotime($venta->created_at))),0,'C',false);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cajero: ".$venta->user->name),0,'C',false);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper($venta->TipoDocumento->tipo_documento." #" . $venta->documento)),0,'C',false);
        $this->pdf->SetFont('Arial','',9);

        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);

        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: ".$venta->Cliente->nombre),0,'C',false);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","NIT: ".$venta->CLiente->rut),0,'C',false);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$venta->CLiente->telefono),0,'C',false);

        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(3);

        // # Tabla de productos #
        $this->pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
        $this->pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
        $this->pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1","Desc. %"),0,0,'C');
        $this->pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');

        $this->pdf->Ln(3);
        $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(3);

        // /*----------  Detalles de la tabla  ----------*/
        foreach ($detalleVentas as $d)
        {
            // $this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1",$d->Producto->descripcion),0,'C',false);
            $this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1",$d->Producto->descripcion),0,0,false);
            $this->pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$d->cantidad),0,0,'C');
            $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1","Q.".$d->precio_venta),0,0,'C');
            $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",$d->descuento),0,0,'C');
            $this->pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1","Q.".$d->precio_venta * $d->cantidad),0,0,'C');
            $this->pdf->Ln(4);
            if($d->observacion != null)
            {
                $this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1","Nota: ".$d->observacion),0,0,false);
            }
            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(3);
        }
        // /*----------  Fin Detalles de la tabla  ----------*/

        // # Impuestos & totales #
        $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),0,0,'C');
        $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Q." . $venta->monto_total),0,0,'C');

        // Fecha de entrega
        if($venta->fecha_entrega){
            $this->pdf->Ln(5);
            $this->pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Fecha de entrega: "),0,0,'C');
            $this->pdf->Cell(38,5,iconv("UTF-8", "ISO-8859-1", date('d-m-Y', strtotime($venta->fecha_entrega))),0,0,'L');
        }

        if($venta->estado === 0)
        {
            $this->pdf->Ln(10);
            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","ANULADA"),0,0,'C');
        }

        $this->pdf->Ln(15);

        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su compra"),'',0,'C');

        # Nombre del archivo PDF #
        header('Content-type: application/pdf');
        $this->pdf->Output("I","Ticket_Nro_".$venta->id.".pdf",true);

        exit();
    }
}
