<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Reporte4Export implements FromArray, WithColumnWidths, WithStyles
{
    protected $data;
    protected $cont;

    public function __construct(array $data, $cont)
    {
        $this->data = $data;
        $this->cont = $cont;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function columnWidths(): array
    {
        return [
            'A'=>'7',
            'B'=>'35',
            'C'=>'50',
            'D'=>'40',
            'E'=>'25',
            'F'=>'50',
            'G'=>'35',  
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

}