<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Reporte5Export implements FromArray, WithColumnWidths, WithStyles, WithColumnFormatting, WithDrawings, WithEvents
{
    protected $data;
    protected $cont;
    protected $registrosimp;

    public function __construct(array $data, $cont, $registrosimp)
    {
        $this->data = $data;
        $this->cont = $cont;
        $this->registrosimp = $registrosimp;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function drawings()
    {
        $cont = $this->cont;
        $registrosimp = $this->registrosimp;

        $response = [];
        foreach ($registrosimp as $key => $registro) {
            $celdaG ='G'.strval((intval($cont)+intval($key)+1));

            if($registro->idImagens != '0'){
                $drawing = new Drawing();
                //$drawing->setName('Logo');
                //$drawing->setDescription('Logo');
                $drawing->setPath(public_path('/web/imagen/'.$registro->ruta_imgImagens));
                $drawing->setHeight(130);
                $drawing->setCoordinates($celdaG);
                //$drawing->setOffsetX(10);
                //$drawing->setOffsetY(10);
                //$drawing->setWorksheet($this->sheet);
                array_push($response, $drawing);
            }
        }


        return $response;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                foreach ($this->registrosimp as $key => $registro) {
                    $row =strval((intval($this->cont)+intval($key)+1));
                    $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight(100);
                }            
     
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A'=>'7',
            'B'=>'25',
            'C'=>'50',
            'D'=>'40',
            'E'=>'25',
            'F'=>'30',
            'G'=>'50',  
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:G1');

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 15,
                'color' => ['argb' => 'FFFFFF'],

            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '0C73E8',
                ],
                'endColor' => [
                    'argb' => '0C73E8',
                ],
            ],
        ];

        $styleArray2 = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => '000000'],

            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'B4B9E1',
                ],
                'endColor' => [
                    'argb' => 'B4B9E1',
                ],
            ],
        ];

        $styleArray3 = [
            'font' => [
                'color' => ['argb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $filas = count($this->data);
        $cont = $this->cont;

        $celdaTitles ='A'.strval($cont).':G'.strval($cont);


        $sheet->getStyle('A1:G1')->applyFromArray($styleArray);
        $sheet->getStyle($celdaTitles)->applyFromArray($styleArray2);


        if($filas > $cont) {
            for ($i=$cont; $i < $filas; $i++) { 
                $celdaA ='A'.strval((1+intval($i)));
                $celdaB ='B'.strval((1+intval($i)));
                $celdaC ='C'.strval((1+intval($i)));
                $celdaD ='D'.strval((1+intval($i)));
                $celdaE ='E'.strval((1+intval($i)));
                $celdaF ='F'.strval((1+intval($i)));
                $celdaG ='G'.strval((1+intval($i)));

                $sheet->getStyle($celdaA)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaB)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaC)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaD)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaE)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaF)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaG)->applyFromArray($styleArray3);
            }
        }
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }

}