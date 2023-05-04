<?php
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportData implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return array_keys($this->data[0]);
    }

    public function collection()
    {
        return new Collection($this->data);
    }
}
