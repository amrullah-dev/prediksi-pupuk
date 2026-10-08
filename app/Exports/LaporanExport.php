<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $jenis;

    public function __construct(Collection $data, $jenis)
    {
        $this->data = $data;
        $this->jenis = $jenis;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {

            switch ($this->jenis) {

                case 'historis':

                    return [
                        'ID Historis' => $item->id_historis,
                        'Periode' => Carbon::parse($item->periode)->translatedFormat('F Y'),
                        'Nama Kios' => $item->kios->nama_kios,
                        'Jenis Pupuk' => $item->jenisPupuk->nama_pupuk,
                        'Jumlah Penyaluran (Kg)' => $item->jumlah_penyaluran,
                    ];

                case 'prediksi':

                    return [
                        'ID Prediksi' => $item->id_prediksi,
                        'Periode' => Carbon::parse($item->periode)->translatedFormat('F Y'),
                        'Nama Kios' => $item->kios->nama_kios,
                        'Jenis Pupuk' => $item->jenisPupuk->nama_pupuk,
                        'Hasil Prediksi (Kg)' => $item->hasil_prediksi,
                    ];

                case 'safety':

                    return [
                        'ID Safety' => $item->id_safety,
                        'Periode' => Carbon::parse($item->periode)->translatedFormat('F Y'),
                        'Jumlah Stok (Kg)' => $item->stokPupuk->jumlah_stok,
                        'Safety Stok (Kg)' => $item->safety_stok,
                        'Siap Salur (Kg)' => $item->siap_salur,
                    ];

                default:

                    return [
                        'ID Penyaluran'          => $item->id_penyaluran,
                        'Periode'                => Carbon::parse($item->periode)->translatedFormat('F Y'),
                        'Jenis Pupuk'            => $item->jenisPupuk->nama_pupuk,
                        'Nama Kios'              => $item->kios->nama_kios,
                        'Hasil Prediksi (Kg)'    => $item->prediksi->hasil_prediksi,
                        'Proporsi (%)'           => $item->proporsi,
                        'Jumlah Penyaluran (Kg)' => $item->jumlah_penyaluran,
                    ];
            }
        });
    }

    public function headings(): array
    {
        switch ($this->jenis) {

            case 'historis':

                return [
                    'ID Historis',
                    'Periode',
                    'Nama Kios',
                    'Jenis Pupuk',
                    'Jumlah Penyaluran (Kg)',
                ];

            case 'prediksi':

                return [
                    'ID Prediksi',
                    'Periode',
                    'Nama Kios',
                    'Jenis Pupuk',
                    'Hasil Prediksi (Kg)',
                ];

            case 'safety':

                return [
                    'ID Safety',
                    'Periode',
                    'Jumlah Stok (Kg)',
                    'Safety Stok (Kg)',
                    'Siap Salur (Kg)',
                ];

            default:

                return [
                    'ID Penyaluran',
                    'Periode',
                    'Jenis Pupuk',
                    'Nama Kios',
                    'Hasil Prediksi (Kg)',
                    'Proporsi (%)',
                    'Jumlah Penyaluran (Kg)',
                ];
        }
    }
}