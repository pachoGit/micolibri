<?php 
namespace App\Controllers;
use CodeIgniter\Controller;

class Reportes extends Controller
{
    public function alumnos()
    {
        session_start();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/funcsAjax/reporte_alumnos",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>
            "desde=".$_POST["desde"].
            "&hasta=".$_POST["hasta"].
            "&cliente=".$_SESSION["cliente"],
            CURLOPT_HTTPHEADER => array(
                $_SESSION["auth"],
                "Cliente:".$_SESSION["cliente"]
                                        ),
                                       ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 14);
        $this->titulo($pdf, "Reporte de alumnos");
        $pdf->SetFont("Arial", "", 12);
        $this->fechas($pdf, $_POST["desde"], $_POST["hasta"]);
        $this->tabla_persona($pdf, $data);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output();
    }

    public function profesores()
    {
        session_start();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/funcsAjax/reporte_profesores",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>
            "desde=".$_POST["desde"].
            "&hasta=".$_POST["hasta"].
            "&cliente=".$_SESSION["cliente"],
            CURLOPT_HTTPHEADER => array(
                $_SESSION["auth"],
                "Cliente:".$_SESSION["cliente"]
                                        ),
                                       ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 14);
        $this->titulo($pdf, "Reporte de profesores");
        $pdf->SetFont("Arial", "", 12);
        $this->fechas($pdf, $_POST["desde"], $_POST["hasta"]);
        $this->tabla_persona($pdf, $data);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output();

    }


    public function matriculas()
    {
        session_start();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/funcsAjax/reporte_matricula",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>
            "desde=".$_POST["desde"].
            "&hasta=".$_POST["hasta"].
            "&cliente=".$_SESSION["cliente"],
            CURLOPT_HTTPHEADER => array(
                $_SESSION["auth"],
                "Cliente:".$_SESSION["cliente"]
                                        ),
                                       ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 14);
        $this->titulo($pdf, "Reporte de matriculas de alumnos");
        $pdf->SetFont("Arial", "", 11);
        $this->fechas($pdf, $_POST["desde"], $_POST["hasta"]);
        $this->tabla_matricula($pdf, $data);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output();

    }

    // Argumentos pasados por referencia es decir
    // paso la direccion de memoria de la variable ($pdf) para enterderlo
    // mejor leer (argumentos pasados por referencia C/C++)
    public function fechas(&$pdf, $desde, $hasta)
    {
        $pdf->Cell(40, 10, "Desde: ".$desde);
        $pdf->Cell(20); // Movernos a la derecha
        $pdf->Cell(40, 10, "Hasta: ".$hasta);
        $pdf->Cell(30); // Movernos a la derecha
        $pdf->Cell(40, 10, "Fecha de consulta: ".date("Y-m-d"));
        $pdf->Ln();
    }

    public function titulo(&$pdf, $titulo)
    {
        $pdf->Ln();
        $pdf->Cell(60, 10, $titulo);
        $pdf->Ln();
    }

    // Esto solo es para alumnos y profesores
    public function tabla_persona(&$pdf, $data)
    {
        $cabecera = ["Nombres", "Apellidos", "DNI", "Edad"];
        $tams = [65, 65, 40, 20];
        // Definimos colores
        $pdf->SetFillColor(255,0,0);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128,0,0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');
        // Formamos la cabecera de la tabla
        $c = 0;
        foreach($cabecera as $col)
            $pdf->Cell($tams[$c++], 7, $col, 1, 0, "C", true);
        $pdf->Ln();
        // Volvemos a los colores normales
        $pdf->SetFillColor(224,235,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');


        $lleno = false;
        foreach ($data as $info)
        {
            $pdf->Cell($tams[0], 6, $info["nombres"],'LR',0,'L',$lleno);
            $pdf->Cell($tams[1], 6, $info["apellidos"],'LR',0,'L',$lleno);
            $pdf->Cell($tams[2], 6, $info["dni"],'LR',0,'R',$lleno);
            $pdf->Cell($tams[3], 6, number_format($info["edad"]),'LR',0,'R',$lleno);
            $pdf->Ln();
            $lleno = !$lleno;
        }
        $pdf->Cell(array_sum($tams), 0, "", "T");
    }

    public function tabla_matricula(&$pdf, $data)
    {
        $cabecera = ["Nombres", "Apellidos", "Periodo", "Curso", "Fecha"];
        $tams = [50, 50, 20, 40, 30];
        // Definimos colores
        $pdf->SetFillColor(255,0,0);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128,0,0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');
        // Formamos la cabecera de la tabla
        $c = 0;
        foreach($cabecera as $col)
            $pdf->Cell($tams[$c++], 7, $col, 1, 0, "C", true);
        $pdf->Ln();
        // Volvemos a los colores normales
        $pdf->SetFillColor(224,235,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');


        $lleno = false;
        foreach ($data as $info)
        {
            $pdf->Cell($tams[0], 6, $info["nombres"],'LR',0,'L',$lleno);
            $pdf->Cell($tams[1], 6, $info["apellidos"],'LR',0,'L',$lleno);
            $pdf->Cell($tams[2], 6, $info["ciclo"],'LR',0,'R',$lleno);
            $pdf->Cell($tams[3], 6, $info["curso"],'LR',0,'R',$lleno);
            $pdf->Cell($tams[4], 6, $info["fechaCreacionM"],'LR',0,'R',$lleno);
            $pdf->Ln();
            $lleno = !$lleno;
        }
        $pdf->Cell(array_sum($tams), 0, "", "T");
    }


}
