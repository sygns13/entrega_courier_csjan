<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Reporte2Export implements FromArray, WithColumnWidths, WithStyles
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
            'B'=>'16',
            'C'=>'13',
            'D'=>'28',
            'E'=>'18',
            'F'=>'16',
            'G'=>'14',
            'H'=>'12',
            'I'=>'12',
            'J'=>'20',
            'K'=>'20',     
            'L'=>'12',     
            'M'=>'13',     
            'N'=>'15',     
            'O'=>'16',     
            'P'=>'16',          
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:P1');

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

        $celdaTitles ='A'.strval($cont).':P'.strval($cont);


        $sheet->getStyle('A1:P1')->applyFromArray($styleArray);
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
                $celdaH ='H'.strval((1+intval($i)));
                $celdaI ='I'.strval((1+intval($i)));
                $celdaJ ='J'.strval((1+intval($i)));
                $celdaK ='K'.strval((1+intval($i)));
                $celdaL ='L'.strval((1+intval($i)));
                $celdaM ='M'.strval((1+intval($i)));
                $celdaN ='N'.strval((1+intval($i)));
                $celdaO ='O'.strval((1+intval($i)));
                $celdaP ='P'.strval((1+intval($i)));

                $sheet->getStyle($celdaA)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaB)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaC)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaD)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaE)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaF)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaG)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaH)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaI)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaJ)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaK)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaL)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaM)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaN)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaO)->applyFromArray($styleArray3);
                $sheet->getStyle($celdaP)->applyFromArray($styleArray3);
            }
        }
    }

}