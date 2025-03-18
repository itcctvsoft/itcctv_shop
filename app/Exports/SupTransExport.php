<?php

namespace App\Exports;

use App\Models\SupTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
 
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class SupTransExport implements FromCollection, WithHeadings, WithMapping
{
    protected $suptrans;

    public function __construct($suptrans, $user)
    {
        $this->suptrans = $suptrans;
        $this->user = $user;
    }

    // Tiêu đề trang Excel
    public function title(): string
    {
        return "Báo cáo công nợ";
    }

    // Bắt đầu từ dòng thứ 3 để dành dòng 1-2 cho tiêu đề
    public function startCell(): string
    {
        return 'A2';
    }


    // Lấy dữ liệu từ Controller
    public function collection()
    {
        return $this->suptrans;
    }

    // Định nghĩa tiêu đề cột
    public function headings(): array
    {
        return [  ["BÁO CÁO CÔNG NỢ - " . strtoupper($this->user->full_name)],
        ["CÔNG NỢ HIỆN TẠI - " . number_format($this->user->budget,0,".",".")],[
            'Thời gian',
            'Loại',
            'Tăng',
            'Giảm',
            'Số dư',
         
            'Tên sản phẩm',
            'Số lượng',
            'Đơn giá',
            'Thành tiền'
        ]];
    }

    // Định dạng từng dòng dữ liệu
    public function map($sp): array
    {
        

        $rows = [];

        // Lấy danh sách sản phẩm trong giao dịch
        $products = $sp->document()->details(); // Giả sử mỗi `document()` có quan hệ `details`

     
            // Nếu không có sản phẩm, chỉ ghi thông tin giao dịch
            $rows[] = [
                $sp->created_at,
                \App\Http\Controllers\HelpController::loai_giaodich($sp->doc_type),
                $sp->operation > 0 ? number_format($sp->amount, 0, '.', ',') : '',
                $sp->operation <= 0 ? number_format($sp->amount, 0, '.', ',') : '',
                number_format($sp->total, 0, '.', ','),
                '', '', '', '', ''
            ];
            if ($products) {
            // Ghi dữ liệu sản phẩm theo từng dòng
            foreach ($products as $product) {
                $rows[] = [
                   ' ',
                    ' ',
                     ' ',
                     ' ',
                    ' ',
              
                    $product->title,  // Giả sử có product_name
                    $product->quantity,      // Giả sử có quantity
                    number_format($product->price, 0, '.', ','),  // Giả sử có unit_price
                    number_format($product->quantity * $product->price, 0, '.', ',') // Thành tiền
                ];
            }
        }

        return $rows;

    }
    public function styles(Worksheet $sheet)
    {
        // Làm đậm tiêu đề báo cáo (dòng 1)
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->mergeCells('A1:I1'); // Gộp cột từ A đến I
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Làm đậm tiêu đề cột (dòng 3)
        $sheet->getStyle('A3:I3')->getFont()->setBold(true);
    }

      // Định dạng tiêu đề file Excel
      public function registerEvents(): array
      {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Làm đậm dòng đầu tiên (tiêu đề chính)
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);

                // Gộp ô tiêu đề từ A1 đến I1
                $event->sheet->mergeCells('A1:I1');
            }
        ];
      }
}
// class SupTransExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return SupTrans::all();
//     }
// }
